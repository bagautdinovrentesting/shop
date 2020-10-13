@extends('layouts.front.app', ['title' => $product->name])

@section('content')
    <div class="product-detail">
        <div class="product-main">
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
                            <button class="btn btn-main-theme btn-lg btn-block add-to-basket" type="submit" data-product="{{ $product->id }}">Купить</button>
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
                    <a class="nav-link" id="properties-tab" data-toggle="tab" href="#properties" role="tab" aria-controls="properties" aria-selected="true">Характеристики</a>
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
                <div class="tab-pane fade" id="properties" role="tabpanel" aria-labelledby="properties-tab">
                    <div class="col-md-6 col-12">
                    @foreach($groups as $groupName => $group)
                        <h4>{{ $groupName }}</h4>
                        <table class="table table-sm table-striped">
                            @foreach($group as $property)
                                <tr>
                                    <td>{{ $property['name'] }}</td>
                                    <td>{{ $property['value'] }}</td>
                                </tr>
                        @endforeach
                        </table>
                    @endforeach
                    </div>
                </div>
                <div class="tab-pane fade review-list" id="review" role="tabpanel" aria-labelledby="review-tab">
                    <div class="col-md-12 mb-4">
                        @foreach($reviews as $review)
                            <div class="review d-flex pb-4">
                                <div class="review-title mb-2">
                                    <span class="review-username mr-2">{{ $review->user->name }}</span>
                                    <span class="review-date">{{ $review->updated_at->format('d.m.Y') }}</span>
                                </div>
                                <div class="review-rating mb-2">
                                    @for($i = 1; $i < 6; $i++)
                                            <i class="fas fa-star @if($i <= $review->rating)active @endif"></i>
                                    @endfor
                                </div>
                                <div class="review-text">{{ $review->text }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-6">
                        <h3 class="mb-4">Написать отзыв</h3>
                        <form class="needs-validation add-review" novalidate>
                            <input type="hidden" name="product" value="{{ $product->id }}">
                            <div class="form-group col-md-6 p-0">
                                <label for="formControlRange">Рейтинг</label>
                                <input type="range" name="rating" class="form-control-range" min="1" max="5" id="formControlRange" onInput="$('#rating-val').html($(this).val())" value="5">
                                <span id="rating-val">5</span>
                            </div>
                            <div class="mb-3">
                                <label for="validationTextarea">Текст отзыва</label>
                                <textarea class="form-control" name="text" id="validationTextarea" style="height: 150px" placeholder="Опишите общее впечатление: срок использования, критерии при выборе" required></textarea>
                                <div class="invalid-feedback">
                                    Необходимо указать текст отзыва.
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Отправить отзыв</button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade embed-responsive embed-responsive-4by3" id="video" role="tabpanel" aria-labelledby="video-tab">

                </div>
            </div>
        </div>
    </div>
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

            $('form.add-review').submit(function( event ){
                event.preventDefault();

                if (this.checkValidity() === false)
                {
                    event.stopPropagation();
                }
                else
                {
                    let arrData = $(this).serializeArray(),
                        form = $(this),
                        data = {};

                    $.map(arrData, function(n, i){
                        data[n['name']] = n['value'];
                    });

                    data['_token'] = "{{ csrf_token() }}";

                    $.ajax({
                        type: "POST",
                        url: "{{ route('front.reviews.store') }}",
                        data: data,
                        dataType: 'json',
                        success: function(result){
                            form.html(result.message);
                        },
                    });
                }

                this.classList.add('was-validated');
            });
        });
    </script>
@endpush
