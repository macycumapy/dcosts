<?php

namespace App\Http\Resources;

use App\Models\CashOutflow;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CashOutflow
 */
class CashOutflowResource extends JsonResource
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
            'date' => Carbon::parse($this->date)->toDateTimeString(),
            'cost_item_id' => $this->cost_item_id,
            'sum' => $this->sum,
            'details' => CashOutflowDetailsResource::collection($this->details),
        ];
    }
}
