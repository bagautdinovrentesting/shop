@extends('layouts.front.app', ['title' => trans('main.main_title')])

@section('content')
    @foreach ($properties as $propertyName => $products)
        @php
            $randStr = str_random(8)
        @endphp
        <div class="random-products">
            <div class="random-products__header">
                <h2 class="mb-3">{{ $propertyName }}</h2>
            </div>
            <div class="random-products__content">
                @include('components.products_slider')
            </div>
        </div>
    @endforeach
@endsection


@push('js')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.add-to-basket', function(){
                let data = {product: $(this).data('product'), _token: "{{ csrf_token() }}"};

                $.ajax({
                    type: "POST",
                    url: "{{ route('cart.store') }}",
                    data: data,
                    dataType: 'json',
                    success: function(result){
                        if (result.message)
                            console.log(result.message);
                        else if (result.count)
                            $('#cart-count .cart-count__number').html(result.count);
                    },
                });
            });
        });
    </script>
@endpush
