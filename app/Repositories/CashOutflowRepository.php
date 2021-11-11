<?php

namespace App\Repositories;

use App\Models\CashOutflow;
use App\Models\CashOutflowDetails;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CashOutflowRepository extends AbstractRepository
{
    /**
     * @param CashOutflow $model
     */
    public function __construct(CashOutflow $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function paginate(?array $filters = null): LengthAwarePaginator
    {
        $this->query->orderByDesc('date');

        return parent::paginate($filters);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function create(array $data): CashOutflow
    {
        try {
            DB::beginTransaction();
            $this->model = $this->model->create($data);
            foreach ($data['details'] as $detail) {
                $this->addDetails($detail);
            }
            $this->actualizeSum();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $this->model;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function update(int $id, array $data): Model
    {
        try {
            DB::beginTransaction();
            $this->get($id)->update($data);
            if (isset($data['details'])) {
                $this->updateDetails($data['details']);
                $this->actualizeSum();
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $this->model;
    }

    /**
     * Добавление деталей
     *
     * @param array $detail
     * @return CashOutflowDetails
     */
    protected function addDetails(array $detail): CashOutflowDetails
    {
        return $this->model->details()->create($detail);
    }


    /**
     * Перерасчет итоговой суммы по деталям
     * @return float
     */
    public function actualizeSum(): float
    {
        $this->model->sum = $this->model->details->sum('sum');
        $this->model->save();

        return $this->model->sum;
    }

    /**
     * Обновление деталей расхода
     * @param array $details
     * @return $this
     */
    protected function updateDetails(array $details): self
    {
        $detailsToRemove = $this->model->details();
        foreach ($details as $detail) {
            if (isset($detail['id'])) {
                /** @var CashOutflowDetails $foundedDetails */
                $foundedDetails = $this->model->details()->find($detail['id']);
                if ($foundedDetails) {
                    $foundedDetails->update($detail);
                    $detailsToRemove->where('id', '<>', $detail['id']);
                } else {
                    $newDetails = $this->addDetails($detail);
                    $detailsToRemove->where('id', '<>', $newDetails->id);
                }
            } else {
                $newDetails = $this->addDetails($detail);
                $detailsToRemove->where('id', '<>', $newDetails->id);
            }
        }

        if ($detailsToRemove->exists()) {
            $detailsToRemove->delete();
        }
        $this->model->load('details');
        return $this;
    }
}
