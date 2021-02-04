<?php

namespace App\Http\Resources;

use App\Models\Documents\CashInflow;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CashInflowResource
 * @mixin CashInflow
 * @package App\Http\Resources
 */
class CashInflowResource extends JsonResource
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
            'date' => $this->date,
            'sum' => $this->sum,
            'cost_item_id' => $this->cost_item_id,
            'partner_id' => $this->partner_id,
        ];
    }
}
