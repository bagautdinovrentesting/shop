<aside class="personal-menu col-sm-3 col-12">
    <div class="personal-menu__header p-4">
        <div class="personal-menu__name mb-3">{{ $user->name }}</div>
        <div class="personal-menu__info">{{ $user->email }}</div>
    </div>
    <ul class="personal-menu__panel">
        <li class="panel-item">
            <a href="{{ route('front.personal.orders') }}">
                <span class="panel-icon"><i class="fas fa-shopping-cart"></i></span>
                <span class="panel-name">Заказы</span>
            </a>
        </li>
        <li class="panel-item">
            <a href="/personal/profile/">
                <span class="panel-icon"><i class="fas fa-user-edit"></i></span>
                <span class="panel-name">Личные данные</span>
            </a>
        </li>
        <li class="panel-item">
            <a href="{{ route('front.personal.reviews') }}">
                <span class="panel-icon"><i class="fas fa-registered"></i></span>
                <span class="panel-name">Отзывы</span>
            </a>
        </li>
    </ul>
</aside>
