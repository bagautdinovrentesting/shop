<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap py-2 px-0 shadow">
    <a class="navbar-brand mr-0 text-center col-md-2" href="{{ route('home') }}">{{ config('app.name') }}</a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="@lang('admin.search')" aria-label="@lang('admin.search')">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link logout-item" href="#">@lang('login.logout')</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>
