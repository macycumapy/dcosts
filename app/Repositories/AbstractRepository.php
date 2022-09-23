<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class AbstractRepository implements IRepository
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @var Builder
     */
    protected Builder $query;


    /**
     * AbstractRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->query = $model::query();
    }

    /**
     * @inheritDoc
     */
    public function all(?array $filters = null): Collection
    {
        if ($filters) {
            $this->query->where($filters);
        }

        $this->query->orderByDesc('id');

        return $this->query->get();
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): Model
    {
        return $this->model = $this->model->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Model
    {
        return $this->model = $this->model->create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $data): Model
    {
        $this->get($id)->update($data);

        return $this->model;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        return $this->get($id)->delete();
    }

    /**
     * @param array|null $filters
     * @return LengthAwarePaginator
     */
    public function paginate(?array $filters = null): LengthAwarePaginator
    {
        if ($filters) {
            $this->query->where($filters);
        }

        $this->query->orderByDesc('id');

        return $this->query->paginate(20);
    }
}
