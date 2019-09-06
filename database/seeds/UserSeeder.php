<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Leandro',
            'email' => 'leandro.rocha@bennu.tv',
            'password' => bcrypt('q1w2e3r4'),
        ]);
    }
}
