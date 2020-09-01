<header>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form action="{{ route('front.search') }}" class="ml-auto mr-2 header-search">
                    <div class="position-relative">
                        <input class="header-search__query px-4 py-2" type="search" name="query" value="" placeholder="Поиск">
                        <button type="submit" class="header-search__submit position-absolute">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <button type="submit" name="header_search_submit" class="sr-only">Search!</button>
                </form>
                <ul class="navbar-nav mr-3">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">@lang('auth.login')</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">@lang('auth.register')</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @can ('dashboard')
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Админка</a>
                                @endcan

                                <a class="dropdown-item logout-item" href="#">
                                    @lang('auth.logout')
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
                <a href="{{ route('cart.index') }}" class="cart-count">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count__number">{{ $cartCounts }}</span>
                </a>
            </div>
        </div>
    </nav>
    <div class="catalog-menu py-2">
        <div class="container">
            <nav class="nav nav-pills flex-column flex-sm-row">
                @foreach($sections as $section)
                    <a class="flex-sm-fill text-sm-center nav-link @if(request()->segment(2) == $section->id) active @endif" href="{{ route('front.section.id', $section->id) }}">{{ $section->name }}</a>
                @endforeach
            </nav>
        </div>
    </div>
</header>
