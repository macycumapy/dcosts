<?php

namespace Tests\Feature;

use App\Models\CashOutflow;
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

        CashOutflow::factory()->create();
        $response = $this->getJson($this->uri);
        $response->assertOk();
        $responseData = json_decode($response->getContent())->data->data;
        $this->assertEmpty($responseData);

        CashOutflow::factory(['user_id' => $this->user->id])->create();
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

        /** @var CashOutflow $cashOutflow */
        $this->assertNotNull($cashOutflow = CashOutflow::find($responseData->id));
        $this->assertSame((float)collect($data['details'])->sum(fn($item) => $item['count'] * $item['cost']), $cashOutflow->sum);
    }

    public function testShow(): void
    {
        $response = $this->getJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var CashOutflow $cashOutflow */
        $cashOutflow = CashOutflow::factory()->create();
        $response = $this->getJson($this->uri . "/$cashOutflow->id");
        $response->assertForbidden();

        /** @var CashOutflow $cashOutflow */
        $cashOutflow = CashOutflow::factory()->create(['user_id' => $this->user->id]);
        $response = $this->getJson($this->uri . "/$cashOutflow->id");
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $response = $this->putJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var CashOutflow $cashOutflow */
        $cashOutflow = CashOutflow::factory()->create();
        $response = $this->putJson($this->uri . "/$cashOutflow->id");
        $response->assertForbidden();

        $data = $this->initData();
        /** @var CashOutflow $cashOutflow */
        $cashOutflow = CashOutflow::factory()->create(['user_id' => $this->user->id]);
        $response = $this->putJson($this->uri . "/$cashOutflow->id", $data);
        $response->assertOk();
        $this->assertSame((float)collect($data['details'])->sum(fn($item) => $item['count'] * $item['cost']), $cashOutflow->fresh()->sum);
    }

    public function testDestroy(): void
    {
        $response = $this->deleteJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var CashOutflow $cashOutflow */
        $cashOutflow = CashOutflow::factory()->create();
        $response = $this->deleteJson($this->uri . "/$cashOutflow->id");
        $response->assertForbidden();

        /** @var CashOutflow $cashOutflow */
        $cashOutflow = CashOutflow::factory()->create(['user_id' => $this->user->id]);
        /** @var CashOutflowDetails $cashOutflowDetails */
        $cashOutflowDetails = CashOutflowDetails::factory()->create(['cash_outflow_id' => $cashOutflow->id]);

        $response = $this->deleteJson($this->uri . "/$cashOutflow->id");
        $response->assertOk();
        $this->assertNull(CashOutflow::find($cashOutflow->id));
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
