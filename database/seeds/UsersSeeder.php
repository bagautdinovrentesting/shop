<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Bourne',
            'email' => 'superbourne@mail.ru',
            'password' => bcrypt('laravelknopka'),
            'role' => 'admin'
        ]);
    }
}
