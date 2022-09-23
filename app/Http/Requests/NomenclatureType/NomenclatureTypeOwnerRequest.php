<?php

declare(strict_types=1);

namespace App\Http\Requests\NomenclatureType;

use App\Models\NomenclatureType;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read NomenclatureType $nomenclatureType
 */
class NomenclatureTypeOwnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->nomenclatureType->user_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
