<?php

declare(strict_types=1);

namespace App\Http\Requests\Nomenclature;

use App\Actions\Nomenclatures\Data\NomenclatureUpdateData;
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
    public function rules(): array
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

    public function validated($key = null, $default = null): NomenclatureUpdateData
    {
        return NomenclatureUpdateData::from(parent::validated($key, $default));
    }
}
