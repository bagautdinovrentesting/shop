@extends('layouts.front.app', ['title' => trans('main.main_title')])

@section('content')
    <div class="random-products">
        <div class="container">
            <div class="random-products__header">
                <h3>@lang('main.random_products_title')</h3>
            </div>
            <div class="random-products__content">
                @foreach($products as $product)
                    <div class="random-products--item">
                        <div class="item__name">{{ $product->name }}</div>
                        <div class="item__desc">{{ $product->description }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection