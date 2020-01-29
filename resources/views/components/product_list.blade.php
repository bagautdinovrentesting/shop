@foreach($products as $product)
    <div class="col-md-3 mb-4">
        <div class="section-items__item">
            <div class="item__image text-center">
                <a href="{{ route('front.product.id', $product->id) }}">
                    <img src="{{ Storage::url("$product->preview_photo") }}" alt="{{ $product->name }}">
                </a>
            </div>
            <div class="item__body">
                <div class="item__body-title mb-3">
                    <a href="{{ route('front.product.id', $product->id) }}">{{ $product->name }}</a>
                </div>
                <div class="item__body-checkout d-flex justify-content-between align-items-center">
                    <div class="item__price font-weight-bold">
                        {{ number_format($product->price, 0, '.', ' ') }}
                        <span class="ruble-currency"><i class="fa fa-ruble-sign" aria-hidden="true"></i></span>
                    </div>
                    <div class="item__buy">
                        <form action="{{ route('cart.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="product" value="{{ $product->id }}">
                            <button class="btn btn-main-theme" type="submit">Купить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
