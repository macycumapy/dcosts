<?php

declare(strict_types=1);

namespace App\Http\Requests\Partner;

use App\Models\Partner;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read Partner $partner
 */
class PartnerOwnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->partner->user_id === auth()->id();
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
