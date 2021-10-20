@extends('layouts.admin.app', ['title' => 'Изменить свойство'])

@section('content')
    <form action="{{ route('admin.properties.update', $property->id) }}" method="post" class="form needs-validation row" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        <div class="col-2">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                <a class="nav-link active" id="main-tab" data-toggle="pill" href="#pill-main" role="tab" aria-controls="pill-main" aria-selected="true">Основное</a>
                <a class="nav-link" id="values-tab" data-toggle="pill" href="#pill-values" role="tab" aria-controls="#pill-values" aria-selected="false">Значения</a>
            </div>
        </div>
        <div class="col-10">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="pill-main" role="tabpanel" aria-labelledby="main-tab">
                    <div class="mb-3">
                        <label for="validationCustom01">Название</label>
                        <input type="text" class="form-control" id="validationCustom01" value="{{ $property->name }}" name="name" required>
                        <div class="valid-feedback">@lang('checkout.valid_correct')</div>
                        <div class="invalid-feedback">@lang('checkout.valid_incorrect')</div>
                    </div>

                    <div class="mb-3">
                        <label for="description">Сортировка</label>
                        <input type="text" class="form-control" value="{{ $property->sort }}" name="sort">
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input form-control" name="multiple" id="multiple" value="1" @if($property->multiple) checked @endif>
                            <label class="custom-control-label" for="multiple">Множественное</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Группа</label>
                        <select class="custom-select" name="group">
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}" @if($property->group_id === $group->id) selected @endif>{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="tab-pane fade" id="pill-values" role="tabpanel" aria-labelledby="values-tab">
                    <div class="row">
                        <div class="col-md-4">
                            <table class="table table-sm mb-0 property-values">
                                <thead>
                                    <tr class="d-flex">
                                        <th scope="col" class="col-1">ID</th>
                                        <th scope="col" class="col-8 text-center">Значение</th>
                                        <th scope="col" class="col-3 text-center">Сортировка</th>
                                    </tr>
                                </thead>

                                @foreach($property->values as $value)
                                    <tr class="d-flex property-value">
                                        <td class="col-1">{{ $value->id }}</td>
                                        <td class="col-8"><input type="text" class="form-control" name="values[{{ $value->id }}][value]" value="{{ $value->value }}"></td>
                                        <td class="col-3"><input type="text" class="form-control" name="values[{{ $value->id }}][sort]" value="{{ $value->sort }}"></td>
                                    </tr>
                                @endforeach
                            </table>
                            <button class="btn btn-primary btn-sm mx-auto d-block add-property-value">Добавить</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer mt-4">
                <div class="btn-group">
                    <a href="{{ route('admin.properties.index') }}" class="btn btn-sm btn-custom btn-back">Назад</a>
                    <button type="submit" class="btn btn-primary btn-sm btn-custom">Сохранить</button>
                </div>
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

        $('.add-property-value').click(function( event ) {
            event.preventDefault();

            addNewValue();
        });

        function addNewValue()
        {
            let valueCount = $('.property-values .property-value').length,
                indexNewValue = valueCount++;

            $('.property-values').append('<tr class="d-flex property-value">' +
                '<td class="col-1"></td>' +
                '<td class="col-8"><input type="text" class="form-control" name="values[n' + indexNewValue + '][value]" value=""></td>' +
                '<td class="col-3"><input type="text" class="form-control" name="values[n' + indexNewValue + '][sort]" value="100"></td>' +
                '</tr>'
            );
        }

        for (let i = 0; i < 5; i++)
        {
            addNewValue();
        }
    });
</script>
@endsection
