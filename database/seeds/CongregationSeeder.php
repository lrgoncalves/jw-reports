<?php

use Illuminate\Database\Seeder;
use App\Models\Congregation;


class CongregationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Congregation::create([
            'id' => 1,
            'name' => 'Nova Cidade',
            'code' => 38539,
        ]);
    }
}
