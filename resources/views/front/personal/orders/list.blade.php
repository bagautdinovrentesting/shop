@extends('layouts.front.app', ['title' => 'Личный кабинет'])

@section('content')
    <div class="row">
        @include('components.user_menu')
        <div class="personal-content col-sm-9 col-12">
            <h3 class="mb-4">Мои заказы</h3>
            <div class="table-responsive property-list">
                @if ($orders->isNotEmpty())
                    <div class="card mb-4">
                        <table class="table table-striped table-sm items-list mb-0">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Дата создания</th>
                                <th>Статус</th>
                                <th>Общая стоимость</th>
                            </tr>
                            @foreach($orders as $orderIndex => $order)
                                <tr class="text-center">
                                    <td>{{ $orderIndex + 1 }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->status->name }}</td>
                                    <td>{{ $order->total }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning" role="alert">Вы пока не совершили ни одного заказа.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
