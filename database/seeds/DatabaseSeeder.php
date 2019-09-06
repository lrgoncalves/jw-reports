<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CongregationSeeder::class,
            PublisherTypeSeeder::class,
            PublisherSeeder::class,
            UserSeeder::class,
        ]);
    }
}
