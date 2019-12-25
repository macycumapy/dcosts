<?php

namespace Tests\Unit\Controllers\Api;

use App\Models\Documents\CashFlow;
use App\Models\Documents\CashInflow;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Passport\Passport;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use DatabaseMigrations;

    private $url = '/api/';
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        Passport::actingAs($this->user);
    }

    public function testBalance()
    {
        $this->get($this->url.'balance')
            ->assertOk()
            ->assertJson(['sum' => 0]);

        $cashFlows = factory(CashFlow::class,5)->create(['user_id' => $this->user->id]);
        $cashInflows = factory(CashInflow::class,5)->create(['user_id' => $this->user->id]);
        $sum = round($cashInflows->sum('sum'),2) - round($cashFlows->sum('sum'),2);

        $this->get($this->url.'balance')
            ->assertOk()
            ->assertJson(['sum' => $sum]);
    }

    public function testCashList()
    {
        $this->get($this->url.'cash_list')
            ->assertOk()
            ->assertJson([]);

        $cashFlows = factory(CashFlow::class,5)->create(['user_id' => $this->user->id]);
        $cashInflows = factory(CashInflow::class,5)->create(['user_id' => $this->user->id]);

        $this->get($this->url.'cash_list')
            ->assertOk()
            ->assertJsonCount($cashFlows->count() + $cashInflows->count())
            ->assertJsonStructure([
                [
                    'id',
                    'date',
                    'type',
                    'sum',
                    'cost_item',
                ]
            ]);
    }
}
