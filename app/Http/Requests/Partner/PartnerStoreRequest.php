<?php

declare(strict_types=1);

namespace App\Http\Requests\Partner;

use App\Actions\Partner\Data\CreatePartnerData;
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

    public function validated($key = null, $default = null): CreatePartnerData
    {
        return CreatePartnerData::from([
            ...parent::validated($key, $default),
            'user_id' => auth()->id(),
        ]);
    }
}
