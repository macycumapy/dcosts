<?php

declare(strict_types=1);

namespace App\Http\Requests\CostItem;

use App\Actions\CostItems\Data\UpdateCostItemData;
use App\Models\CostItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read CostItem $costItem
 * @property-read string $name
 */
class CostItemUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('cost_items')->where('user_id', auth()->id())->ignoreModel($this->costItem)
            ],
        ];
    }

    public function validated($key = null, $default = null): UpdateCostItemData
    {
        return UpdateCostItemData::from(parent::validated($key, $default));
    }
}
