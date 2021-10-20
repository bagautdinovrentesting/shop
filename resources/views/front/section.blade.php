@extends('layouts.front.app', ['title' => $section->name])

@section('content')
    <div class="row section-content">
        @include('front.section_content')
    </div>
    <div class="section-descr py-4 mt-2">
        {{ $section->description }}
    </div>
@endsection
