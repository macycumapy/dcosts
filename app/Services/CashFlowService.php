<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\CashInflow;
use App\Models\CashOutflow;
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
        return $this->getCashInflowSum() - $this->getCashOutflowSum();
    }

    /**
     * @return float
     */
    private function getCashOutflowSum(): float
    {
        return (float) CashOutflow::query()
            ->select('user_id', DB::raw('SUM(sum) as sum'))
            ->ofUser($this->user)
            ->groupBy('user_id')
            ->sum('sum');
    }

    /**
     * @return float
     */
    private function getCashInflowSum(): float
    {
        return (float) CashInflow::query()
            ->select('user_id', DB::raw('SUM(sum) as sum'))
            ->ofUser($this->user)
            ->groupBy('user_id')
            ->sum('sum');
    }
}
