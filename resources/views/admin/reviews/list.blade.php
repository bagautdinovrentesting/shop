@extends('layouts.admin.app', ['title' => 'Отзывы'])

@section('toolbar')
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.reviews.create') }}" class="btn btn-sm btn-outline-secondary ml-3">
            <i class="fas fa-plus"></i> Добавить отзыв
        </a>
    </div>
@endsection

@section('content')
    <div class="table-responsive property-list">
        @if ($reviews->isNotEmpty())
            <div class="card mb-4">
                <table class="table table-striped table-sm items-list">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Пользователь</th>
                        <th>Товар</th>
                        <th>Текст</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                    @foreach($reviews as $review)
                        <tr class="text-center">
                            <td>{{ $review->id }}</td>
                            <td>
                                <a href="{{ route('admin.users.index') }}" target="_blank">{{ $review->user->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route('front.product.id', $review->product->id) }}" target="_blank">{{ $review->product->name }}</a>
                            </td>
                            <td>{{ mb_substr($review->text, 0, 80) }}...</td>
                            <td>{{ $review->status->name }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <div class="btn-group v-top">
                                        <a href="{{ route('admin.reviews.edit', $review->id) }}" class="edit-item mr-2"><i class="fas fa-edit"></i></a>
                                        <button class="btn p-0 border-top-0"><i class="fas fa-trash-alt"></i></button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="alert alert-warning" role="alert">На сайте нет отзывов</div>
        @endif
    </div>
@endsection
