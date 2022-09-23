<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\CashFlowType;
use App\Models\CashFlow;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CashFlowService
{
    /**
     * @param User $user
     */
    public function __construct(private User $user)
    {
    }

    /**
     * Создание нового экземпляра класса
     * @param User $user
     * @return static
     */
    public static function make(User $user): self
    {
        return app(self::class, ['user' => $user]);
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        $outflowType = CashFlowType::Outflow->value;

        return (float) CashFlow::query()
            ->select('user_id', DB::raw("SUM(case when type = '{$outflowType}' then -sum else sum end) as sum"))
            ->ofUser($this->user)
            ->groupBy('user_id')
            ->get()
            ->sum('sum');
    }
}
