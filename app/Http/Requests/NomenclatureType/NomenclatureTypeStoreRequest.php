<?php

namespace App\Http\Requests\NomenclatureType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NomenclatureTypeStoreRequest extends FormRequest
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
                Rule::unique('nomenclature_types')->where('user_id', auth()->id())
            ],
            'foreign_id' => ['nullable', 'int'],
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
