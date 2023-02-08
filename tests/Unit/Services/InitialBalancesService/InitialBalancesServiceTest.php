<?php

declare(strict_types=1);

namespace Tests\Unit\Services\InitialBalancesService;

use App\Enums\CashFlowType;
use App\Models\CashFlow;
use App\Models\CostItem;
use App\Models\Partner;
use App\Models\User;
use App\Services\InitialBalancesService\DTO\InflowDTO;
use App\Services\InitialBalancesService\InflowsXlsxParser;
use App\Services\InitialBalancesService\InitialBalancesService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tests\Traits\TestStorage;

class InitialBalancesServiceTest extends TestCase
{
    use TestStorage;

    protected InitialBalancesService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->initTestDisk();
        $this->service = app(InitialBalancesService::class);
        $this->actingAs(User::factory()->create());
    }

    public function testUploadInflows()
    {
        $file = $this->testDisk->get('InitialBalancesService/inflow.xlsx');
        $uploadFile = UploadedFile::fake()->createWithContent('file', $file);
        $result = $this->service->uploadInflows($uploadFile);
        $this->assertNotEmpty($result);
        $data = (new InflowsXlsxParser)->parse($file);

        $this->assertEquals($data->count(), $result->count());
        foreach ($data as $inflow) {
            $this->assertInflowsCreated($inflow);
        }
    }

    private function assertInflowsCreated(InflowDTO $inflow)
    {
        $partner = Partner::query()->where([
            'name' => $inflow->partnerName,
            'user_id' => Auth::id(),
        ])->first();
        $costItem = CostItem::query()->where([
            'name' => $inflow->costItemName,
            'type' => CashFlowType::Inflow,
            'user_id' => Auth::id(),
        ])->first();
        $this->assertModelExists($partner);
        $this->assertModelExists($costItem);
        $this->assertTrue(CashFlow::query()->where([
            'type' => CashFlowType::Inflow,
            'user_id' => Auth::id(),
            'date' => $inflow->date,
            'sum' => $inflow->sum,
            'partner_id' => $partner->id,
            'cost_item_id' => $costItem->id,
        ])->exists());
    }
}
