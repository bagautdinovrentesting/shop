<div id="myCarousel_{{ $propertyIndex }}" class="carousel slide list-items" data-ride="carousel" data-interval="0">
    <!-- Carousel indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel_{{ $propertyIndex }}" data-slide-to="0" class="active"></li>
        @for($i = 1; $i < ceil(count($property->products) / 4); $i++)
            <li data-target="#myCarousel_{{ $propertyIndex }}" data-slide-to="{{ $i }}"></li>
        @endfor
    </ol>
    <!-- Wrapper for carousel items -->
    <div class="carousel-inner">
        @foreach($property->products->chunk(4) as $chunkIndex => $chunk)
            <div class="carousel-item @if($chunkIndex === 0) active @endif">
                <div class="row">
                    @foreach($chunk as $product)
                        <div class="col-sm-3 text-center">
                            <div class="thumb-wrapper">
                                <div class="img-box">
                                    <a href="{{ route('front.product.id', $product) }}">
                                        <img src="{{ Storage::url("$product->preview_photo") }}" alt="{{ $product->name }}" class="img-fluid">
                                    </a>
                                </div>
                                <div class="thumb-content">
                                    <a href="{{ route('front.product.id', $product) }}" style="display: inline-block; height: 56px;">{{ $product->name }}</a>
                                    <div class="item__price font-weight-bold mb-3">
                                        {{ number_format($product->price, 0, '.', ' ') }}
                                        <span class="ruble-currency"><i class="fa fa-ruble-sign" aria-hidden="true"></i></span>
                                    </div>
                                    <button class="btn btn-main-theme add-to-basket" type="submit" data-product="{{ $product->id }}">В корзину</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <!-- Carousel controls -->
    <a class="carousel-control-prev" href="#myCarousel_{{ $propertyIndex }}" data-slide="prev">
        <i class="fa fa-angle-left"></i>
    </a>
    <a class="carousel-control-next" href="#myCarousel_{{ $propertyIndex }}" data-slide="next">
        <i class="fa fa-angle-right"></i>
    </a>
</div>
