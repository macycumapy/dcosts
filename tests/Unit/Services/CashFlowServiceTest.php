<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\CashFlow;
use App\Models\User;
use App\Services\CashFlowService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CashFlowServiceTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private CashFlowService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->service = CashFlowService::make($this->user);
    }

    /**
     * @dataProvider balanceDataProvider
     */
    public function testBalance($inflowSum, $outflowSum, $expected): void
    {
        CashFlow::factory()
            ->for($this->user)
            ->create(['sum' => $inflowSum]);
        CashFlow::factory()
            ->outflow()
            ->for($this->user)
            ->create(['sum' => $outflowSum]);
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
