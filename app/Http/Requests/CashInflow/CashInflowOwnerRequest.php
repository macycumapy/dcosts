<?php

namespace App\Http\Requests\CashInflow;

use App\Models\CashInflow;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read CashInflow $cashInflow
 */
class CashInflowOwnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->cashInflow->user_id === auth()->id();
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