<?php

declare(strict_types=1);

namespace App\Http\Requests\CashFlow;

use App\Actions\CashFlow\Data\CreateCashOutflowData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CashOutflowStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'category_id' => ['nullable', Rule::exists('categories', 'id')->where('user_id', auth()->id())],
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
