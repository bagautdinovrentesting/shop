@extends('layouts.front.app', ['title' => 'Личный кабинет'])

@section('content')
    <div class="row">
        @include('components.user_menu')
        <div class="personal-content col-sm-9 col-12">
            <h3 class="mb-4">Отзывы</h3>
            <div class="table-responsive property-list">
                @if ($reviews->isNotEmpty())
                    <div class="card mb-4">
                        <table class="table table-striped table-sm items-list mb-0">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Товар</th>
                                <th>Текст</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                            @foreach($reviews as $reviewIndex => $review)
                                <tr class="text-center">
                                    <td>{{ $reviewIndex + 1 }}</td>
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
        </div>
    </div>
@endsection
