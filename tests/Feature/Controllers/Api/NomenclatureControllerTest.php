<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Dictionaries\Nomenclature;
use App\Models\Dictionaries\NomenclatureType;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class NomenclatureControllerTest extends TestCase
{
    use WithFaker;

    private string $url = '/api/nomenclature';
    private User $user;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        Passport::actingAs($this->user);

        factory(Nomenclature::class, 5)->create(['user_id' => $this->user->id]);
    }

    public function testIndex()
    {
        $nomenclatures = Nomenclature::all()->toArray();

        $this->getJson($this->url)
            ->assertOk()
            ->assertJson($nomenclatures);
    }

    public function testShow()
    {
        $id = 0;
        $response = $this->getJson($this->url . '/' . $id);
        $response->assertNotFound();

        $nomenclature = Nomenclature::all()->first();
        $response = $this->getJson($this->url . '/' . $nomenclature->id);
        $response->assertJsonMissingValidationErrors();
        $response->assertOk();
    }

    /**
     * @dataProvider dataProvider
     * @param $data
     */
    public function testStore($data)
    {
        $response = $this->postJson($this->url, $data);

        if (NomenclatureType::find($data['nomenclature_type_id']))
            $response->assertOk();
        else
            $response->assertStatus(404);
    }

    /**
     * @dataProvider idWithDataProvider
     * @param $id
     * @param $data
     */
    public function testUpdate($id, $data)
    {

        $response = $this->putJson($this->url . '/' . $id, $data);

        $nomenclature = Nomenclature::find($id);
        $nomenclatureType = NomenclatureType::find($data['nomenclature_type_id']);
        if ($nomenclature && $nomenclatureType) {
            $response->assertOk();
        } else {
            $response->assertStatus(404);
        }
    }

    /**
     * @dataProvider idProvider
     * @param $id
     */
    public function testDestroy($id)
    {
        $nomenclature = Nomenclature::find($id);

        $response = $this->delete($this->url . '/' . $id);

        if ($nomenclature) {
            $response->assertOk();
        } else {
            $response->assertStatus(404);
        }

        $this->assertNull(Nomenclature::find($id));
    }

    public function idProvider()
    {
        return [
            [0],
            [1],
            [2],
            [15],
        ];
    }

    public function dataProvider()
    {
        return [
            [
                [
                    'name' => 'test',
                    'nomenclature_type_id' => 1
                ]
            ],
            [
                [
                    'name' => 'test1',
                    'nomenclature_type_id' => 6
                ]
            ],
            [
                [
                    'name' => 'test2',
                    'nomenclature_type_id' => 2
                ]
            ],
            [
                [
                    'name' => 'test3',
                    'nomenclature_type_id' => rand(1,5)
                ]
            ],
        ];
    }

    public function idWithDataProvider()
    {
        return array_map(function ($id, $data) {
            return array_merge($id, $data);
        }, $this->idProvider(), $this->dataProvider());
    }
}
