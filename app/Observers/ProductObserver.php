<?php

namespace App\Observers;

use App\Product;
use App\Services\Elastic\ProductIndexer;

class ProductObserver
{
    private ProductIndexer $productIndexer;

    public function __construct(ProductIndexer $productIndexer)
    {
        $this->productIndexer = $productIndexer;
    }

    public function created(Product $product)
    {
        $this->productIndexer->index($product);
    }

    public function updated(Product $product)
    {
        $this->productIndexer->index($product);

        /*$admin = User::findOrFail(1);

        Mail::to($admin)->send(new ProductSaved($product));*/
    }

    public function deleted(Product $product)
    {
        $this->productIndexer->remove($product);
    }
}
