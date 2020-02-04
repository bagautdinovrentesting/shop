@extends('layouts.admin.app', ['title' => trans('admin.orders')])

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('admin.orders')</h1>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm items-list">
            <thead>
            <tr>
                <th>#</th>
                <th>Дата создание</th>
                <th>Покупатель</th>
                <th>Общая стоимость</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->user->email }}</td>
                    <td>
                        {{ number_format($order->total, 0, '.', ' ') }}
                        <span class="ruble-currency"><i class="fa fa-ruble-sign" aria-hidden="true"></i></span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
