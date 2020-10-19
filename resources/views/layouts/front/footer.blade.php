<footer class="mt-auto text-muted">
    <div class="container">
        <div class="section">
            <div class="footer-contacts">
                <div class="footer-contacts__logo">
                    <h3><a href="{{ url('/') }}">{{ config('app.name') }}</a></h3>
                </div>
                <div class="footer-contacts__company">
                    <a class="btn" href="{{ url('/') }}">Карта магазинов</a>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="footer-nav">
                <div class="footer-nav__menu">
                    <div class="footer-nav__heading mb-3">
                        <a href="#">Компания «Bourne»</a>
                    </div>
                    <ul class="list-unstyled footer-menu__links">
                        <li><a href="{{ route('catalog.index') }}">Новости</a></li>
                        <li><a href="{{ route('catalog.index') }}">Нам не всё равно</a></li>
                        <li><a href="{{ route('catalog.index') }}">Про компанию</a></li>
                        <li><a href="{{ route('catalog.index') }}">Инвесторам и акционерам</a></li>
                        <li><a href="{{ route('catalog.index') }}">Вакансии</a></li>
                        <li><a href="{{ route('catalog.index') }}">Тендеры</a></li>
                        <li><a href="{{ route('catalog.index') }}">Экологические инициативы</a></li>
                    </ul>
                </div>
                <div class="footer-nav__menu">
                    <div class="footer-nav__heading mb-3">
                        <a href="#">Интернет-магазин</a>
                    </div>
                    <ul class="list-unstyled footer-menu__links">
                        <li><a href="{{ route('catalog.index') }}">Помощь покупателю</a></li>
                        <li><a href="{{ route('catalog.index') }}">Словарь терминов</a></li>
                        <li><a href="{{ route('catalog.index') }}">Забери товар через 15 минут после заказа</a></li>
                        <li><a href="{{ route('catalog.index') }}">Преимущества интернет-магазина</a></li>
                        <li><a href="{{ route('catalog.index') }}">Каталог</a></li>
                        <li><a href="{{ route('catalog.index') }}">Доставка</a></li>
                    </ul>
                </div>
                <div class="footer-nav__menu">
                    <div class="footer-nav__heading mb-3">
                        <a href="#">С нами выгодно</a>
                    </div>
                    <ul class="list-unstyled footer-menu__links">
                        <li><a href="{{ route('catalog.index') }}">Акции и скидки</a></li>
                        <li><a href="{{ route('catalog.index') }}">Кэшбэк и Бонусные рубли</a></li>
                        <li><a href="{{ route('catalog.index') }}">Бизнес</a></li>
                        <li><a href="{{ route('catalog.index') }}">Партнёрская программа</a></li>
                        <li><a href="{{ route('catalog.index') }}">Поставщикам</a></li>
                        <li><a href="{{ route('catalog.index') }}">Подарочные карты</a></li>
                    </ul>
                </div>
                <div class="footer-nav__menu">
                    <div class="footer-nav__heading mb-3">
                        <a href="#">С нами удобно</a>
                    </div>
                    <ul class="list-unstyled footer-menu__links">
                        <li><a href="{{ route('catalog.index') }}">Ремонт, страховка</a> </li>
                        <li><a href="{{ route('catalog.index') }}">Кредит и рассрочка</a> </li>
                        <li><a href="{{ route('catalog.index') }}">Покупка в кредит</a> </li>
                        <li><a href="{{ route('catalog.index') }}">Частые вопросы</a> </li>
                        <li><a href="{{ route('catalog.index') }}">Вопросы по работе техники</a> </li>
                        <li><a href="{{ route('catalog.index') }}">Шесть главных преимуществ</a> </li>
                        <li><a href="{{ route('catalog.index') }}">Отзывы о нас</a> </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="copyright-block">
                <div class="footer-copyright mb-2">
                    <copyright>©  «Bourne»,&nbsp;2020</copyright>
                </div>
                <ul class="footer-sub-nav list-unstyled">
                    <li class="footer-sub-nav-item"><a href="/legal-notice">Официальная информация</a></li>
                    <li class="footer-sub-nav-item"><a href="http://invest.mvideo.ru/disclosure/index.shtml">Раскрытие информации</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
