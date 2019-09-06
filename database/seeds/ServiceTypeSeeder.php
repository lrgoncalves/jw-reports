<?php

use Illuminate\Database\Seeder;
use App\Models\ServiceType;


class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceType::create([
            'id' => 1,
            'name' => 'Publicador',
        ]);

        ServiceType::create([
            'id' => 2,
            'name' => 'Pioneiro Auxiliar 30h',
        ]);

        ServiceType::create([
            'id' => 3,
            'name' => 'Pioneiro Auxiliar 50h',
        ]);

        ServiceType::create([
            'id' => 4,
            'name' => 'Pioneiro Regular',
        ]);
    }
}
