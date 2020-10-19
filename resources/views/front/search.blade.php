@extends('layouts.front.app', ['title' => 'Результаты поиска'])

@section('content')
    <div class="section-items">
        @include('components.product_list')
    </div>
    {{ $products->links('components.pagination') }}
@endsection
