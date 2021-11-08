<?php

namespace App\Http\Requests\CashInflow;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read string $date
 * @property-read float $sum
 * @property-read int|null $cost_item_id
 * @property-read int|null $partner_id
 */
class CashInflowStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => ['required', 'date'],
            'sum' => ['required', 'numeric'],
            'cost_item_id' => ['nullable', Rule::exists('cost_items', 'id')],
            'partner_id' => ['nullable', Rule::exists('partners', 'id')],
        ];
    }

    /**
     * @return array
     */
    public function validated(): array
    {
        return array_merge(parent::validated(), [
            'user_id' => $this->user()->id,
        ]);
    }
}
