<?php

namespace App\Models\Documents;

use App\Models\AbstractDocument;
use App\Models\UserRelatedModelTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashFlow extends AbstractDocument implements CashFlowInterface
{
    use UserRelatedModelTrait;

    protected $fillable = [
        'cost_item_id',
        'date',
        'user_id',
    ];

    public static function rules(): array
    {
        return [
            'date' => 'date|required',
            'cost_item_id' => 'integer|nullable',
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

    public function updateDetails(array $detailsArray)
    {
        $this->all();
        $detailsToRemove = $this->details();
        foreach ($detailsArray as $details) {
            if(isset($details['id'])) {
                $foundedDetails = $detailsToRemove->find($details['id']);
                if ($foundedDetails) {
                    $foundedDetails->update($details);
                    $detailsToRemove->where('id','<>',$details['id']);
                } else {
                    $newDetails = $this->addDetails($details);
                    $detailsToRemove->where('id','<>',$newDetails->id);
                }
            } else {
                $newDetails = $this->addDetails($details);
                $detailsToRemove->where('id','<>',$newDetails->id);
            }
        }

        $detailsToRemove->delete();

        return true;
    }
}
