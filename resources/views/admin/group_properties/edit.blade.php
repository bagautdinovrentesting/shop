@extends('layouts.admin.app', ['title' => 'Изменить группу свойств'])

@section('content')
    <form action="{{ route('admin.group_properties.update', $group->id) }}" method="post" class="form needs-validation mb-4" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="validationCustom01">Название</label>
            <input type="text" class="form-control" id="validationCustom01" value="{{ $group->name }}" name="name" required>
            <div class="valid-feedback">@lang('checkout.valid_correct')</div>
            <div class="invalid-feedback">@lang('checkout.valid_incorrect')</div>
        </div>

        <div class="mb-3">
            <label for="description">Сортировка</label>
            <input type="text" class="form-control" value="{{ $group->sort }}" name="sort">
        </div>

        <div class="box-footer mt-4">
            <div class="btn-group">
                <a href="{{ route('admin.properties.index') }}" class="btn btn-sm btn-custom btn-back">Назад</a>
                <button type="submit" class="btn btn-primary btn-sm btn-custom">Сохранить</button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.needs-validation').submit(function( event ) {
                if (this.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                this.classList.add('was-validated');
            });
        });
    </script>
@endsection
