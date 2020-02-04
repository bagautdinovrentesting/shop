@extends('layouts.admin.app', ['title' => trans('admin.products')])

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Изменить товар</h1>
    </div>
    @include('layouts.errors')
    <form action="{{ route('admin.products.update', $product->id) }}" method="post" class="form needs-validation" enctype="multipart/form-data">
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

        <div class="custom-control custom-checkbox mb-3">
            <input type="checkbox" class="custom-control-input" id="customControlValidation1" @if($product->status) checked @endif>
            <label class="custom-control-label" for="customControlValidation1">Активный</label>
            <div class="invalid-feedback">Example invalid feedback text</div>
        </div>

        <div class="form-group">
            <select class="custom-select" required>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">Example invalid custom select feedback</div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                <div class="row">
                    <img src="{{ Storage::url($product->detail_photo) }}" alt="" class="img-responsive img-thumbnail">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="validatedCustomFile" required>
                <label class="custom-file-label" for="validatedCustomFile">Детальное изображение</label>
                <div class="invalid-feedback">Example invalid custom file feedback</div>
            </div>
        </div>


        <div class="form-group">
            <div class="col-md-3">
                <div class="row">
                    <img src="{{ Storage::url($product->preview_photo) }}" alt="" class="img-responsive img-thumbnail">
                </div>
            </div>
        </div>

        <div class="custom-file">
            <input type="file" class="custom-file-input" id="validatedCustomFile" required>
            <label class="custom-file-label" for="validatedCustomFile">Превью изображение</label>
            <div class="invalid-feedback">Example invalid custom file feedback</div>
        </div>

        <div class="row">
            <div class="box-footer">
                <div class="btn-group">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-default btn-sm">Back</a>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
            </div>
        </div>
    </form>
@endsection
