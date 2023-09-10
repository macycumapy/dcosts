<?php

declare(strict_types=1);

namespace App\Http\Requests\Category;

use App\Actions\Category\Data\CreateCategoryData;
use App\Enums\CashFlowType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read string $name
 */
class CategoryStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('categories')->where('user_id', auth()->id())
            ],
            'type' => ['required', Rule::in(CashFlowType::values())],
        ];
    }

    public function validated($key = null, $default = null): CreateCategoryData
    {
        return CreateCategoryData::from([
            ...parent::validated($key, $default),
            'user_id' => auth()->id(),
        ]);
    }
}
