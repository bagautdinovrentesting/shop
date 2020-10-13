<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Product;
use App\Property;
use App\ReviewStatus;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'rating' => 'required|numeric',
            'text' => 'required|max:1000',
        ]);

        $product = Product::findOrFail($request->input('product'));
        $reviewStatus = ReviewStatus::where('code', 'M')->firstOrFail();

        $data['status_id'] = $reviewStatus->id;

        if ($request->user() === null)
            return ['message' => 'Для добавления отзыва необходимо авторизоваться на сайте'];

        $data['user_id'] = $request->user()->id;

        $product->reviews()->create($data);

        return ['message' => 'Отзыв успешно создан!'];
    }
}
