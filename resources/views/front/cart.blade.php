@extends('layouts.front.app', ['title' => 'Корзина'])

@section('content')
    <table class="table table-striped table-dark">
        <thead>
            <tr>
                <th scope="col">Product</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->price }}</td>
                </tr>
            @endforeach
            <tr class="table-dark">
                <td colspan="2">Total</td>
                <td>{{ $total }}</td>
            </tr>
        </tbody>
    </table>
@endsection