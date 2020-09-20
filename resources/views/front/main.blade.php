@extends('layouts.front.app', ['title' => trans('main.main_title')])

@section('content')
    <div class="random-products">
        <div class="random-products__header">
            <h3 class="mb-3">@lang('main.random_products_title')</h3>
        </div>
        <div class="random-products__content">
            @include('components.product_list')
        </div>
    </div>
@endsection
