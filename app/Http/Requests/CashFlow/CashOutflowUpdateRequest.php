<?php

namespace App\Http\Requests\CashFlow;

use App\Models\CashFlow;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read CashFlow $cashFlow
 * @property-read string $date
 * @property-read array $details
 */
class CashOutflowUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->cashFlow->user_id === auth()->id();
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
            'cost_item_id' => ['nullable', Rule::exists('cost_items', 'id')],
            'details' => ['required', 'array'],
            'details.*.id' => ['nullable', Rule::exists('cash_outflow_details', 'id')],
            'details.*.nomenclature_id' => ['required', Rule::exists('nomenclatures', 'id')],
            'details.*.count' => ['required', 'numeric'],
            'details.*.cost' => ['required', 'numeric'],
        ];
    }
}
