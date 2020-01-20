@extends('layouts.front.app', ['title' => $product->name])

@section('content')
    <div class="container">
        {{ $product->name }}<br>
        {{ $product->description }}
    </div>
@endsection