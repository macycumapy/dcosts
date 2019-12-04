<?php

namespace Tests\Unit\Controllers\Api;

use App\Models\Documents\CashFlow;
use App\Models\Documents\CashFlowInterface;
use App\Models\Nomenclature;
use App\Models\NomenclatureType;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CashFlowControllerTest extends TestCase
{
    use DatabaseMigrations;

    private $url = '/api/cash_flow';

    public function testIndex()
    {
        factory(CashFlow::class,5)->create();

        $cashFlow = CashFlow::all();

        $this->get($this->url)
            ->assertOk()
            ->assertJson($cashFlow->toArray());
    }

    /**
     * @dataProvider dataProvider
     * @param $data
     */
    public function testStore($data)
    {
        factory(NomenclatureType::class,5)->create();
        factory(Nomenclature::class,5)->create();

        $cashFlow = CashFlow::create($data);
        $this->assertNotNull($cashFlow);

        //todo add details tests

        $mockCashFlow = $this->mock(CashFlowInterface::class);
        $mockCashFlow->shouldReceive('rules')
            ->andReturn($cashFlow->rules());
        $mockCashFlow->shouldReceive('tryToCreate')
            ->andReturn($cashFlow);

        $this->post($this->url,$data)
            ->assertOk()
            ->assertJson($cashFlow->firstWithDetails()->toArray());
    }

    /**
     * @dataProvider idProvider
     * @param $id
     */
    public function testShow($id)
    {
        factory(CashFlow::class,5)->create();

        $cashFlow = CashFlow::findById($id);

        $response = $this->get($this->url.'/'.$id);

        $cashFlow === null?
            $response
                ->assertNotFound()
                ->assertJson([]):
            $response
                ->assertOk()
                ->assertJson($cashFlow->firstWithDetails()->toArray());
    }

    /**
     * @dataProvider idWithDataProvider
     * @param $id
     * @param $data
     */
    public function testUpdate($id, $data)
    {
        factory(CashFlow::class,5)->create();

        $cashFlow = CashFlow::findById($id);
        $response = $this->patch($this->url.'/'.$id, $data);
        $updatedCashFlow = CashFlow::findById($id);

        $cashFlow === null?
            $response
                ->assertNotFound()
                ->assertJson([]):
            $response
                ->assertOk()
                ->assertJson($updatedCashFlow->firstWithDetails()->toArray());
    }

    /**
     * @dataProvider idProvider
     * @param $id
     */
    public function testDestroy($id)
    {
        factory(CashFlow::class,5)->create();

        $cashFlow = CashFlow::findById($id);
        $response = $this->delete($this->url.'/'.$id);

        $cashFlow === null?
            $response
                ->assertNotFound():
            $response
                ->assertOk();
    }

    function dataProvider()
    {

        return [
            [
                [
                    'incoming' => true,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'details' => [
                        [
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
                    'incoming' => true,
                    'created_at' => Carbon::yesterday()->toDateTimeString()
                ]
            ],
            [
                [
                    'incoming' => false,
                    'created_at' => Carbon::now()->toDateTimeString()
                ]
            ],
        ];
    }

    public function idProvider()
    {
        return [
            [0],
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
