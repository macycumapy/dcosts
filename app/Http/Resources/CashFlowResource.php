<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\CashFlow;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CashFlow
 */
class CashFlowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'sum' => $this->sum,
            'category' => $this->category->name ?? null,
            'type' => $this->type->value,
        ];
    }
}
