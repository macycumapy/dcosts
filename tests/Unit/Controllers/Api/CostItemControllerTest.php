<?php

namespace Tests\Unit\Controllers\Api;

use App\Models\CostItem;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CostItemControllerTest extends TestCase
{
    use DatabaseMigrations;

    private $url = '/api/cost_item';

    public function testIndex($n = 5)
    {
        $this->get($this->url)
            ->assertOk()
            ->assertJson([])
            ->assertJsonCount(0);

        factory(CostItem::class, $n)->create();

        $this->get($this->url)
            ->assertOk()
            ->assertJson([])
            ->assertJsonCount($n);
    }

    public function testStore()
    {
        $data = [
          'name' => 'test'
        ];

        $costItemCountBefore = CostItem::all()->count();
        $this->assertEquals(0,$costItemCountBefore);

        $this->post($this->url,$data)
            ->assertOk()
            ->assertJson($data)
            ->assertJsonStructure(['id','name']);

        $costItemCountAfter = CostItem::all()->count();
        $this->assertEquals($costItemCountBefore+1,$costItemCountAfter);
    }

    public function testShow($id = 1)
    {
        $this->get($this->url.'/'.$id)
            ->assertNotFound()
            ->assertJson([]);

        factory(CostItem::class)->create();

        $this->get($this->url.'/'.$id)
            ->assertOk()
            ->assertJson(['id'=>$id])
            ->assertJsonStructure(['id','name']);
    }

    public function testUpdate($id = 1)
    {
        $data = [
          'name' => 'test',
        ];

        $this->put($this->url.'/'.$id,$data)
            ->assertNotFound()
            ->assertJson([]);

        factory(CostItem::class)->create();

        $this->put($this->url.'/'.$id,$data)
            ->assertOk()
            ->assertJson($data)
            ->assertJsonStructure(['id','name']);
    }

    public function testDestroy($id = 1)
    {
        $this->delete($this->url.'/'.$id)
            ->assertNotFound()
            ->assertJson([]);

        $costItem = CostItem::findById($id);
        $this->assertNull($costItem);

        factory(CostItem::class)->create();

        $costItem = CostItem::findById($id);
        $this->assertNotNull($costItem);

        $this->delete($this->url.'/'.$id)
            ->assertOk();

        $costItem = CostItem::findById($id);
        $this->assertNull($costItem);
    }
}
