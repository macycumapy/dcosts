<?php

namespace Tests\Unit\Services;

use App\Models\CashInflow;
use App\Models\CashOutflow;
use App\Models\CashOutflowDetails;
use App\Models\User;
use App\Services\StatisticService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatisticServiceTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private StatisticService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->service = StatisticService::make($this->user);
    }

    /**
     * @dataProvider balanceDataProvider
     */
    public function testBalance($inflowSum, $outflowSum, $expected): void
    {
        CashInflow::factory()->create([
            'user_id' => $this->user->id,
            'sum' => $inflowSum
        ]);
        CashOutflow::factory()->create(['user_id' => $this->user->id, 'sum' => $outflowSum]);
        $this->assertSame($expected, $this->service->getBalance());
    }

    public function balanceDataProvider(): array
    {
        return [
            [0, 0, 0.0],
            [200, 100, 100.0],
            [100, 0, 100.0],
            [0, 100, -100.0],
        ];
    }
}
