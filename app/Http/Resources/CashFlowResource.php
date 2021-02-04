<?php

namespace App\Http\Resources;

use App\Models\Documents\CashFlow;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CashFlowResource
 *
 * @mixin CashFlow
 * @package App\Http\Resources
 */
class CashFlowResource extends JsonResource
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
            'date' => Carbon::parse($this->date)->toDateTimeString(),
            'cost_item_id' => $this->cost_item_id,
            'sum' => $this->sum,
            'details' => CashFlowDetailsResource::collection($this->details),
        ];
    }
}
