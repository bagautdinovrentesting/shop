@extends('layouts.front.app', ['title' => trans('main.main_title')])

@section('content')
    <div class="main-banner">
        <div class="container">
            <h1>Bourne.com - Твой выбор!</h1>
            <p>This is a template for a simple marketing or informational website.
                It includes a large callout called a jumbotron and three supporting pieces of content.
                Use it as a starting point to create something more unique.</p>
        </div>
    </div>
    <div class="random-products px-4">
        <div class="container">
            <div class="random-products__header">
                <h3 class="mb-3">@lang('main.random_products_title')</h3>
            </div>
            <div class="random-products__content">
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-3 mb-4">
                            <div class="section-items__item">
                                <div class="item__image text-center">
                                    <a href="{{ route('front.product.id', $product->id) }}">
                                        <img src="/img/product.jpg" alt="{{ $product->name }}">
                                    </a>
                                </div>
                                <div class="item__body">
                                    <div class="item__body-title mb-3">
                                        <a href="{{ route('front.product.id', $product->id) }}">{{ $product->name }}</a>
                                    </div>
                                    <div class="item__body-checkout d-flex justify-content-between align-items-center">
                                        <div class="item__price font-weight-bold">{{ intval($product->price) }} руб.</div>
                                        <div class="item__buy">
                                            <button class="btn btn-primary" type="submit">Купить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection