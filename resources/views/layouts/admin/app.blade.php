<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Админка'}}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/admin.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.admin.header')

    <div class="container-fluid">
        <div class="row">
            @include('layouts.admin.sidebar')

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">{{ $title ?? 'Заголовок' }}</h1>
                    @yield('toolbar')
                </div>

                @include('layouts.errors')

                @yield('content')
            </main>
        </div>
    </div>

    @include('layouts.admin.footer')

    <script src="{{ mix('js/admin.js') }}"></script>

    @yield('js')
</body>
</html>
