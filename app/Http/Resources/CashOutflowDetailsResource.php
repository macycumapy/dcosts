<?php

namespace App\Http\Resources;

use App\Models\CashOutflowDetails;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CashOutflowDetails
 */
class CashOutflowDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nomenclature_id' => $this->nomenclature_id,
            'count' => $this->count,
            'cost' => $this->cost,
            'sum' => $this->sum,
        ];
    }
}
