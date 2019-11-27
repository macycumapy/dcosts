<?php

use Illuminate\Database\Seeder;

class NomenclatureTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\NomenclatureType::firstOrCreate([
                'id' => 1,
                'name' => 'Прочее'
            ]);
    }
}
