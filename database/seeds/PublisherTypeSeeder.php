<?php

use Illuminate\Database\Seeder;

use App\Models\PublisherType;

class PublisherTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PublisherType::create([
            'id' => 1,
            'name' => 'Publicador'
        ]);

        PublisherType::create([
            'id' => 2,
            'name' => 'Pioneiro auxiliar 30h'
        ]);

        PublisherType::create([
            'id' => 3,
            'name' => 'Pioneiro auxiliar 50h'
        ]);

        PublisherType::create([
            'id' => 4,
            'name' => 'Pioneiro regular'
        ]);
    }
}
