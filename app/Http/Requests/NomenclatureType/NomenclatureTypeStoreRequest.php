<?php

declare(strict_types=1);

namespace App\Http\Requests\NomenclatureType;

use App\Actions\NomenclatureTypes\Data\NomenclatureTypeCreateData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NomenclatureTypeStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('nomenclature_types')->where('user_id', auth()->id())
            ],
        ];
    }

    public function validated($key = null, $default = null): NomenclatureTypeCreateData
    {
        return NomenclatureTypeCreateData::from([
            ...parent::validated($key, $default),
            'user_id' => auth()->id(),
        ]);
    }
}
