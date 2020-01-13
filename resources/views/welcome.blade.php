@extends('layouts.app', ['title' => trans('messages.main_title')])

@section('content')
    <div class="container">
        {{ session('status') }}
    </div>
@endsection