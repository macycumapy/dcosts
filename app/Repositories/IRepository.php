<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface IRepository
{
    /**
     * Получение всех данных с условиями
     *
     * @param array|null $filters
     * @return Collection
     */
    public function all(?array $filters = null): Collection;

    /**
     * Получение по ID
     *
     * @param int $id
     * @return Model
     * @throws ModelNotFoundException
     */
    public function get(int $id): Model;

    /**
     * Запись
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * Обновление по ID
     *
     * @param int $id
     * @param array $data
     * @return Model
     * @throws ModelNotFoundException
     */
    public function update(int $id, array $data): Model;

    /**
     * Удаление
     *
     * @param int $id
     * @throws ModelNotFoundException
     * @return bool
     */
    public function delete(int $id): bool;
}
