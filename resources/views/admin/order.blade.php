@extends('layouts.admin.app', ['title' => trans('admin.orders')])

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-sm items-list">
            <thead>
            <tr>
                <th>#</th>
                <th>Дата создания</th>
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
