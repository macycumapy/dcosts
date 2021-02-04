<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Documents\CashInflow;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CashInflowController extends TestCase
{
    use WithFaker;

    private $url = '/api/cash_inflow';
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        Passport::actingAs($this->user);
    }

    public function testIndex($n=3)
    {
        $this->get($this->url)
            ->assertOk()
            ->assertJson([])
            ->assertJsonCount(0);

        factory(CashInflow::class, $n)->create(['user_id' => $this->user->id]);

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
        $cashFlowCountBefore = CashInflow::all()->count();
        $this->assertEquals(0,$cashFlowCountBefore);

        $this->post($this->url,$data)
            ->assertOk()
            ->assertJson($data)
            ->assertJsonStructure(['id','sum','date']);

        $cashFlowCountAfter = CashInflow::all()->count();
        $this->assertEquals($cashFlowCountBefore+1,$cashFlowCountAfter);
    }

    public function testShow($id = 1)
    {
        $this->get($this->url.'/'.$id)
            ->assertNotFound()
            ->assertJson([]);

        factory(CashInflow::class)->create(['user_id' => $this->user->id]);

        $this->get($this->url.'/'.$id)
            ->assertOk()
            ->assertJson(['id'=>$id])
            ->assertJsonStructure(['id','sum','date']);
    }

    /**
     * @dataProvider dataProvider
     * @param $data
     * @param $id
     */
    public function testUpdate($data, $id = 1)
    {
        $this->put($this->url.'/'.$id,$data)
            ->assertNotFound()
            ->assertJson([]);

        factory(CashInflow::class)->create(['user_id' => $this->user->id]);

        $this->put($this->url.'/'.$id,$data)
            ->assertOk()
            ->assertJson($data)
            ->assertJsonStructure(['id','sum','date']);
    }

    public function testDestroy($id = 1)
    {
        $this->delete($this->url.'/'.$id)
            ->assertNotFound()
            ->assertJson([]);

        $costItem = CashInflow::find($id);
        $this->assertNull($costItem);

        factory(CashInflow::class)->create(['user_id' => $this->user->id]);

        $costItem = CashInflow::find($id);
        $this->assertNotNull($costItem);

        $this->delete($this->url.'/'.$id)
            ->assertOk();

        $costItem = CashInflow::find($id);
        $this->assertNull($costItem);
    }

    public function dataProvider()
    {
        return [
            'simple' => [
                [
                    'date' => Carbon::now()->toDateTimeString(),
                    'sum' => 1000,
                ]
            ],
        ];
    }
}
