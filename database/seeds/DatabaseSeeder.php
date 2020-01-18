<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            \UsersSeeder::class,
            \SectionsSeeder::class,
            \ProductsSeeder::class,
            \OrdersSeeder::class,
            \CartsSeeder::class,
        ]);

        DB::table('order_product')->insert([
            'order_id' => 1,
            'product_id' => 1,
        ]);

        DB::table('cart_product')->insert([
            'cart_id' => 1,
            'product_id' => 1,
        ]);
    }
}
