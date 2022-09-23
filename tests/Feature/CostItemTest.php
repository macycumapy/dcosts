<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\CashFlowType;
use App\Models\CostItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CostItemTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $uri = '/api/cost-items';

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
        $responseData = json_decode($response->getContent())->data;
        $this->assertEmpty($responseData);

        CostItem::factory()->create();
        $response = $this->getJson($this->uri);
        $response->assertOk();
        $responseData = json_decode($response->getContent())->data;
        $this->assertEmpty($responseData);

        CostItem::factory(['user_id' => $this->user->id])->create();
        $response = $this->getJson($this->uri);
        $response->assertOk();
        $responseData = json_decode($response->getContent())->data;
        $this->assertNotEmpty($responseData);
    }

    /**
     * @dataProvider storeDataProvider
     */
    public function testStore($data): void
    {
        $response = $this->postJson($this->uri, $data);
        $response->assertOk();
        $response->assertJsonStructure(['data' => ['id', 'name', 'type']]);
        $responseData = json_decode($response->getContent())->data;

        /** @var CostItem $costItem */
        $this->assertNotNull($costItem = CostItem::find($responseData->id));
        $this->assertEmpty(array_udiff_assoc($data, $costItem->toArray(), static fn ($a, $b) => $a !== $b));
    }

    public function storeDataProvider(): array
    {
        return [
            CashFlowType::Outflow->value => [[
                'name' => 'just a name',
                'type' => CashFlowType::Outflow,
            ]],
            CashFlowType::Inflow->value => [[
                'name' => 'just a name',
                'type' => CashFlowType::Inflow,
            ]],
        ];
    }

    public function testShow(): void
    {
        $response = $this->getJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var CostItem $costItem */
        $costItem = CostItem::factory()->create();
        $response = $this->getJson($this->uri . "/$costItem->id");
        $response->assertForbidden();

        /** @var CostItem $costItem */
        $costItem = CostItem::factory()->create(['user_id' => $this->user->id]);
        $response = $this->getJson($this->uri . "/$costItem->id");
        $response->assertOk();
    }

    /**
     * @dataProvider updateDataProvider
     */
    public function testUpdate($data): void
    {
        $response = $this->putJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var CostItem $costItem */
        $costItem = CostItem::factory()->create();
        $response = $this->putJson($this->uri . "/$costItem->id");
        $response->assertForbidden();

        /** @var CostItem $costItem */
        $costItem = CostItem::factory()->create(['user_id' => $this->user->id]);
        $response = $this->putJson($this->uri . "/$costItem->id", $data);
        $response->assertOk();
        $this->assertEmpty(array_diff_assoc($data, $costItem->fresh()->toArray()));
    }

    public function updateDataProvider(): array
    {
        return [
            [[
                'name' => 'just a name',
            ]]
        ];
    }

    public function testDestroy(): void
    {
        $response = $this->deleteJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var CostItem $costItem */
        $costItem = CostItem::factory()->create();
        $response = $this->deleteJson($this->uri . "/$costItem->id");
        $response->assertForbidden();

        /** @var CostItem $costItem */
        $costItem = CostItem::factory()->create(['user_id' => $this->user->id]);
        $response = $this->deleteJson($this->uri . "/$costItem->id");
        $response->assertOk();
        $this->assertNull(CostItem::find($costItem->id));
    }
}
