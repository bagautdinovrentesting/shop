@extends('layouts.admin.app', ['title' => 'Изменить отзыв'])

@section('content')
    <form action="{{ route('admin.reviews.update', $review->id) }}" method="post" class="form needs-validation col-md-6 col-12" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        <div class="form-group col-4 p-0">
            <label for="formControlRange">Рейтинг</label>
            <input type="range" name="rating" class="form-control-range" min="1" max="5"
                   id="formControlRange" onInput="$('#rating-val').html($(this).val())" value="{{ $review->rating }}">
            <span id="rating-val">{{ $review->rating }}</span>
        </div>

        <div class="form-group col-4 p-0">
            <label>Статус</label>
            <select class="custom-select" name="status">
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" @if($review->status_id === $status->id) selected @endif>{{ $status->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="validationTextarea">Текст отзыва</label>
            <textarea class="form-control" id="validationTextarea" name="text" style="min-height: 200px">{{ $review->text }}</textarea>
        </div>

        <div class="box-footer mt-4">
            <div class="btn-group">
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-custom btn-back">Назад</a>
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
