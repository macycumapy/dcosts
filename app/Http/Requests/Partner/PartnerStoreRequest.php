<?php

declare(strict_types=1);

namespace App\Http\Requests\Partner;

use App\Actions\Partners\Data\PartnerCreateData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read string $name
 */
class PartnerStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('partners')->where('user_id', auth()->id())
            ],
        ];
    }

    public function validated($key = null, $default = null): PartnerCreateData
    {
        return PartnerCreateData::from([
            ...parent::validated($key, $default),
            'user_id' => auth()->id(),
        ]);
    }
}
