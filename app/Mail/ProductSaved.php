<?php

namespace App\Mail;

use App\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductSaved extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Product
     */
    public $product;

    /**
     * ProductSaved constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.products.saved');
    }
}
