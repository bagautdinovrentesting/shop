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
        Section::create([
            'name' => 'Телевизоры',
            'description' => 'Наибольшей популярностью среди потребителей пользуются телевизоры с применением LED и OLED технологий',
            'user_id' => 1
        ]);
        Section::create([
            'name' => 'Смартфоны',
            'description' => 'Смартфон – универсальное устройство, предназначенное для общения, работы и развлечений.',
            'user_id' => 1
        ]);
        Section::create([
            'name' => 'Фото и видео',
            'description' => 'Фото и видео',
            'user_id' => 1
        ]);
        Section::create([
            'name' => 'Аксессуары',
            'description' => 'Аксессуар - необязательный предмет, сопутствующий чему-либо.',
            'user_id' => 1
        ]);
    }
}
