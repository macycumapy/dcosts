<?php

namespace App\Http\Requests\CashInflow;

use App\Models\CashInflow;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read CashInflow $cashInflow
 * @property-read string $date
 * @property-read float $sum
 * @property-read int|null $cost_item_id
 * @property-read int|null $partner_id
 */
class CashInflowUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->cashInflow->user_id === auth()->id();
    }

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
}