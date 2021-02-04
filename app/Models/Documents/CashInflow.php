<?php

namespace App\Models\Documents;

use App\Models\Traits\UserRelatedModelTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int|null cost_item_id      id статьи затрат
 * @property string date                Дата
 * @property int user_id                id пользователя
 * @property int|null partner_id        id контрагента
 * @property float sum                  сумма
 *
 * Class CashInflow
 * @package App\Models\Documents
 */
class CashInflow extends Model
{
    use UserRelatedModelTrait;

    protected $fillable = [
        'cost_item_id',
        'date',
        'user_id',
        'partner_id',
        'sum',
    ];
}
