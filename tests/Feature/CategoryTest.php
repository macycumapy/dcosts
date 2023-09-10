<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\CashFlowType;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $uri = '/api/categories';

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

        Category::factory()->create();
        $response = $this->getJson($this->uri);
        $response->assertOk();
        $responseData = json_decode($response->getContent())->data;
        $this->assertEmpty($responseData);

        Category::factory(['user_id' => $this->user->id])->create();
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

        /** @var Category $category */
        $this->assertNotNull($category = Category::find($responseData->id));
        $this->assertEmpty(array_diff($data, $category->toArray()));
    }

    public function storeDataProvider(): array
    {
        return collect(CashFlowType::cases())->mapWithKeys(fn (CashFlowType $type) => [
            $type->value => [[
                'name' => 'just a name',
                'type' => $type->value,
            ]]
        ])->toArray();
    }

    public function testShow(): void
    {
        $response = $this->getJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var Category $category */
        $category = Category::factory()->create();
        $response = $this->getJson($this->uri . "/$category->id");
        $response->assertNotFound();

        /** @var Category $category */
        $category = Category::factory()->create(['user_id' => $this->user->id]);
        $response = $this->getJson($this->uri . "/$category->id");
        $response->assertOk();
    }

    /**
     * @dataProvider updateDataProvider
     */
    public function testUpdate($data): void
    {
        $response = $this->putJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var Category $category */
        $category = Category::factory()->create();
        $response = $this->putJson($this->uri . "/$category->id");
        $response->assertNotFound();

        /** @var Category $category */
        $category = Category::factory()->create(['user_id' => $this->user->id]);
        $response = $this->putJson($this->uri . "/$category->id", $data);
        $response->assertOk();
        $this->assertEmpty(array_diff_assoc($data, $category->fresh()->toArray()));
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

        /** @var Category $category */
        $category = Category::factory()->create();
        $response = $this->deleteJson($this->uri . "/$category->id");
        $response->assertNotFound();

        /** @var Category $category */
        $category = Category::factory()->create(['user_id' => $this->user->id]);
        $response = $this->deleteJson($this->uri . "/$category->id");
        $response->assertOk();
        $this->assertNull(Category::find($category->id));
    }
}
