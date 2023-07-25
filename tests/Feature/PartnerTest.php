<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PartnerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $uri = '/api/partners';

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

        Partner::factory()->create();
        $response = $this->getJson($this->uri);
        $response->assertOk();
        $responseData = json_decode($response->getContent())->data;
        $this->assertEmpty($responseData);

        Partner::factory(['user_id' => $this->user->id])->create();
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

        /** @var Partner $partner */
        $this->assertNotNull($partner = Partner::find($responseData->id));
        $this->assertEmpty(array_diff($data, $partner->toArray()));
    }

    public function testShow(): void
    {
        $response = $this->getJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var Partner $partner */
        $partner = Partner::factory()->create();
        $response = $this->getJson($this->uri . "/$partner->id");
        $response->assertNotFound();

        /** @var Partner $partner */
        $partner = Partner::factory()->create(['user_id' => $this->user->id]);
        $response = $this->getJson($this->uri . "/$partner->id");
        $response->assertOk();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testUpdate($data): void
    {
        $response = $this->putJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var Partner $partner */
        $partner = Partner::factory()->create();
        $response = $this->putJson($this->uri . "/$partner->id");
        $response->assertNotFound();

        /** @var Partner $partner */
        $partner = Partner::factory()->create(['user_id' => $this->user->id]);
        $response = $this->putJson($this->uri . "/$partner->id", $data);
        $response->assertOk();
        $this->assertEmpty(array_diff($data, $partner->fresh()->toArray()));
    }

    public function testDestroy(): void
    {
        $response = $this->deleteJson($this->uri . "/9999");
        $response->assertNotFound();

        /** @var Partner $partner */
        $partner = Partner::factory()->create();
        $response = $this->deleteJson($this->uri . "/$partner->id");
        $response->assertNotFound();

        /** @var Partner $partner */
        $partner = Partner::factory()->create(['user_id' => $this->user->id]);
        $response = $this->deleteJson($this->uri . "/$partner->id");
        $response->assertOk();
        $this->assertNull(Partner::find($partner->id));
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
