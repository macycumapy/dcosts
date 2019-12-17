<?php

namespace Tests\Unit\Controllers\Api;

use App\Models\Documents\CashFlow;
use App\Models\Documents\CashFlowDetails;
use App\Models\Nomenclature;
use App\Models\NomenclatureType;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Support\Arr;

class CashFlowControllerTest extends TestCase
{
    use DatabaseMigrations;

    private $url = '/api/cash_flow';
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        Passport::actingAs($this->user);

        factory(NomenclatureType::class, 5)->create(['user_id' => $this->user->id]);
        factory(Nomenclature::class, 5)->create(['user_id' => $this->user->id]);
    }

    public function testIndex($n=3)
    {
        $this->get($this->url)
            ->assertOk()
            ->assertJson([])
            ->assertJsonCount(0);

        factory(CashFlow::class, $n)->create(['user_id' => $this->user->id]);

        $this->get($this->url)
            ->assertOk()
            ->assertJson([])
            ->assertJsonCount($n);
    }

    /**
     * @dataProvider dataProvider
     * @param $data
     */
    public function testStore($data)
    {
        $details = $data['details'];

        $nomenclatureIds = array_unique(Arr::pluck($details,'nomenclature_id'));
        $nomenclatures = Nomenclature::findById($nomenclatureIds);
        if (count($nomenclatures) != count($nomenclatureIds)) {
            $this->post($this->url,$data)
                ->assertNotFound();

            return;
        }

        $cashFlowCountBefore = CashFlow::all()->count();
        $this->assertEquals(0,$cashFlowCountBefore);

        $cashFlowDetailsBefore = CashFlowDetails::all()->count();
        $this->assertEquals(0,$cashFlowDetailsBefore);

        $this->post($this->url,$data)
            ->assertOk()
            ->assertJson($data)
            ->assertJsonStructure(['id','date','details']);

        $cashFlowCountAfter = CashFlow::all()->count();
        $this->assertEquals($cashFlowCountBefore+1,$cashFlowCountAfter);

        $cashFlowDetailsAfter = CashFlowDetails::all()->count();
        $this->assertEquals($cashFlowDetailsBefore+count($details),$cashFlowDetailsAfter);
    }

    /**
     * @dataProvider idProvider
     * @param $id
     */
    public function testShow($id)
    {
        $this->get($this->url.'/'.$id)
            ->assertNotFound()
            ->assertJson([]);

        factory(CashFlow::class)->create(['id'=>$id, 'user_id' => $this->user->id]);
        factory(CashFlowDetails::class)->create(['cash_flow_id'=>$id]);

        $this->get($this->url.'/'.$id)
            ->assertOk()
            ->assertJson(['id'=>$id])
            ->assertJsonStructure(['id','date','details']);
    }

    /**
     * @dataProvider idWithDataProvider
     * @param $id
     * @param $data
     */
    public function testUpdate($id, $data)
    {
        $this->put($this->url.'/'.$id,$data)
            ->assertNotFound()
            ->assertJson([]);

        $details = $data['details'];

        $nomenclatureIds = array_unique(Arr::pluck($details,'nomenclature_id'));
        $nomenclatures = Nomenclature::findById($nomenclatureIds);
        if (count($nomenclatures) != count($nomenclatureIds)) {
            $this->put($this->url.'/'.$id,$data)
                ->assertNotFound();

            return;
        }

        factory(CashFlow::class)->create(['id'=>$id, 'user_id' => $this->user->id]);
        factory(CashFlowDetails::class)->create(['cash_flow_id'=>$id]);

        $this->put($this->url.'/'.$id,$data)
            ->assertOk()
            ->assertJson($data)
            ->assertJsonStructure(['id','date','details']);

    }

    /**
     * @dataProvider idProvider
     * @param $id
     */
    public function testDestroy($id)
    {
        $this->delete($this->url.'/'.$id)
            ->assertNotFound()
            ->assertJson([]);

        $cashFlow = CashFlow::findById($id);
        $this->assertNull($cashFlow);


        factory(CashFlow::class)->create(['id'=>$id, 'user_id' => $this->user->id]);
        factory(CashFlowDetails::class)->create(['cash_flow_id'=>$id]);

        $cashFlow = CashFlow::findById($id);
        $this->assertNotNull($cashFlow);

        $this->delete($this->url.'/'.$id)
            ->assertOk();

        $cashFlow = CashFlow::findById($id);
        $this->assertNull($cashFlow);

    }

    function dataProvider()
    {

        return [
            [
                [
                    'date' => Carbon::now()->toDateTimeString(),
                    'details' => [
                        [
                            'id' => 1,
                            'nomenclature_id' => 1,
                            'quantity' => 12,
                            'cost' => 111,
                            'comment' => 'test1',
                        ],
                        [
                            'nomenclature_id' => 2,
                            'quantity' => 12,
                            'cost' => 111,
                            'comment' => 'test2',
                        ]
                    ]
                ]
            ],
            [
                [
                    'date' => Carbon::yesterday()->toDateTimeString(),
                    'details' => [
                        [
                            'nomenclature_id' => 1,
                            'quantity' => 12,
                            'cost' => 111,
                            'comment' => 'test1',
                        ],
                        [
                            'nomenclature_id' => 111,
                            'quantity' => 12,
                            'cost' => 111,
                            'comment' => 'test2',
                        ]
                    ]
                ]
            ],
        ];
    }

    public function idProvider()
    {
        return [
            [1],
            [15],
        ];
    }

    public function idWithDataProvider()
    {
        return array_map(function ($id, $data) {
            return array_merge($id, $data);
        }, $this->idProvider(), $this->dataProvider());
    }
}
