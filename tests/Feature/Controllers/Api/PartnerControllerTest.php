<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Dictionaries\Partner;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PartnerControllerTest extends TestCase
{
    private $url = '/api/partner';
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        Passport::actingAs($this->user);
    }

    public function testIndex($n = 5)
    {
        $this->getJson($this->url)
            ->assertOk()
            ->assertJson([])
            ->assertJsonCount(0);

        factory(Partner::class, $n)->create(['user_id' => $this->user->id]);

        $this->getJson($this->url)
            ->assertOk()
            ->assertJson([])
            ->assertJsonCount($n);
    }

    public function testStore()
    {
        $data = [
            'name' => 'test'
        ];

        $costItemCountBefore = Partner::all()->count();
        $this->assertEquals(0,$costItemCountBefore);

        $this->post($this->url,$data)
            ->assertOk()
            ->assertJson($data)
            ->assertJsonStructure(['id','name']);

        $costItemCountAfter = Partner::all()->count();
        $this->assertEquals($costItemCountBefore+1,$costItemCountAfter);
    }

    public function testShow($id = 1)
    {
        $this->getJson($this->url.'/'.$id)
            ->assertNotFound()
            ->assertJson([]);

        factory(Partner::class)->create(['id' => $id, 'user_id' => $this->user->id]);

        $this->getJson($this->url.'/'.$id)
            ->assertOk()
            ->assertJson(['id'=>$id])
            ->assertJsonStructure(['id','name']);
    }

    public function testUpdate($id = 1)
    {
        $data = [
            'name' => 'test',
        ];

        $this->putJson($this->url.'/'.$id,$data)
            ->assertNotFound()
            ->assertJson([]);

        factory(Partner::class)->create(['id' => $id, 'user_id' => $this->user->id]);

        $this->putJson($this->url.'/'.$id,$data)
            ->assertOk()
            ->assertJson($data)
            ->assertJsonStructure(['id','name']);
    }

    public function testDestroy($id = 1)
    {
        $this->delete($this->url.'/'.$id)
            ->assertNotFound();

        $costItem = Partner::find($id);
        $this->assertNull($costItem);

        factory(Partner::class)->create(['id' => $id, 'user_id' => $this->user->id]);

        $costItem = Partner::find($id);
        $this->assertNotNull($costItem);

        $this->delete($this->url.'/'.$id)
            ->assertOk();

        $costItem = Partner::find($id);
        $this->assertNull($costItem);
    }
}
