<?php

namespace App\Http\Requests\CostItem;

use App\Models\CostItem;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read CostItem $costItem
 * @property-read string $name
 */
class CostItemUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->costItem->user_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
        ];
    }
}
