<div class="row">
    @foreach($products as $product)
        <div class="col-md-3 mb-4 ">
            <div class="section-items__item">
                <div class="item__top text-center">
                    <div class="item__top-image">
                        <a href="{{ route('front.product.id', $product) }}">
                            @if (!empty($product->preview_photo))
                                <img src="{{ Storage::url("$product->preview_photo") }}" alt="{{ $product->name }}" class="img-fluid">
                            @else
                                <img src="https://placehold.it/263x300" alt="{{ $product->name }}" class="img-fluid">
                            @endif
                        </a>
                    </div>
                </div>
                <div class="item__body">
                    <div class="item__body-title mb-3">
                        <a href="{{ route('front.product.id', $product) }}">{{ $product->name }}</a>
                    </div>
                    <div class="item__body-checkout d-flex justify-content-between align-items-center">
                        <div class="item__price font-weight-bold">
                            {{ number_format($product->price, 0, '.', ' ') }}
                            <span class="ruble-currency"><i class="fa fa-ruble-sign" aria-hidden="true"></i></span>
                        </div>
                        <div class="item__buy">
                            <button class="btn btn-main-theme add-to-basket" type="submit" data-product="{{ $product->id }}">Купить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $products->links('components.pagination') }}
@endif

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
