<?php

namespace App\Models;

Interface ModelInterface
{
    /**
     * Find a model by its primary key.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public static function findById($id, $columns = ['*']);

    /**
     * Get all of the models from the database.
     *
     * @param  array|mixed  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function all($columns = ['*']);

    /**
     * Create the model in the database..
     *
     * @param  array  $attributes
     * @return self | null
     */
    public function tryToCreate($attributes = []);

    /**
     * Update the model in the database.
     *
     * @param  array  $attributes
     * @param  array  $options
     * @return bool
     */
    public function tryToUpdate(array $attributes = [], array $options = []):bool;

    /**
     * Delete the model from the database.
     *
     * @return bool
     */
    public function tryToDelete():bool;

    /**
     * Rules of model attributes
     *
     * @return array
     */
    public static function rules():array;
}
