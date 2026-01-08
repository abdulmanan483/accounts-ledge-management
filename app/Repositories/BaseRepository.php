<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use App\Libraries\CacheManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

abstract class BaseRepository implements BaseInterface
{
    protected Model $model;
    protected int $cacheTime = 60; // default minutes
    protected CacheManager $cacheManager;

    public function __construct($model)
    {
        $this->model = $model;
        $this->cacheTime = config('config.cache_time', 60);
        $this->cacheManager = new CacheManager($model, $this->cacheTime);
    }

    public function new(): Model
    {
        return $this->model->newInstance();
    }

    /**
     * General getter with search, filter, sort, pagination
     */
    private function getter($request = null, $pagination = false)
    {
        $request = $request ?: request();
        $currentPage = $request?->page ?? Paginator::resolveCurrentPage() ?? 1;

        $params = [
            'page'       => $currentPage,
            'perPage'    => $request?->perPage ?? null,
            'search'     => $request?->search ?? null,
            'sort_field' => $request?->sort_field ?? null,
            'sort_type'  => $request?->sort_type ?? null,
            'filters'    => $request?->filters ?? null,
            'with'       => $request?->with ?? null,
            'trash'      => $request?->trash ?? null,
            'pagination' => $pagination,
        ];

        // If caching is disabled, always fetch fresh data
        if (!$this->model->isCacheEnabled()) {
            return $this->runQuery($request, $pagination);
        }

        // If search/filter is applied, generate param-specific cache
        if (!empty($request?->search) || !empty($request?->filters)) {
            $data = $this->runQuery($request, $pagination);

            // Clear only this search/filter cache if exists
            $this->cacheManager->clear('search', $params);

            // Cache the main dataset (getter) for default fetch
            $this->cacheManager->put('getter', $this->runQuery(null, false));

            // Also cache this specific search result
            $this->cacheManager->put('search', $data, $params);

            return $data;
        }

        // Default getter cache
        return $this->cacheManager->remember(
            'getter',
            fn() => $this->runQuery($request, $pagination),
            $params
        );
    }

    /**
     * Core query logic
     */
    private function runQuery($request, $pagination)
    {
        $query = $this->model->newQuery();

        // Soft deletes
        if ($request?->trash) {
            if ($request->trash === 'with') $query->withTrashed();
            elseif ($request->trash === 'only') $query->onlyTrashed();
        }

        // Eager load relationships
        if ($request?->with && is_array($request->with)) {
            $query->with($request->with);
        }

        // Search
        if ($request?->search) $this->applySearch($query, $request);

        // Sort
        if ($request?->sort_field && $request?->sort_type) {
            $query->orderBy($request->sort_field, $request->sort_type);
        } else {
            $query->orderBy('id', 'desc');
        }

        // Filter
        if ($request?->filters) $this->applyFilter($query, $request);

        // Pagination
        return ($pagination || $request?->perPage)
            ? $query->paginate($request->perPage ?? 15)
            : $query->get();
    }

    protected function applySearch($query, $request)
    {
        $columns = $request->columns ?? ['name'];
        if (!is_array($columns)) $columns = [$columns];
        $searchValue = $request->search;

        if (empty($columns) || empty($searchValue)) return;

        $query->where(function ($q) use ($columns, $searchValue) {
            foreach ($columns as $column) {
                if (str_contains($column, '.')) {
                    [$relation, $relColumn] = explode('.', $column, 2);
                    if (method_exists($q->getModel(), $relation)) {
                        $q->orWhereHas($relation, fn($relQuery) => $relQuery->where($relColumn, 'like', "%$searchValue%"));
                    } else {
                        $q->orWhere($column, 'like', "%$searchValue%");
                    }
                } else {
                    $q->orWhere($column, 'like', "%$searchValue%");
                }
            }
        });
    }

    protected function applyFilter($query, $request)
    {
        foreach ($request->filters as $key => $value) {
            if (is_array($value)) $query->whereBetween($key, $value);
            else $query->where($key, $value);
        }
    }

    // -------------------------------
    // Public CRUD and Fetch Methods
    // -------------------------------

    public function all()
    {
        return $this->getter();
    }

    public function paginate()
    {
        return $this->getter(null, true);
    }

    public function find($id, $with = null, $trash = '')
    {
        return $this->findBy('id', $id, $with, $trash);
    }

    public function findBy(string $key = 'id', $value, $with = null, $trash = '')
    {
        $params = ['key' => $key, 'value' => $value, 'with' => $with, 'trash' => $trash];

        if (!$this->model->isCacheEnabled()) {
            return $this->runFind($key, $value, $with, $trash);
        }

        return $this->cacheManager->remember('findBy', fn() => $this->runFind($key, $value, $with, $trash), $params);
    }

    private function runFind($key, $value, $with, $trash)
    {
        $query = $this->model->where($key, $value);
        if ($trash === 'with') $query->withTrashed();
        elseif ($trash === 'only') $query->onlyTrashed();
        if (isset($with) && is_array($with)) $query->with($with);
        return $query->first();
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes)
    {
        $record = $this->find($id);
        $record->update($attributes);
        return $record;
    }

    public function delete(int $id): bool
    {
        $record = $this->find($id);
        return $record->delete();
    }

    public function restore(int $id)
    {
        $record = $this->find($id);
        $record->restore();
        return $record;
    }

    public function forceDelete(int $id): bool
    {
        $record = $this->find($id);
        return $record->forceDelete();
    }

    public function searchOrFilter($request)
    {
        return $this->getter($request);
    }

    public function count($request = null)
    {
        $query = $this->model->newQuery();
        if ($request?->filters) $this->applyFilter($query, $request);
        return $query->count();
    }
}
