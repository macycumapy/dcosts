<?php

namespace App\Http\Requests\CashOutflow;

use App\Models\CashOutflow;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read CashOutflow $cashOutflow
 */
class CashOutflowOwnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->cashOutflow->user_id === auth()->id();
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
