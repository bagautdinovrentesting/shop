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
                    <div class="item__price font-weight-bold">{{ intval($product->price) }} руб.</div>
                    <div class="item__buy">
                        <button class="btn btn-primary" type="submit">Купить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach