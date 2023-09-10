<?php

declare(strict_types=1);

namespace Tests\Unit\Services\InitialBalancesService;

use App\Enums\CashFlowType;
use App\Models\CashFlow;
use App\Models\Category;
use App\Models\Partner;
use App\Models\User;
use App\Services\InitialBalancesService\Data\InflowData;
use App\Services\InitialBalancesService\Data\OutflowData;
use App\Services\InitialBalancesService\Data\OutflowDetailsData;
use App\Services\InitialBalancesService\InflowsXlsxParser;
use App\Services\InitialBalancesService\InitialBalancesService;
use App\Services\InitialBalancesService\OutflowXlsxParser;
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
        $data = (new InflowsXlsxParser())->parse($file);

        $this->assertEquals($data->count(), $result->count());
        foreach ($data as $inflow) {
            $this->assertInflowsCreated($inflow);
        }
    }

    private function assertInflowsCreated(InflowData $inflow)
    {
        $partner = Partner::query()->where([
            'name' => $inflow->partnerName,
            'user_id' => Auth::id(),
        ])->first();
        $category = Category::query()->where([
            'name' => $inflow->categoryName,
            'type' => CashFlowType::Inflow,
            'user_id' => Auth::id(),
        ])->first();
        $this->assertModelExists($partner);
        $this->assertModelExists($category);
        $this->assertTrue(CashFlow::query()->where([
            'type' => CashFlowType::Inflow,
            'user_id' => Auth::id(),
            'date' => $inflow->date,
            'sum' => $inflow->sum,
            'partner_id' => $partner->id,
            'category_id' => $category->id,
        ])->exists());
    }

    public function testUploadOutflows()
    {
        $file = $this->testDisk->get('InitialBalancesService/outflow.xlsx');
        $uploadFile = UploadedFile::fake()->createWithContent('file', $file);
        $result = $this->service->uploadOutflows($uploadFile);
        $this->assertNotEmpty($result);
        $data = (new OutflowXlsxParser())->parse($file);

        $this->assertEquals($data->count(), $result->count());
        foreach ($data as $outflow) {
            $this->assertOutflowsCreated($outflow);
        }
    }

    private function assertOutflowsCreated(OutflowData $outflowDTO)
    {
        $category = Category::query()->where([
            'name' => $outflowDTO->categoryName,
            'type' => CashFlowType::Outflow,
            'user_id' => Auth::id(),
        ])->first();
        $this->assertModelExists($category);

        /** @var CashFlow $outflow */
        $outflow = CashFlow::query()->where([
            'type' => CashFlowType::Outflow,
            'user_id' => Auth::id(),
            'date' => $outflowDTO->date,
            'sum' => $outflowDTO->sum,
            'category_id' => $category->id,
        ])->first();
        $this->assertModelExists($outflow);

        foreach ($outflowDTO->details as $detail) {
            $this->assertOutflowsDetailsCreated($detail, $outflow);
        }
    }

    private function assertOutflowsDetailsCreated(OutflowDetailsData $details, CashFlow $outflow)
    {
        $this->assertTrue($outflow->details()->where([
            'count' => $details->count,
            'cost' => $details->cost,
            'comment' => $details->comment,
        ])->exists());
    }
}
