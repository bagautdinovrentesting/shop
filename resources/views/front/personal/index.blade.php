@extends('layouts.front.app', ['title' => 'Личный кабинет'])

@section('content')
    <div class="row">
        @include('components.user_menu')
        <div class="personal-content col-sm-9 col-12">
            CONTENT
        </div>
    </div>
@endsection
