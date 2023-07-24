<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\NomenclatureType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NomenclatureTypeTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $uri = '/api/nomenclature-types';

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

        NomenclatureType::factory()->create();
        $response = $this->getJson($this->uri);
        $response->assertOk();
        $responseData = json_decode($response->getContent())->data;
        $this->assertEmpty($responseData);

        NomenclatureType::factory(['user_id' => $this->user->id])->create();
        $response = $this->getJson($this->uri);
        $response->assertOk();
        $responseData = json_decode($response->getContent())->data;
        $this->assertNotEmpty($responseData);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testStore($data): void
    {
        $response = $this->postJson($this->uri, $data);
        $response->assertOk();
        $response->assertJsonStructure(['data' => ['id', 'name']]);
        $responseData = json_decode($response->getContent())->data;

        /** @var NomenclatureType $nomenclatureType */
        $this->assertNotNull($nomenclatureType = NomenclatureType::find($responseData->id));
        $this->assertEmpty(array_diff($data, $nomenclatureType->toArray()));
    }

    public function testShow(): void
    {
        $response = $this->getJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var NomenclatureType $nomenclatureType */
        $nomenclatureType = NomenclatureType::factory()->create();
        $response = $this->getJson($this->uri . "/$nomenclatureType->id");
        $response->assertNotFound();

        /** @var NomenclatureType $nomenclatureType */
        $nomenclatureType = NomenclatureType::factory()->create(['user_id' => $this->user->id]);
        $response = $this->getJson($this->uri . "/$nomenclatureType->id");
        $response->assertOk();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testUpdate($data): void
    {
        $response = $this->putJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var NomenclatureType $nomenclatureType */
        $nomenclatureType = NomenclatureType::factory()->create();
        $response = $this->putJson($this->uri . "/$nomenclatureType->id");
        $response->assertNotFound();

        /** @var NomenclatureType $nomenclatureType */
        $nomenclatureType = NomenclatureType::factory()->create(['user_id' => $this->user->id]);
        $response = $this->putJson($this->uri . "/$nomenclatureType->id", $data);
        $response->assertOk();
        $this->assertEmpty(array_diff($data, $nomenclatureType->fresh()->toArray()));
    }

    public function testDestroy(): void
    {
        $response = $this->deleteJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var NomenclatureType $nomenclatureType */
        $nomenclatureType = NomenclatureType::factory()->create();
        $response = $this->deleteJson($this->uri . "/$nomenclatureType->id");
        $response->assertNotFound();

        /** @var NomenclatureType $nomenclatureType */
        $nomenclatureType = NomenclatureType::factory()->create(['user_id' => $this->user->id]);
        $response = $this->deleteJson($this->uri . "/$nomenclatureType->id");
        $response->assertOk();
        $this->assertNull(NomenclatureType::find($nomenclatureType->id));
    }

    public function dataProvider(): array
    {
        return [
          [[
              'name' => 'just a name'
          ]],
        ];
    }
}
