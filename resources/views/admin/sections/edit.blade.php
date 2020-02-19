@extends('layouts.admin.app', ['title' => 'Изменить раздел'])

@section('content')
    <form action="{{ route('admin.sections.update', $section->id) }}" method="post" class="form needs-validation mb-4" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="validationCustom01">Название</label>
            <input type="text" class="form-control" id="validationCustom01" value="{{ $section->name }}" name="name" required>
            <div class="valid-feedback">@lang('checkout.valid_correct')</div>
            <div class="invalid-feedback">@lang('checkout.valid_incorrect')</div>
        </div>

        <div class="mb-3">
            <label for="validationTextarea">Описание</label>
            <textarea class="form-control" id="validationTextarea" name="description">{{ $section->description }}</textarea>
        </div>

        <div class="form-group">
            <label>Статус</label>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input form-control" id="customControlValidation1" name="status" value="1" @if($section->status) checked @endif>
                <label class="custom-control-label" for="customControlValidation1">Активный</label>
                <div class="invalid-feedback">Example invalid feedback text</div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-auto">
                <label>Изображение для анонса</label>
                <div class="img-container my-2 text-center" data-prop="photo">
                    @if (!empty($section->preview_photo))
                        <div class="img-block">
                            <img src="{{ Storage::url($section->preview_photo) }}" class="img-fluid">
                        </div>
                        <div class="img-edit-panel">
                            <span class="img-del"><i class="fas fa-trash-alt"></i></span>
                        </div>
                    @else
                        <span class="img-list-descr">(Drag&amp;Drop) <br> Перетащите картинку</span>
                        <input type="file" name="photo" class="img-field">
                    @endif
                </div>
            </div>
        </div>

        <div class="box-footer mt-4">
            <div class="btn-group">
                <a href="{{ route('admin.sections.index') }}" class="btn btn-sm btn-custom btn-back">Назад</a>
                <button type="submit" class="btn btn-primary btn-sm btn-custom">Изменить</button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $(".img-container").on('click', '.img-del', function(){
                let imgContainer = $(this).closest('.img-container');

                imgContainer.empty();
                $('<span class="img-list-descr">(Drag&amp;Drop) <br> Перетащите картинку</span>').appendTo(imgContainer);

                if (!imgContainer.find('.img-field').length)
                {
                    $('<input type="file" name="' + imgContainer.data('prop') + '" class="img-field">').appendTo(imgContainer);
                    $('<input type="hidden" name="delete_' + imgContainer.data("prop") + '" value="Y">').appendTo(imgContainer);
                }
                else
                {
                    imgContainer.find('.img-field').show();
                }

            });

            $(".img-container").on('change', '.img-field', function(){
                displayImg(this.files[0], $(this).closest('.img-container'));
            });

            $('.img-container').bind({
                dragenter: function() {
                    return false;
                },
                dragover: function() {
                    return false;
                },
                dragleave: function() {
                    return false;
                },
                drop: function(e) {
                    displayImg(e.originalEvent.dataTransfer.files[0], $(this).closest('.img-container'));

                    return false;
                }
            });

            function displayImg(file, imgContainer) {
                let imageType = /image.*/;

                if (!file.type.match(imageType))
                    return true;

                imgContainer.find('.img-list-descr').remove();
                imgContainer.find('.img-field').hide();

                let imgBlock = $('<div class="img-block"></div>').appendTo(imgContainer);
                let img = $('<img class="img-fluid"/>').appendTo(imgBlock);
                let imgEditPanel = $('<div class="img-edit-panel text-center"></div>').appendTo(imgContainer);

                $('<span class="img-del"><i class="fas fa-trash-alt"></i></span>').appendTo(imgEditPanel);

                let reader = new FileReader();

                reader.onload = (function(aImg) {
                    return function(e) {
                        aImg.attr('src', e.target.result);
                        aImg.css('height', 180);
                    };
                })(img);

                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
