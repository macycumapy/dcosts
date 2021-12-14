<?php

namespace Tests\Feature;

use App\Models\CashFlow;
use App\Models\CostItem;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CashInflowTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $uri = '/api/cash-inflow';

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

        CashFlow::factory()->create();
        $response = $this->getJson($this->uri);
        $response->assertOk();
        $responseData = json_decode($response->getContent())->data->data;
        $this->assertEmpty($responseData);

        CashFlow::factory()->user($this->user)->create();
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
        $response->assertJsonStructure(['data' => ['id', 'date', 'sum']]);
        $responseData = json_decode($response->getContent())->data;

        /** @var CashFlow $cashInflow */
        $this->assertNotNull($cashInflow = CashFlow::find($responseData->id));
        $this->assertEmpty(array_diff_assoc($data, $cashInflow->toArray()));
    }

    public function testShow(): void
    {
        $response = $this->getJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var CashFlow $cashInflow */
        $cashInflow = CashFlow::factory()->create();
        $response = $this->getJson($this->uri . "/$cashInflow->id");
        $response->assertForbidden();

        /** @var CashFlow $cashInflow */
        $cashInflow = CashFlow::factory()->user($this->user)->create();
        $response = $this->getJson($this->uri . "/$cashInflow->id");
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $data = $this->initData();
        $response = $this->putJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var CashFlow $cashInflow */
        $cashInflow = CashFlow::factory()->create();
        $response = $this->putJson($this->uri . "/$cashInflow->id");
        $response->assertForbidden();

        /** @var CashFlow $cashInflow */
        $cashInflow = CashFlow::factory()->user($this->user)->create();
        $response = $this->putJson($this->uri . "/$cashInflow->id", $data);
        $response->assertOk();
        $this->assertEmpty(array_diff_assoc($data, $cashInflow->fresh()->toArray()));
    }

    public function testDestroy(): void
    {
        $response = $this->deleteJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var CashFlow $cashInflow */
        $cashInflow = CashFlow::factory()->create();
        $response = $this->deleteJson($this->uri . "/$cashInflow->id");
        $response->assertForbidden();

        /** @var CashFlow $cashInflow */
        $cashInflow = CashFlow::factory()->user($this->user)->create();
        $response = $this->deleteJson($this->uri . "/$cashInflow->id");
        $response->assertOk();
        $this->assertNull(CashFlow::find($cashInflow->id));
    }

    public function initData(): array
    {
        return [
            'date' => now()->toDateTimeString(),
            'sum' => 500,
            'cost_item_id' => CostItem::factory()->create()->id,
            'partner_id' => Partner::factory()->create()->id,
        ];
    }
}
