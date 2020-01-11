@extends('layouts.app', ['title' => 'Главная'])

@section('content')
    <div class="container">
        {{ session('status') }}
    </div>
@endsection