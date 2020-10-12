@extends('layouts.admin.app', ['title' => trans('admin.products')])

@section('toolbar')
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-plus"></i> Добавить товар
        </a>
    </div>
@endsection

@section('content')
    <div class="table-responsive">
        @if ($products->isNotEmpty())
            <table class="table table-striped table-sm items-list">
                <thead>
                <tr>
                    <th></th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Раздел</th>
                    <th class="text-center">Статус</th>
                    <th class="text-center">Удалить</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td class="product-img">
                                @if (!empty($product->preview_photo))
                                    <img src="{{ Storage::url("$product->preview_photo") }}" alt="{{ $product->name }}" class="img-fluid">
                                @else
                                    <img src="https://placehold.it/70x70" alt="{{ $product->name }}" class="img-fluid">
                                @endif
                            </td>
                            <td>
                                @can('update', $product)
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="edit-item mr-2">{{ $product->name }}</a>
                                @elsecan
                                    <span>{{ $product->name }}</span>
                                @endcan
                            </td>
                            <td>
                                @if (!empty($product->description))
                                    {{ mb_substr($product->description, 0, 80) }}...
                                @endif
                            </td>
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
                                <div class="btn-group v-top">
                                    @can('delete', $product)
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn p-0 border-top-0 align-top"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-warning" role="alert">{{ __('admin.empty_products') }}</div>
        @endif
    </div>
@endsection
