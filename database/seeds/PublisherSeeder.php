<?php

use Illuminate\Database\Seeder;
use App\Models\Publisher;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Publisher::create([
            'congregation_id' => 1,
            'name' => 'Leandro da Rocha Gonçalves',
            'birth_date' => '1986-06-18',
            'baptize_date' => '2010-12-11',
            'pioneer_code' => null,
        ]);

        Publisher::create([
            'congregation_id' => 1,
            'name' => 'Talita Pereira Sousa Gonçalves',
            'birth_date' => '1985-10-24',
            'baptize_date' => '1996-02-04',
            'pioneer_code' => 285629,
        ]);
    }
}
