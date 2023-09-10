<?php

declare(strict_types=1);

namespace App\Http\Requests\Nomenclature;

use App\Actions\Nomenclatures\Data\CreateNomenclatureData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NomenclatureStoreRequest extends FormRequest
{
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
        ];
    }

    public function validated($key = null, $default = null): CreateNomenclatureData
    {
        return CreateNomenclatureData::from([
            ...parent::validated($key, $default),
            'user_id' => auth()->id(),
        ]);
    }
}
