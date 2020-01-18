<?php

use Illuminate\Database\Seeder;
use App\Cart;

class CartsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cart::create([
            'total' => 35000,
            'user_id' => 1,
        ]);
    }
}
