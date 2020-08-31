<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Администратор',
            'slug' => 'admin',
        ]);

        Role::create([
            'name' => 'Зарегистрированные',
            'slug' => 'registered',
        ]);

        Role::create([
            'name' => 'Контент-менеджер',
            'slug' => 'editor',
        ]);
    }
}
