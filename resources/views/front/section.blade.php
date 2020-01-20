@extends('layouts.front.app', ['title' => $section->name])

@section('content')
    <div class="container">
        <div class="section-descr">
            {{ $section->description }}
        </div>
        <div class="section-items">
            @foreach($products as $product)
                <div class="item">
                    <a href="{{ route('front.product.id', $product->id) }}">{{ $product->name }}</a>
                </div>
            @endforeach
        </div>
    </div>


@endsection