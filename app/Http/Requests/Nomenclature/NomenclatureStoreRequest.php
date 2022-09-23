<?php

namespace App\Http\Requests\Nomenclature;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read string name
 * @property-read int|null nomenclature_type_id
 */
class NomenclatureStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('nomenclatures')->where('user_id', auth()->id())
            ],
            'nomenclature_type_id' => [
                'nullable',
                'integer',
                Rule::exists('nomenclature_types', 'id')->where('user_id', auth()->id())
            ],
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
