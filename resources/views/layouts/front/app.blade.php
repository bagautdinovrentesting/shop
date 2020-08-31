<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? trans('main.title')}}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">

    @include('layouts.front.header')

    @if( isset($showBanner) )
        @if ( isset($agent) && ($agent->isMobile()))
            @include('components.mobile.banner')
        @else
            @include('components.banner')
        @endif
    @endif

    <main class="container py-4">
        @if (!isset($mainPage))
            <h1 class="mb-4">{{ $title }}</h1>
        @endif
        @include('layouts.errors')
        @yield('content')
    </main>

    @include('layouts.front.footer')

    @stack('js')
</body>
</html>
