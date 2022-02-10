<?php

namespace App\Http\Requests\Nomenclature;

use App\Models\Nomenclature;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read Nomenclature $nomenclature
 * @property-read string name
 * @property-read int|null nomenclature_type_id
 */
class NomenclatureUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->nomenclature->user_id === auth()->id();
    }

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
                Rule::unique('nomenclatures')->where('user_id', auth()->id())->ignoreModel($this->nomenclature)
            ],
            'nomenclature_type_id' => [
                'nullable',
                'integer',
                Rule::exists('nomenclature_types', 'id')->where('user_id', auth()->id())
            ],
        ];
    }
}
