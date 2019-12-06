<?php

namespace App\Models\Documents;

use App\Models\CRUDTrait;
use App\Models\NomenclatureInterface;
use Illuminate\Database\Eloquent\Model;

class CashFlowDetails extends Model implements CashFlowDetailsInterface
{
    use CRUDTrait;

    public $timestamps = false;
    protected $nomenclature;
    protected $cashFlow;

    protected $fillable = [
        'cash_flow_id',
        'nomenclature_id',
        'quantity',
        'cost',
        'comment',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->nomenclature = app()->make(NomenclatureInterface::class);
        $this->cashFlow = app()->make(CashFlowInterface::class);
    }

    public static function rules():array {
        return [
            'cash_flow_id' => 'required|integer',
            'nomenclature_id' => 'required|integer',
            'quantity' => 'required|integer',
            'cost' => 'required|number',
            'comment' => 'string',
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model){
            $model->nomenclature = $model->findOrAbort($model->nomenclature,$model->nomenclature_id);
            $model->cashFlow = $model->findOrAbort($model->cashFlow,$model->cash_flow_id);
        });
    }
}
