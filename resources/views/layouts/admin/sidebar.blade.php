<nav class="d-none d-md-block dark-bg sidebar col-md-2">
    <div class="sidebar-sticky pt-0">
        <ul class="nav flex-column">
            <li class="nav-item">
                <div class="card dark-bg">
                    <div class="card-header">
                        <a href="{{ route('admin.dashboard') }}">
                            <span class="icon"><i class="fas fa-house-user"></i></span>
                            <span class="ml-1">@lang('admin.dashboard')</span>
                        </a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <div class="accordion" id="productsAccordion">
                    <div class="card dark-bg">
                        <div class="card-header" id="headingProducts">
                            <button class="btn btn-link p-0 text-white" type="button" data-toggle="collapse" data-target="#collapseProducts" aria-controls="collapseProducts">
                                <span class="icon"><i class="far fa-file-powerpoint"></i></span>
                                <span class="ml-1">@lang('admin.products')</span>
                            </button>
                        </div>

                        <div id="collapseProducts" class="collapse light-dark-bg" aria-labelledby="headingProducts" data-parent="#productsAccordion">
                            <div class="card-body">
                                <a class="nav-link pl-2" href="{{ route('admin.products.index') }}">
                                    <span class="icon"><i class="fas fa-list"></i></span>
                                    <span>Список</span>
                                </a>
                                <a class="nav-link pl-2" href="{{ route('admin.properties.index') }}">
                                    <span class="icon"><i class="fas fa-box-open"></i></span>
                                    <span>Свойства</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <div class="accordion" id="sectionsAccordion">
                    <div class="card dark-bg">
                        <div class="card-header" id="headingSections">
                            <button class="btn btn-link p-0 text-white" type="button" data-toggle="collapse" data-target="#collapseSections" aria-controls="collapseSections">
                                <span class="icon"><i class="fas fa-clone"></i></span>
                                <span class="ml-1">@lang('admin.sections')</span>
                            </button>
                        </div>

                        <div id="collapseSections" class="collapse light-dark-bg" aria-labelledby="headingSections" data-parent="#sectionsAccordion">
                            <div class="card-body">
                                <a class="nav-link pl-2" href="{{ route('admin.sections.index') }}">
                                    <span class="icon"><i class="fas fa-list"></i></span>
                                    <span>Список</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <div class="accordion" id="ordersAccordion">
                    <div class="card dark-bg">
                        <div class="card-header" id="headingOrders">
                            <button class="btn btn-link p-0 text-white" type="button" data-toggle="collapse" data-target="#collapseOrders" aria-controls="collapseOrders">
                                <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                                <span class="ml-1">@lang('admin.orders')</span>
                            </button>
                        </div>

                        <div id="collapseOrders" class="collapse light-dark-bg" aria-labelledby="headingOrders" data-parent="#ordersAccordion">
                            <div class="card-body">
                                <a class="nav-link pl-2" href="{{ route('admin.orders.index') }}">
                                    <span class="icon"><i class="fas fa-list"></i></span>
                                    <span>Список</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <div class="accordion" id="usersAccordion">
                    <div class="card dark-bg">
                        <div class="card-header" id="headingUsers">
                            <button class="btn btn-link p-0 text-white" type="button" data-toggle="collapse" data-target="#collapseUsers" aria-controls="collapseUsers">
                                <span class="icon"><i class="fas fa-users"></i></span>
                                <span class="ml-1">@lang('admin.users')</span>
                            </button>
                        </div>

                        <div id="collapseUsers" class="collapse light-dark-bg" aria-labelledby="headingUsers" data-parent="#usersAccordion">
                            <div class="card-body">
                                <a class="nav-link pl-2" href="{{ route('admin.users.index') }}">
                                    <span class="icon"><i class="fas fa-list"></i></span>
                                    <span>Список</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
