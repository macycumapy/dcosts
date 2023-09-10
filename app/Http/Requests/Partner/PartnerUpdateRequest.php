<?php

declare(strict_types=1);

namespace App\Http\Requests\Partner;

use App\Actions\Partners\Data\UpdatePartnerData;
use App\Models\Partner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read Partner $partner
 * @property-read string $name
 */
class PartnerUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('partners')->where('user_id', auth()->id())->ignoreModel($this->partner)
            ],
        ];
    }

    public function validated($key = null, $default = null): UpdatePartnerData
    {
        return UpdatePartnerData::from(parent::validated($key, $default));
    }
}
