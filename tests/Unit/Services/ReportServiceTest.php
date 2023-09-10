<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\CashFlow;
use App\Models\CashOutflowDetails;
use App\Models\Category;
use App\Models\Nomenclature;
use App\Models\User;
use App\Services\ReportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportServiceTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private ReportService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->service = new ReportService($this->user);
    }

    public function testGettingOutflows(): void
    {
        CashFlow::factory()
            ->outflow()
            ->for($this->user)
            ->for(Category::factory()->for($this->user)->create())
            ->count(3)
            ->create()
            ->each(function (CashFlow $cashFlow) {
                CashOutflowDetails::factory()
                    ->for($cashFlow)
                    ->for(Nomenclature::factory()->create())
                    ->create();
            });

        $outflows = $this->service->getOutflows(now()->subDay(), now());

        self::assertTrue($outflows->isNotEmpty());
    }
}
