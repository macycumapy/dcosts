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
            'name' => ['required', 'string'],
            'type' => ['required', Rule::in(CashFlowType::values())]
        ];
    }

    /**
     * @return array
     */
    public function validated(): array
    {
        return array_merge(parent::validated(), [
            'user_id' => auth()->id(),
        ]);
    }
}
