<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;

abstract class BaseRepository implements BaseInterface
{
    protected Model $model;
    protected int $cacheTime = 60; // minutes

    public function __construct($model)
    {
        $this->model = $model;
    }
    public function new(): Model
    {
        return $this->model->newInstance();
    }

    /**
     * Generate cache key with version
     */
    protected function cacheKey(string $method, array $params = []): string
    {
        $model = class_basename($this->model);
        $version = Cache::get("{$model}.cache_version", 1);
        $paramString = $params ? '.' . md5(json_encode($params)) : '';
        return "{$model}.v{$version}.{$method}{$paramString}";
    }

    /**
     * General getter with search, filter, sort, pagination
     */
    private function getter($request = null, $pagination = false)
    {
        $request = $request ?: request();
        // Resolve current page properly for pagination
        $currentPage = $request?->page ?? Paginator::resolveCurrentPage() ?? 1;

        $params = [
            'request'    => $request,
            'pagination' => $pagination,
            'page'       => $currentPage,
            'perPage'    => $request?->perPage ?? null,
        ];

        $key = $this->cacheKey('getter', $params);

        return Cache::remember($key, $this->cacheTime * 60, function () use ($request, $pagination) {
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
        });
    }

    protected function applySearch($query, $request)
    {
        $columns = $request->column ? [$request->column] : ['name', 'description'];
        $query->where(function ($q) use ($request, $columns) {
            foreach ($columns as $column) {
                $q->orWhere($column, 'like', '%' . $request->search . '%');
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

    // --- PUBLIC METHODS ---

    public function all()
    {
        $params = ['page' => 1]; // default page
        return Cache::remember($this->cacheKey('all', $params), $this->cacheTime * 60, fn() => $this->getter());
    }

    public function paginate()
    {
        $currentPage = Paginator::resolveCurrentPage() ?? 1;
        $params = ['page' => $currentPage];
        return Cache::remember($this->cacheKey('paginate', $params), $this->cacheTime * 60, fn() => $this->getter(null, true));
    }

    public function find(int $id, $with = null, $trash = '')
    {
        return Cache::remember($this->cacheKey('find', ['id' => $id, 'trash' => $trash]), $this->cacheTime * 60, function () use ($id, $trash) {
            $query = $this->model->query();
            if ($trash === 'with') $query->withTrashed();
            elseif ($trash === 'only') $query->onlyTrashed();
            // Eager load relationships
            if (isset($with) && is_array($with)) {
                $query->with($with);
            }
            return $query->findOrFail($id);
        });
    }

    public function findByKey(string $key, $value, $trash = '')
    {
        return Cache::remember($this->cacheKey('findByKey', ['key' => $key, 'value' => $value, 'trash' => $trash]), $this->cacheTime * 60, function () use ($key, $value, $trash) {
            $query = $this->model->where($key, $value);
            if ($trash === 'with') $query->withTrashed();
            elseif ($trash === 'only') $query->onlyTrashed();
            return $query->first();
        });
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

    public function searchOrfilter($request, $export = false)
    {
        return $this->getter($request, $export);
    }
}
