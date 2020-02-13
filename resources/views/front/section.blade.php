@extends('layouts.front.app', ['title' => $section->name])

@section('content')
    <div class="section-items">
        <div class="row">
            @include('components.product_list')
        </div>
    </div>
    <div class="section-descr py-4">
        {{ $section->description }}
    </div>
@endsection
