@extends('layouts.front.app', ['title' => 'Корзина'])

@section('content')
    @if(!$cartItems->isEmpty())
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">@lang('cart.product')</th>
                    <th scope="col">@lang('cart.quantity')</th>
                    <th scope="col">@lang('cart.unit_price')</th>
                    <th scope="col">@lang('cart.total_product_price')</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td class="font-weight-bold">
                            {{ number_format($item->price, 0, '.', ' ') }}
                            <span class="ruble-currency"><i class="fa fa-ruble-sign" aria-hidden="true"></i></span>
                        </td>
                        <td class="font-weight-bold">
                            {{ number_format($item->price * $item->qty, 0, '.', ' ') }}
                            <span class="ruble-currency"><i class="fa fa-ruble-sign" aria-hidden="true"></i></span>
                        </td>
                        <td>
                            <form action="{{ route('cart.destroy', $item->rowId) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn p-0"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr class="table-info text-right">
                    <td colspan="5">
                        @lang('cart.total_price'):
                        <span class="font-weight-bold">
                            {{ $total }}
                            <span class="ruble-currency"><i class="fa fa-ruble-sign" aria-hidden="true"></i></span>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('checkout.index') }}">
            <button type="button" class="btn btn-main-theme float-right mt-2">Оформить заказ</button>
        </a>
    @else
        <div class="alert alert-warning" role="alert">
            @lang('cart.empty')
        </div>
    @endif
@endsection
