<?php

declare(strict_types=1);

namespace App\Http\Requests\Partner;

use App\Models\Partner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read Partner $partner
 * @property-read string $name
 */
class PartnerUpdateRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                Rule::unique('partners')->where('user_id', auth()->id())->ignoreModel($this->partner)
            ],
        ];
    }
}
