<?php

declare(strict_types=1);

namespace App\Http\Requests\CashFlow;

use App\Models\CashFlow;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read CashFlow $cashFlow
 */
class CashFlowOwnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->cashFlow->user_id === auth()->id();
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
