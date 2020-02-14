@extends('layouts.front.app', ['title' => 'Результаты поиска'])

@section('content')
    <div class="section-items">
        <div class="row">
            @include('components.product_list')
        </div>
    </div>
    {{ $products->links('components.pagination') }}
@endsection
