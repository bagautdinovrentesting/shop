<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsSeeder extends Seeder
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
    }
}
