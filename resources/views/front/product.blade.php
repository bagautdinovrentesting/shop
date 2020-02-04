@extends('layouts.front.app', ['title' => $product->name])

@section('content')
    <div class="product-detail">
        <h1>{{ $product->name }}</h1>
        <div class="product-main mt-4">
            <div class="row">
                <div class="col-md-7">
                    @if (!empty($product->detail_photo))
                        <img src="{{ Storage::url("$product->detail_photo") }}" alt="{{ $product->name }}" class="img-fluid">
                    @else
                        <img src="https://placehold.it/665x330" alt="{{ $product->name }}" class="img-fluid">
                    @endif
                </div>
                <div class="col-md-5 mt-3">
                    <div class="product-detail__buy p-4 text-center">
                        <div class="product-detail__buy-price-block font-weight-bold">
                            <span>@lang('product.price')</span>
                            <span class="detail-price">
                                {{ number_format($product->price, 0, '.', ' ') }}
                                <span class="ruble-currency"><i class="fa fa-ruble-sign" aria-hidden="true"></i></span>
                            </span>
                        </div>
                        <div class="product-detail__buy-action mt-3">
                            <form action="{{ route('cart.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="product" value="{{ $product->id }}">
                                <button class="btn btn-main-theme btn-lg btn-block" type="submit">Купить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-info mt-5">
            <ul class="nav nav-tabs" id="product-info" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="desc-tab" data-toggle="tab" href="#desc" role="tab" aria-controls="desc" aria-selected="true">@lang('product.desc_title')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">@lang('product.review_title')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="video-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="false">@lang('product.video_title')</a>
                </li>
            </ul>
            <div class="tab-content py-4" id="product-info-content">
                <div class="tab-pane fade show active" id="desc" role="tabpanel" aria-labelledby="desc-tab"> {{ $product->description }}</div>
                <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">...</div>
                <div class="tab-pane fade embed-responsive embed-responsive-4by3" id="video" role="tabpanel" aria-labelledby="video-tab">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/3zgdxI7W_Q4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>

    </div>
@endsection
