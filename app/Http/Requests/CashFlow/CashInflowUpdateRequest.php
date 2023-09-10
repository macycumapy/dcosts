<?php

declare(strict_types=1);

namespace App\Http\Requests\CashFlow;

use App\Actions\CashFlow\Data\UpdateCashFlowData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CashInflowUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'sum' => ['required', 'numeric'],
            'category_id' => ['nullable', Rule::exists('categories', 'id')->where('user_id', auth()->id())],
            'partner_id' => ['nullable', Rule::exists('partners', 'id')->where('user_id', auth()->id())],
        ];
    }

    public function validated($key = null, $default = null): UpdateCashFlowData
    {
        return UpdateCashFlowData::from(parent::validated($key, $default));
    }
}
