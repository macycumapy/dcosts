<?php

declare(strict_types=1);

namespace App\Http\Requests\CashFlow;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read string $date
 * @property-read array $details
 */
class CashOutflowStoreRequest extends FormRequest
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
            'cost_item_id' => ['nullable', Rule::exists('cost_items', 'id')],
            'foreign_id' => ['nullable', 'int'],
            'details' => ['required', 'array'],
            'details.*.nomenclature_id' => ['required', Rule::exists('nomenclatures', 'id')],
            'details.*.count' => ['required', 'numeric'],
            'details.*.cost' => ['required', 'numeric'],
        ];
    }

    /**
     * @return array
     */
    public function validated($key = null, $default = null): array
    {
        return array_merge(parent::validated($key, $default), [
            'user_id' => $this->user()->id,
        ]);
    }
}
