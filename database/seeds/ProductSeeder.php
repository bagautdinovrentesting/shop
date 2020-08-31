<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Acer Nitro 5 AN517-51-55RE',
            'description' => 'Ноутбук Acer Nitro 5 AN517-51-55RE с диагональю 17.3" – это игровое устройство.',
            'price' => 35000,
            'section_id' => 1,
            'user_id' => 1
        ]);

        Product::create([
            'name' => 'Ноутбук HP EliteBook 735 G6',
            'description' => 'Сверхтонкий корпус и превосходное изображение на ультраярком экране с узкими рамками обеспечивают комфортную работу HP EliteBook 735 G6 практически при любом освещении.',
            'price' => 70299,
            'section_id' => 1,
            'user_id' => 1
        ]);

        Product::create([
            'name' => 'Ноутбук HP Probook 440 G6',
            'description' => 'Функциональный, тонкий и легкий ноутбук HP ProBook 440 обеспечивает высокую продуктивность работы как в офисе, так и за его пределами.',
            'price' => 70499,
            'section_id' => 1,
            'user_id' => 1
        ]);

        Product::create([
            'name' => 'Ноутбук HP Pavilion Gaming 15-bc522ur',
            'description' => 'Создаете контент? Часто работаете в видеоредакторе? Любите игры? Ноутбук Pavilion разработан для этих и многих других целей.',
            'price' => 70799,
            'section_id' => 1,
            'user_id' => 1
        ]);

        Product::create([
            'name' => 'Ноутбук Dell Inspiron 7490-7025',
            'description' => 'Этот ноутбук создан для тех, кто хочет получить надежное и производительное компьютерное устройство с наиболее востребованным функционалом.',
            'price' => 70899,
            'section_id' => 1,
            'user_id' => 1
        ]);

        Product::create([
            'name' => 'Ультрабук Dell Inspiron 5390-8349',
            'description' => 'Тонкий и легкий 13-дюймовый ноутбук, обладающий массой особенностей, включая твердотельный накопитель PCIe и процессор Intel Core.',
            'price' => 70999,
            'section_id' => 1,
            'user_id' => 1
        ]);
    }
}
