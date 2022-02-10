<?php

namespace App\Http\Requests\Partner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read string $name
 */
class PartnerStoreRequest extends FormRequest
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
                Rule::unique('partners')->where('user_id', auth()->id())
            ],
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
