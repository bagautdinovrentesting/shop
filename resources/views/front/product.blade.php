@extends('layouts.front.app', ['title' => $product->name])

@section('content')
    <div class="container py-4">
        {{ $product->name }}<br>
        {{ $product->description }}
    </div>
@endsection