<?php

namespace App\Observers;

use App\Mail\ProductSaved;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Mail;

class ProductObserver
{
    /**
     * @param Product $product
     */
    public function updated(Product $product)
    {
        $admin = User::findOrFail(1);

        Mail::to($admin)->send(new ProductSaved($product));
    }

    /**
     * @param User $user
     */
    public function deleted(Product $product)
    {

    }
}
