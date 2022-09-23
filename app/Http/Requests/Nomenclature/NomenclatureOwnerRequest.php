<?php

declare(strict_types=1);

namespace App\Http\Requests\Nomenclature;

use App\Models\Nomenclature;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read Nomenclature $nomenclature
 */
class NomenclatureOwnerRequest extends FormRequest
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
            //
        ];
    }
}
