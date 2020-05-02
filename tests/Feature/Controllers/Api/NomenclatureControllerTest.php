<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Nomenclature;
use App\Models\NomenclatureType;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class NomenclatureControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    private $url = '/api/nomenclature';
    private $user;

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

        factory(NomenclatureType::class, 5)->create(['user_id' => $this->user->id]);
        factory(Nomenclature::class, 5)->create(['user_id' => $this->user->id]);
    }

    public function testIndex()
    {
        $nomenclatures = Nomenclature::all()->toArray();

        $this->get($this->url)
            ->assertOk()
            ->assertJson($nomenclatures);
    }

    /**
     * @dataProvider idProvider
     * @param $id
     */
    public function testShow($id)
    {
        $response = $this->get($this->url . '/' . $id);

        $nomenclature = Nomenclature::find($id);
        if ($nomenclature) {
            $response
                ->assertOk()
                ->assertJson($nomenclature->toArray());
        } else {
            $response->assertStatus(404);
        }
    }

    /**
     * @dataProvider dataProvider
     * @param $data
     */
    public function testStore($data)
    {
        $response = $this->post($this->url, $data);

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

        $response = $this->call('put', $this->url . '/' . $id, $data);

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

        $response = $this->call('delete', $this->url . '/' . $id);

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
