@extends('layouts.admin.app', ['title' => 'Добавить свойство'])

@section('content')
    <form action="{{ route('admin.properties.store') }}" method="post" class="form needs-validation mb-4" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="mb-3">
            <label for="validationCustom01">Название</label>
            <input type="text" class="form-control" id="validationCustom01" value="" name="name" required>
            <div class="valid-feedback">@lang('checkout.valid_correct')</div>
            <div class="invalid-feedback">@lang('checkout.valid_incorrect')</div>
        </div>

        <div class="mb-3">
            <label for="description">Сортировка</label>
            <input type="text" class="form-control" value="100" name="sort">
        </div>

        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input form-control" name="multiple" id="multiple" value="1">
                <label class="custom-control-label" for="multiple">Множественное</label>
            </div>
        </div>

        <div class="form-group">
            <label>Группа</label>
            <select class="custom-select" name="group">
                @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="box-footer mt-4">
            <div class="btn-group">
                <a href="{{ route('admin.properties.index') }}" class="btn btn-sm btn-custom btn-back">Назад</a>
                <button type="submit" class="btn btn-primary btn-sm btn-custom">Добавить</button>
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
