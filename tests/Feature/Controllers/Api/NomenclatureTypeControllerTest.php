<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Nomenclature;
use App\Models\NomenclatureType;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class NomenclatureTypeControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    private $url = '/api/nomenclature_types';
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

        factory(NomenclatureType::class, 5)->create(['user_id'=>$this->user->id]);
    }

    public function testIndex()
    {
        $nomenclatureTypes = NomenclatureType::all()->toArray();

        $this->get($this->url)
            ->assertOk()
            ->assertJson($nomenclatureTypes);
    }

    /**
     * @dataProvider idProvider
     * @param $id
     */
    public function testShow($id)
    {
        $response = $this->get($this->url . '/' . $id);

        $nomenclatureType = NomenclatureType::find($id);
        if ($nomenclatureType) {
            $response
                ->assertOk()
                ->assertJson($nomenclatureType->toArray());
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
        $this->post($this->url, $data)
            ->assertOk();
    }

    /**
     * @dataProvider idProvider
     * @param $id
     */
    public function testUpdate($id)
    {
        $data = [
          'name' => $this->faker->name,
        ];

        $response = $this->call('put',$this->url.'/'.$id, $data);

        $nomenclatureType = NomenclatureType::find($id);
        if ($nomenclatureType){
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
        factory(Nomenclature::class, 5)->create(['user_id'=>$this->user->id]);

        $nomenclatureType = NomenclatureType::find($id);

        $response = $this->call('delete',$this->url.'/'.$id);

        if ($nomenclatureType){
            $response->assertOk();
            $this->assertNull(NomenclatureType::find($id));
        } else {
            $response->assertStatus(404);
        }


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
            ['string' => ['name' => 'test']],
//            ['empty string' => ['name' => '']],
        ];
    }
}
