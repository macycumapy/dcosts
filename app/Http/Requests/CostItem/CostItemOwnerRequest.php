<?php

declare(strict_types=1);

namespace App\Http\Requests\CostItem;

use App\Models\CostItem;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read CostItem $costItem
 */
class CostItemOwnerRequest extends FormRequest
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
            //
        ];
    }
}
