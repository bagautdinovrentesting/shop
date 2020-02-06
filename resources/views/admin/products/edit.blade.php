@extends('layouts.admin.app', ['title' => trans('admin.products')])

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Изменить товар</h1>
    </div>
    @include('layouts.errors')
    <form action="{{ route('admin.products.update', $product->id) }}" method="post" class="form needs-validation mb-4" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="validationCustom01">Название</label>
            <input type="text" class="form-control" id="validationCustom01" value="{{ $product->name }}" name="customer_name" required>
            <div class="valid-feedback">@lang('checkout.valid_correct')</div>
            <div class="invalid-feedback">@lang('checkout.valid_incorrect')</div>
        </div>

        <div class="mb-3">
            <label for="validationTextarea">Описание</label>
            <textarea class="form-control" id="validationTextarea">{{ $product->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="validationCustom01">Цена</label>
            <input type="text" class="form-control" id="validationCustom01" value="{{ $product->price }}" name="customer_name" required>
            <div class="valid-feedback">@lang('checkout.valid_correct')</div>
            <div class="invalid-feedback">@lang('checkout.valid_incorrect')</div>
        </div>

        <div class="form-group">
            <label>Статус</label>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input form-control" id="customControlValidation1" @if($product->status) checked @endif>
                <label class="custom-control-label" for="customControlValidation1">Активный</label>
                <div class="invalid-feedback">Example invalid feedback text</div>
            </div>
        </div>

        <div class="form-group">
            <label>Раздел</label>
            <select class="custom-select" required>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">Example invalid custom select feedback</div>
        </div>

        <div class="form-group">
            <label>Детальное изображение</label>
            <div class="img-container my-2">
                @if (!empty($product->detail_photo))
                    <span class="img-list-descr">(Drag&amp;Drop) <br> Перетащите картинку</span>
                    <input type="file" name="file" class="img-field">
                @else
                    <div class="img-block">
                        <img src="https://placehold.it/200x200">
                    </div>
                    <div class="img-edit-panel text-center">
                        <span class="img-del"><i class="fas fa-trash-alt"></i></span>
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label>Изображение для анонса</label>
            <div class="img-container my-2">
                @if (!empty($product->preview_photo))
                    <div class="img-block">
                        <img src="{{ Storage::url($product->preview_photo) }}">
                    </div>
                    <div class="img-edit-panel text-center">
                        <span class="img-del"><i class="fas fa-trash-alt"></i></span>
                    </div>
                @else
                    <span class="img-list-descr">(Drag&amp;Drop) <br> Перетащите картинку</span>
                    <input type="file" name="file" class="img-field">
                @endif
            </div>
        </div>
        <div class="box-footer">
            <div class="btn-group">
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-custom btn-back">Назад</a>
                <button type="submit" class="btn btn-primary btn-sm btn-custom">Изменить</button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        console.log('test');
    </script>
@endsection
