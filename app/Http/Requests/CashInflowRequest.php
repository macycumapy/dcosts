<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CashInflowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'date|required',
            'cost_item_id' => 'integer|nullable',
            'partner_id' => 'integer|nullable',
            'sum' => 'numeric|required',
        ];
    }

    public function validated()
    {
        return array_merge(parent::validated(), [
            'user_id' => $this->user()->id
        ]);
    }
}
