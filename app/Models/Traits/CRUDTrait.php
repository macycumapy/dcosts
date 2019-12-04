<?php

namespace App\Models;

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
}
