<?php

use Illuminate\Database\Seeder;
use App\Models\Dictionaries\CostItem;

class CostItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CostItem::firstOrCreate([
            'id' => 1,
            'name' => 'Прочее'
        ]);

        CostItem::firstOrCreate([
            'id' => 2,
            'name' => 'Дом'
        ]);

        CostItem::firstOrCreate([
            'id' => 3,
            'name' => 'Развлечения'
        ]);

        CostItem::firstOrCreate([
            'id' => 4,
            'name' => 'Транспорт'
        ]);

        CostItem::firstOrCreate([
            'id' => 5,
            'name' => 'Спорт'
        ]);
    }
}
