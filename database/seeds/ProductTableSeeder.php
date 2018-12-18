<?php

use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'id' => 1,
            'name' => "TIM Banca Virtual",
        ]);

        Product::create([
            'id' => 2,
            'name' => "OI Jornais",
        ]);

    }
}
