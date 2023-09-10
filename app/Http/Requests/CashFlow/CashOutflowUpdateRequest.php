<?php

declare(strict_types=1);

namespace App\Http\Requests\CashFlow;

use App\Actions\CashFlows\Data\UpdateCashOutflowData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CashOutflowUpdateRequest extends FormRequest
{
    public function rules(): array
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

    public function validated($key = null, $default = null): UpdateCashOutflowData
    {
        return UpdateCashOutflowData::from(parent::validated($key, $default));
    }
}
