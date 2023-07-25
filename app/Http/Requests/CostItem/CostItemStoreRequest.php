<?php

declare(strict_types=1);

namespace App\Http\Requests\CostItem;

use App\Actions\CostItems\Data\CreateCostItemData;
use App\Enums\CashFlowType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read string $name
 */
class CostItemStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('cost_items')->where('user_id', auth()->id())
            ],
            'type' => ['required', Rule::in(CashFlowType::values())],
        ];
    }

    public function validated($key = null, $default = null): CreateCostItemData
    {
        return CreateCostItemData::from([
            ...parent::validated($key, $default),
            'user_id' => auth()->id(),
        ]);
    }
}
