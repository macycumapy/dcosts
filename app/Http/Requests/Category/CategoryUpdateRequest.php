<?php

declare(strict_types=1);

namespace App\Http\Requests\Category;

use App\Actions\Category\Data\UpdateCategoryData;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read Category $category
 * @property-read string $name
 */
class CategoryUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('categories')->where('user_id', auth()->id())->ignoreModel($this->category)
            ],
        ];
    }

    public function validated($key = null, $default = null): UpdateCategoryData
    {
        return UpdateCategoryData::from(parent::validated($key, $default));
    }
}
