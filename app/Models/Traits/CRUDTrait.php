<?php

namespace App\Models\Traits;

use App\Models\ModelInterface;

Trait CRUDTrait
{
    public static function findById($id, $columns = ['*'])
    {
        return static::find($id, $columns);
    }

    public function tryToCreate($attributes = [])
    {
        try {
            return $this->create($attributes);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function tryToUpdate(array $attributes = [], array $options = []):bool
    {
        try {
            return $this->update($attributes,$options);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function tryToDelete():bool
    {
        try {
            return $this->delete();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function findOrAbort(ModelInterface $model, int $id):ModelInterface
    {
        $model = $model->findById($id);
        if (!$model) abort(response()->json([],404));

        return $model;
    }

    public function findByConditionsOrAbort(ModelInterface $model, array $conditions):ModelInterface
    {
        $model = $model->query()->where($conditions)->get()->first();
        if (!$model) abort(response()->json([],404));

        return $model;
    }
}
