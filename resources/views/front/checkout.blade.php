@extends('layouts.front.app', ['title' => trans('checkout.title')])

@section('content')
    <div class="card">
        <div class="card-header">@lang('checkout.title')</div>
        <div class="card-body">
            <form class="needs-validation" action="{{ route('checkout.store') }}" method="post" novalidate>
                @csrf
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">@lang('checkout.prop_name')</label>
                        <input type="text" class="form-control" id="validationCustom01" value="{{ old('customer_name') }}" name="customer_name" required>
                        <div class="valid-feedback">@lang('checkout.valid_correct')</div>
                        <div class="invalid-feedback">@lang('checkout.valid_incorrect')</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom02">@lang('checkout.prop_surname')</label>
                        <input type="text" class="form-control no-validate" id="validationCustom02" value="{{ old('customer_surname') }}" name="customer_surname">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom03"> @lang('checkout.prop_phone')</label>
                        <input type="text" class="form-control" id="validationCustom03" value="{{ old('customer_phone') }}" name="customer_phone" required>
                        <div class="valid-feedback">@lang('checkout.valid_correct')</div>
                        <div class="invalid-feedback">@lang('checkout.valid_incorrect')</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom04"> @lang('checkout.prop_email')</label>
                        <input type="email" class="form-control" id="validationCustom04" value="{{ old('customer_email') }}" name="customer_email" required>
                        <div class="valid-feedback">@lang('checkout.valid_correct')</div>
                        <div class="invalid-feedback">@lang('checkout.valid_incorrect')</div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom05">@lang('checkout.prop_address')</label>
                        <input type="text" class="form-control" id="validationCustom05" value="{{ old('customer_address') }}" name="customer_address" required>
                        <div class="valid-feedback">@lang('checkout.valid_correct')</div>
                        <div class="invalid-feedback">@lang('checkout.valid_incorrect')</div>
                    </div>
                </div>

                @if(!empty($payHandlers))
                    <div class="form-row mb-3">
                        <div class="col-md-6">
                            <label>Способ оплаты</label>
                            <div class="row">
                                @foreach($payHandlers as $handler)
                                    <div class="pay-handler-b__block col-md-4 col-offset-2 text-center">
                                        <input id="PAY_HANDLER_{{ $handler->id }}" name="pay_handler" type="checkbox" value="{{ $handler->id }}">
                                        <label for="PAY_HANDLER_{{ $handler->id }}">
                                            <span class="pay-handler-b__pic">
                                                <img src="{{ Storage::url("$handler->preview_photo") }}">
                                            </span>
                                            <span class="pay-handler-b__name">
                                                {{ $handler->name }}
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="invalidCheck" name="privacy" {{ old('privacy') ? 'checked' : '' }} required>
                        <label class="form-check-label" for="invalidCheck">@lang('checkout.private_policy_text')</label>
                        <div class="invalid-feedback">@lang('checkout.private_policy_empty')</div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">@lang('checkout.submit_form')</button>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity() === false)
                            {
                                event.preventDefault();
                                event.stopPropagation();
                                form.classList.add('was-validated');
                            }
                        }, false);
                    });
                }, false);
            })();
        </script>
    @endpush
@endsection
