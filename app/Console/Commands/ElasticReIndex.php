<?php

namespace App\Console\Commands;

use App\Product;
use App\Services\Elastic\ProductIndexer;
use Illuminate\Console\Command;

class ElasticReIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reindex elastic';

    private ProductIndexer $productIndexer;

    public function __construct(ProductIndexer $productIndexer)
    {
        parent::__construct();

        $this->productIndexer = $productIndexer;
    }

    public function handle()
    {
        $this->productIndexer->clear();

        foreach (Product::with(['values', 'section'])->active()->orderBy('id')->cursor() as $product) {
            $this->productIndexer->index($product);
        }
    }
}
