@extends('errors::minimal')

@section('title', __('errors.forbidden'))
@section('code', '403')
@section('message', __('errors.forbidden_description'))

@section('main_link')
<div>
    <a href="/">{{ __('errors.main_link') }}</a>
</div>
@endsection
