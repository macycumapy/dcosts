<?php

namespace App\Http\Requests;

use App\Models\Documents\CashFlow;
use Illuminate\Foundation\Http\FormRequest;

class CashFlowRequest extends FormRequest
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
            'details' => 'array|nullable',
            'details.*.id' => 'integer|nullable',
            'details.*.nomenclature_id' => 'integer|required',
            'details.*.quantity' => 'integer|required',
            'details.*.cost' => 'numeric|required',
        ];
    }

    public function validated()
    {
        return array_merge(parent::validated(), [
            'user_id' => $this->user()->id,
            'sum' => CashFlow::getSumByDetails($this->details ?? null),
        ]);
    }

}
