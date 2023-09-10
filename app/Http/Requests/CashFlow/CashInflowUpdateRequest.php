<?php

declare(strict_types=1);

namespace App\Http\Requests\CashFlow;

use App\Actions\CashFlows\Data\UpdateCashFlowData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CashInflowUpdateRequest extends FormRequest
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

    public function validated($key = null, $default = null): UpdateCashFlowData
    {
        return UpdateCashFlowData::from(parent::validated($key, $default));
    }
}
