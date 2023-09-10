<?php

declare(strict_types=1);

namespace App\Http\Requests\CashFlow;

use App\Actions\CashFlows\Data\CreateCashOutflowData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CashOutflowStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'cost_item_id' => ['nullable', Rule::exists('cost_items', 'id')->where('user_id', auth()->id())],
            'details' => ['required', 'array'],
            'details.*.nomenclature_id' => ['required', Rule::exists('nomenclatures', 'id')->where('user_id', auth()->id())],
            'details.*.count' => ['required', 'numeric'],
            'details.*.cost' => ['required', 'numeric'],
        ];
    }

    public function validated($key = null, $default = null): CreateCashOutflowData
    {
        return CreateCashOutflowData::from([
            ...parent::validated($key, $default),
            'user_id' => auth()->id(),
        ]);
    }
}
