@extends('layouts.admin.app', ['title' => trans('admin.products')])

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('admin.products')</h1>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-sm items-list">
            <thead>
            <tr>
                <th></th>
                <th>Название</th>
                <th>Описание</th>
                <th>Раздел</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="product-img">
                            @if (!empty($product->detail_photo))
                                <img src="{{ Storage::url("$product->detail_photo") }}" alt="{{ $product->name }}" class="img-fluid">
                            @else
                                <img src="https://placehold.it/50x50" alt="{{ $product->name }}" class="img-fluid">
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->section->name }}</td>
                        <td class="text-center">
                            <span class="status">
                                @if($product->status)
                                    <i class="fas fa-check-circle status-ok"></i>
                                @else
                                    <i class="fas fa-minus-circle status-not"></i>
                                @endif
                            </span>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <div class="btn-group v-top">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="edit-item mr-2"><i class="fas fa-edit"></i></a>
                                    <button class="btn p-0 border-top-0"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
