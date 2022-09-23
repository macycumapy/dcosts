<?php

namespace App\Http\Requests\CostItem;

use App\Enums\CashFlowType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read string $name
 */
class CostItemStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('cost_items')->where('user_id', auth()->id())
            ],
            'type' => ['required', Rule::in(CashFlowType::values())],
            'foreign_id' => ['nullable', 'int'],
        ];
    }

    /**
     * @return array
     */
    public function validated($key = null, $default = null): array
    {
        return array_merge(parent::validated($key, $default), [
            'user_id' => auth()->id(),
        ]);
    }
}
