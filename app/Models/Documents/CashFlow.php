<?php

namespace App\Models\Documents;

use App\Models\AbstractDocument;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashFlow extends AbstractDocument implements CashFlowInterface
{
    protected $fillable = [
        'incoming',
        'created_at',
    ];

    public static function rules(): array
    {
        return [
            'incoming' => 'required|boolean',
            'created_at' => 'date',
            'details' => 'array'
        ];
    }

    public function details():HasMany
    {
        return $this->hasMany(CashFlowDetails::class);
    }

    public function firstWithDetails()
    {
        return $this->with('details')->first();
    }

    public function addDetails(array $details)
    {
        $cashFlowDetails = $this->details()->create($details);

        return $cashFlowDetails;
    }
}
