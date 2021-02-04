<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Documents\CashFlow;
use App\Models\Documents\CashFlowDetails;
use App\Models\Dictionaries\Nomenclature;
use App\Models\User;
use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CashFlowControllerTest extends TestCase
{
    private $url = '/api/cash_flow';

    protected function setUp(): void
    {
        parent::setUp();

        Passport::actingAs(factory(User::class)->create());
    }

    public function testIndex($n = 3)
    {
        $this->getJson($this->url)
            ->assertOk()
            ->assertJson([])
            ->assertJsonCount(0);

        factory(CashFlow::class, $n)->create();

        $this->getJson($this->url)
            ->assertOk()
            ->assertJson([])
            ->assertJsonCount($n);
    }

    public function testStore()
    {
        $data = [
            'date' => Carbon::now()->toDateTimeString(),
            'details' => [
                [
                    'nomenclature_id' => factory(Nomenclature::class)->create()->id,
                    'quantity' => 12,
                    'cost' => 111,
                ],
                [
                    'nomenclature_id' => factory(Nomenclature::class)->create()->id,
                    'quantity' => 12,
                    'cost' => 111,
                ]
            ]
        ];

        $sum = CashFlow::getSumByDetails($data['details']);

        $cashFlowCountBefore = CashFlow::all()->count();
        $this->assertEquals(0, $cashFlowCountBefore);

        $cashFlowDetailsBefore = CashFlowDetails::all()->count();
        $this->assertEquals(0, $cashFlowDetailsBefore);

        $response = $this->postJson($this->url, $data)
            ->assertJsonMissingValidationErrors()
            ->assertOk()
            ->assertJson($data)
            ->assertJson(['sum' => $sum])
            ->assertJsonStructure(['id', 'date', 'details', 'sum']);

        $cashFlowCountAfter = CashFlow::all()->count();
        $this->assertEquals($cashFlowCountBefore + 1, $cashFlowCountAfter);

        $cashFlowDetailsAfter = CashFlowDetails::all()->count();
        $this->assertEquals($cashFlowDetailsBefore + count($data['details']), $cashFlowDetailsAfter);
    }

    public function testShow()
    {
        $id = 1;
        $this->getJson($this->url . '/' . $id)
            ->assertNotFound();

        $cashFlow = factory(CashFlow::class)->create();
        factory(CashFlowDetails::class)->create(['cash_flow_id' => $cashFlow->id]);

        $this->getJson($this->url . '/' . $cashFlow->id)
            ->assertOk()
            ->assertJson(['id' => $cashFlow->id])
            ->assertJsonStructure(['id', 'date', 'details', 'sum']);
    }

    public function testUpdate($id = 1)
    {

        $data = [
            'date' => Carbon::now()->toDateTimeString(),
            'details' => [
                [
                    'nomenclature_id' => factory(Nomenclature::class)->create()->id,
                    'quantity' => 12,
                    'cost' => 111,
                ],
                [
                    'nomenclature_id' => factory(Nomenclature::class)->create()->id,
                    'quantity' => 12,
                    'cost' => 111,
                ]
            ]
        ];

        $this->putJson($this->url . '/' . $id, $data)
            ->assertNotFound();

        $sum = CashFlow::getSumByDetails($data['details']);

        $cashFlow = factory(CashFlow::class)->create();
        factory(CashFlowDetails::class)->create(['cash_flow_id' => $cashFlow->id]);

        $response = $this->putJson($this->url . '/' . $cashFlow->id, $data);
        $response->assertOk()
            ->assertJson($data)
            ->assertJson(['sum' => $sum])
            ->assertJsonStructure(['id', 'date', 'details', 'sum']);
    }

    public function testDestroy()
    {
        $id = 1;
        $this->delete($this->url . '/' . $id)
            ->assertNotFound();

        $cashFlow = factory(CashFlow::class)->create(['id' => $id]);
        factory(CashFlowDetails::class)->create(['cash_flow_id' => $id]);

        $this->delete($this->url . '/' . $id)
            ->assertOk();

        $this->assertNotNull($cashFlow);
        $cashFlow = $cashFlow->fresh();
        $this->assertNull($cashFlow);
    }
}
