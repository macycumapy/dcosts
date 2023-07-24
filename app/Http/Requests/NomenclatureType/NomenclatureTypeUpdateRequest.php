<?php

declare(strict_types=1);

namespace App\Http\Requests\NomenclatureType;

use App\Actions\NomenclatureTypes\Data\NomenclatureTypeUpdateData;
use App\Models\NomenclatureType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read NomenclatureType $nomenclatureType
 */
class NomenclatureTypeUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('nomenclature_types')->where('user_id', auth()->id())->ignoreModel($this->nomenclatureType)
            ],
        ];
    }

    public function validated($key = null, $default = null): NomenclatureTypeUpdateData
    {
        return NomenclatureTypeUpdateData::from(parent::validated($key, $default));
    }
}
