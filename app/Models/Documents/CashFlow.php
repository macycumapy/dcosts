<?php

namespace App\Models\Documents;

use App\Models\Traits\UserRelatedModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int id
 * @property int cost_item_id   id статьи затрат
 * @property string date        дата расходов
 * @property int user_id        id пользователя
 * @property float sum          сумма
 *
 * @property CashFlowDetails [] details детали
 *
 * Class CashFlow
 * @package App\Models\Documents
 */
class CashFlow extends Model
{
    use UserRelatedModelTrait;

    protected $fillable = [
        'cost_item_id',
        'date',
        'user_id',
        'sum',
    ];

    public function details(): HasMany
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
            if (isset($details['id'])) {
                $foundedDetails = $this->details()->find($details['id']);
                if ($foundedDetails) {
                    $foundedDetails->update($details);
                    $detailsToRemove->where('id', '<>', $details['id']);
                } else {
                    $newDetails = $this->addDetails($details);
                    $detailsToRemove->where('id', '<>', $newDetails->id);
                }
            } else {
                $newDetails = $this->addDetails($details);
                $detailsToRemove->where('id', '<>', $newDetails->id);
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

    public static function getSumByDetails(?array $details)
    {
        $sum = 0;
        if (isset($details)) {
            $sum = array_sum(array_map(function ($item) {
                return $item['cost'] * $item['quantity'];
            }, $details));
        }

        return $sum;
    }
}
