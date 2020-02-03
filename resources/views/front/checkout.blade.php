@extends('layouts.front.app', ['title' => trans('checkout.title')])

@section('content')
    @include('layouts.errors')
    <div class="card">
        <div class="card-header">@lang('checkout.title')</div>
        <div class="card-body">
            <form class="needs-validation" action="{{ route('checkout.store') }}" method="post" novalidate>
                @csrf
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">@lang('checkout.prop_name')</label>
                        <input type="text" class="form-control" id="validationCustom01" value="" name="customer_name" required>
                        <div class="valid-feedback">@lang('checkout.valid_correct')</div>
                        <div class="invalid-feedback">@lang('checkout.valid_incorrect')</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom02">@lang('checkout.prop_surname')</label>
                        <input type="text" class="form-control" id="validationCustom02" value="" name="customer_surname">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom03"> @lang('checkout.prop_phone')</label>
                        <input type="text" class="form-control" id="validationCustom03" value="" name="customer_phone" required>
                        <div class="valid-feedback">@lang('checkout.valid_correct')</div>
                        <div class="invalid-feedback">@lang('checkout.valid_incorrect')</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom04"> @lang('checkout.prop_email')</label>
                        <input type="email" class="form-control" id="validationCustom04" value="" name="customer_email" required>
                        <div class="valid-feedback">@lang('checkout.valid_correct')</div>
                        <div class="invalid-feedback">@lang('checkout.valid_incorrect')</div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom05">@lang('checkout.prop_address')</label>
                        <input type="text" class="form-control" id="validationCustom05" name="customer_address" required>
                        <div class="valid-feedback">@lang('checkout.valid_correct')</div>
                        <div class="invalid-feedback">@lang('checkout.valid_incorrect')</div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Y" id="invalidCheck" name="privacy" required>
                        <label class="form-check-label" for="invalidCheck">@lang('checkout.private_policy_text')</label>
                        <div class="invalid-feedback">@lang('checkout.private_policy_empty')</div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">@lang('checkout.submit_form')</button>
            </form>
        </div>
    </div>


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
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

@endsection
