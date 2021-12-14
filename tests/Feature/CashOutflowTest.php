<?php

namespace Tests\Feature;

use App\Models\CashFlow;
use App\Models\CashOutflowDetails;
use App\Models\CostItem;
use App\Models\Nomenclature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CashOutflowTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $uri = '/api/cash-outflow';

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function testIndex(): void
    {
        $response = $this->getJson($this->uri);
        $response->assertOk();
        $responseData = json_decode($response->getContent())->data->data;
        $this->assertEmpty($responseData);

        CashFlow::factory()->outflow()->create();
        $response = $this->getJson($this->uri);
        $response->assertOk();
        $responseData = json_decode($response->getContent())->data->data;
        $this->assertEmpty($responseData);

        CashFlow::factory()->outflow()->user($this->user)->create();
        $response = $this->getJson($this->uri);
        $response->assertOk();
        $responseData = json_decode($response->getContent())->data->data;
        $this->assertNotEmpty($responseData);
    }

    public function testStore(): void
    {
        $data = $this->initData();
        $response = $this->postJson($this->uri, $data);
        $response->assertOk();
        $response->assertJsonStructure(['data' => ['id', 'date', 'sum', 'details']]);
        $responseData = json_decode($response->getContent())->data;

        /** @var CashFlow $cashOutflow */
        $this->assertNotNull($cashOutflow = CashFlow::find($responseData->id));
        $this->assertSame((float)collect($data['details'])->sum(fn($item) => $item['count'] * $item['cost']), $cashOutflow->sum);
    }

    public function testShow(): void
    {
        $response = $this->getJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var CashFlow $cashOutflow */
        $cashOutflow = CashFlow::factory()->outflow()->create();
        $response = $this->getJson($this->uri . "/$cashOutflow->id");
        $response->assertForbidden();

        /** @var CashFlow $cashOutflow */
        $cashOutflow = CashFlow::factory()->outflow()->user($this->user)->create();
        $response = $this->getJson($this->uri . "/$cashOutflow->id");
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $response = $this->putJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var CashFlow $cashOutflow */
        $cashOutflow = CashFlow::factory()->outflow()->create();
        $response = $this->putJson($this->uri . "/$cashOutflow->id");
        $response->assertForbidden();

        $data = $this->initData();
        /** @var CashFlow $cashOutflow */
        $cashOutflow = CashFlow::factory()->outflow()->user($this->user)->create();
        $response = $this->putJson($this->uri . "/$cashOutflow->id", $data);
        $response->assertOk();
        $this->assertSame((float)collect($data['details'])->sum(fn($item) => $item['count'] * $item['cost']), $cashOutflow->fresh()->sum);
    }

    public function testDestroy(): void
    {
        $response = $this->deleteJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var CashFlow $cashOutflow */
        $cashOutflow = CashFlow::factory()->outflow()->create();
        $response = $this->deleteJson($this->uri . "/$cashOutflow->id");
        $response->assertForbidden();

        /** @var CashFlow $cashOutflow */
        $cashOutflow = CashFlow::factory()->user($this->user)->outflow()->create();
        /** @var CashOutflowDetails $cashOutflowDetails */
        $cashOutflowDetails = CashOutflowDetails::factory()->create(['cash_outflow_id' => $cashOutflow->id]);

        $response = $this->deleteJson($this->uri . "/$cashOutflow->id");
        $response->assertOk();
        $this->assertNull(CashFlow::find($cashOutflow->id));
        $this->assertNull(CashOutflowDetails::find($cashOutflowDetails->id));
    }

    public function initData(): array
    {
        return [
            'date' => now()->toDateTimeString(),
            'cost_item_id' => CostItem::factory()->create()->id,
            'details' => [
                [
                    'nomenclature_id' => Nomenclature::factory()->create()->id,
                    'count' => 12,
                    'cost' => 111,
                ],
                [
                    'nomenclature_id' => Nomenclature::factory()->create()->id,
                    'count' => 12,
                    'cost' => 111,
                ]
            ],
        ];
    }
}
