<?php

declare(strict_types=1);

namespace App\Http\Requests\CashFlow;

use App\Actions\CashFlow\Data\UpdateCashOutflowData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CashOutflowUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'category_id' => ['nullable', Rule::exists('categories', 'id')],
            'details' => ['required', 'array'],
            'details.*.id' => ['nullable', Rule::exists('cash_outflow_details', 'id')],
            'details.*.nomenclature_id' => ['required', Rule::exists('nomenclatures', 'id')],
            'details.*.count' => ['required', 'numeric'],
            'details.*.cost' => ['required', 'numeric'],
        ];
    }

    public function validated($key = null, $default = null): UpdateCashOutflowData
    {
        return UpdateCashOutflowData::from(parent::validated($key, $default));
    }
}
