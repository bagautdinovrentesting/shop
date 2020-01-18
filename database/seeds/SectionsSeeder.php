<?php

use Illuminate\Database\Seeder;
use App\Section;

class SectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Section::create([
            'name' => 'Ноутбуки',
            'description' => 'Компьютер - ваш лучший друг',
            'user_id' => 1
        ]);
    }
}
