<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface BaseInterface
{
    /**
     * Create a new record.
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update an existing record.
     *
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function update(Model|int $model, array $attributes);

    /**
     * Delete a record.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
    /**
     * Find a record by a specific key-value pair.
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id, $with = null, $trash = '');
    public function findBy(string $key, $value, $with = null, $trash = '');

    /**
     * Fetch all records.
     *
     * @return mixed
     */
    public function all();
    public function paginate();

    /**
     * Restore a soft-deleted record.
     *
     * @param int $id
     * @return mixed
     */
    public function restore(int $id);

    /**
     * Permanently delete a soft-deleted record.
     *
     * @param int $id
     * @return bool
     */
    public function forceDelete(int $id);

    /**
     * Get records with pagination, search, sort, and filter options.
     *
     * @param object $request
     * @param bool $export
     * @return mixed
     */
    public function searchOrFilter($request);
    public function new(): Model;
    public function count($request);
}
