<?php

declare(strict_types=1);

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

        CashFlow::factory()->for($this->user)->create();
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
        $this->assertEquals($data['date'], $cashInflow->date->toDateTimeString());
        $this->assertEquals($data['sum'], $cashInflow->sum);
        $this->assertEquals($data['cost_item_id'], $cashInflow->cost_item_id);
        $this->assertEquals($data['partner_id'], $cashInflow->partner_id);
    }

    public function testShow(): void
    {
        $response = $this->getJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var CashFlow $cashInflow */
        $cashInflow = CashFlow::factory()->create();
        $response = $this->getJson($this->uri . "/$cashInflow->id");
        $response->assertNotFound();

        /** @var CashFlow $cashInflow */
        $cashInflow = CashFlow::factory()->for($this->user)->create();
        $response = $this->getJson($this->uri . "/$cashInflow->id");
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $data = $this->initData();
        $response = $this->putJson($this->uri . "/9999", $data);
        $response->assertNotFound();

        /** @var CashFlow $cashInflow */
        $cashInflow = CashFlow::factory()->create();
        $response = $this->putJson($this->uri . "/$cashInflow->id", $data);
        $response->assertNotFound();

        /** @var CashFlow $cashInflow */
        $cashInflow = CashFlow::factory()->for($this->user)->create();
        $response = $this->putJson($this->uri . "/$cashInflow->id", $data);
        $response->assertOk();
        $cashInflow->refresh();
        $this->assertEquals($data['date'], $cashInflow->date->toDateTimeString());
        $this->assertEquals($data['sum'], $cashInflow->sum);
        $this->assertEquals($data['cost_item_id'], $cashInflow->cost_item_id);
        $this->assertEquals($data['partner_id'], $cashInflow->partner_id);
    }

    public function testDestroy(): void
    {
        $response = $this->deleteJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var CashFlow $cashInflow */
        $cashInflow = CashFlow::factory()->create();
        $response = $this->deleteJson($this->uri . "/$cashInflow->id");
        $response->assertNotFound();

        /** @var CashFlow $cashInflow */
        $cashInflow = CashFlow::factory()->for($this->user)->create();
        $response = $this->deleteJson($this->uri . "/$cashInflow->id");
        $response->assertOk();
        $this->assertNull(CashFlow::find($cashInflow->id));
    }

    public function initData(): array
    {
        return [
            'date' => now()->toDateTimeString(),
            'sum' => 500,
            'cost_item_id' => CostItem::factory()->for($this->user)->create()->id,
            'partner_id' => Partner::factory()->for($this->user)->create()->id,
        ];
    }
}
