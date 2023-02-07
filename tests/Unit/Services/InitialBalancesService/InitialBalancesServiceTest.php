<?php

declare(strict_types=1);

namespace Tests\Unit\Services\InitialBalancesService;

use App\Models\CashFlow;
use App\Models\CostItem;
use App\Models\Partner;
use App\Models\User;
use App\Services\InitialBalancesService\DTO\InflowDTO;
use App\Services\InitialBalancesService\InflowsXlsxParser;
use App\Services\InitialBalancesService\InitialBalancesService;
use Illuminate\Http\UploadedFile;
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
        /** @var InflowDTO $inflow */
        foreach ($data as $inflow) {
            $partner = Partner::query()->firstWhere('name', $inflow->partnerName);
            $costItem = CostItem::query()->firstWhere('name', $inflow->costItemName);
            $this->assertModelExists($partner);
            $this->assertModelExists($costItem);
            $this->assertTrue(CashFlow::query()->where([
                'date' => $inflow->date,
                'sum' => $inflow->sum,
                'partner_id' => $partner->id,
                'cost_item_id' => $costItem->id,
            ])->exists());
        }
    }
}
