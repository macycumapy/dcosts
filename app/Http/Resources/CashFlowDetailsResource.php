<?php

namespace App\Http\Resources;

use App\Models\Documents\CashFlowDetails;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CashFlowDetailsResource
 *
 * @mixin CashFlowDetails
 * @package App\Http\Resources
 */
class CashFlowDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nomenclature_id' => $this->nomenclature_id,
            'quantity' => $this->quantity,
            'cost' => $this->cost,
        ];
    }
}
