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
            'name' => ['required', 'string'],
            'nomenclature_type_id' => ['nullable', 'integer', Rule::exists('nomenclature_types', 'id')],
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
