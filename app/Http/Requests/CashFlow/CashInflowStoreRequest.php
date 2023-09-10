<?php

declare(strict_types=1);

namespace App\Http\Requests\CashFlow;

use App\Actions\CashFlows\Data\CreateCashFlowData;
use App\Enums\CashFlowType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CashInflowStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'sum' => ['required', 'numeric'],
            'cost_item_id' => ['nullable', Rule::exists('cost_items', 'id')->where('user_id', auth()->id())],
            'partner_id' => ['nullable', Rule::exists('partners', 'id')->where('user_id', auth()->id())],
        ];
    }

    public function validated($key = null, $default = null): CreateCashFlowData
    {
        return CreateCashFlowData::from([
            ...parent::validated($key, $default),
            'user_id' => auth()->id(),
            'type' => CashFlowType::Inflow,
        ]);
    }
}
