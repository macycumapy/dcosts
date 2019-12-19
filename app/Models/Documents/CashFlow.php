<?php

namespace App\Models\Documents;

use App\Models\CRUDTrait;
use App\Models\UserRelatedModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashFlow extends Model implements CashFlowInterface
{
    use CRUDTrait, UserRelatedModelTrait;

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
        return $this->details()->create($details);
    }

    public function updateDetails(array $detailsArray)
    {
        $detailsToRemove = $this->details();
        foreach ($detailsArray as $details) {
            if(isset($details['id'])) {
                $foundedDetails = $this->details()->find($details['id']);
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

    public static function allByUserId($id, $columns = ['*'])
    {
        return static::query()->with('details')->where('user_id', $id)->get(
            is_array($columns) ? $columns : func_get_args()
        );
    }
}
