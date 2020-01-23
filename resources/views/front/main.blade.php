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
    <div class="random-products">
        <div class="container">
            <div class="random-products__header">
                <h3 class="mb-3">@lang('main.random_products_title')</h3>
            </div>
            <div class="row">
                <div class="random-products__content">
                    @foreach($products as $product)
                        <div class="random-products--item col-4">
                            <h4 class="item__name">{{ $product->name }}</h4>
                            <p class="item__desc">{{ $product->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection