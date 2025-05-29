<div id="sidebarMain" class="d-none">
    <aside
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
            <div class="navbar-brand-wrapper justify-content-between">
                <!-- Logo -->

                <a class="navbar-brand" href="{{ route('admin.dashboard') }}" aria-label="Front">
                    <img class="navbar-brand-logo initial--36"
                        onerror="this.src='{{ asset('public/assets/admin/img/160x160/img2.jpg') }}'"
                        src="{{ asset('public/assets/admin/img/160x160/img2.jpg') }}" alt="Logo">
                    <img class="navbar-brand-logo-mini initial--36"
                        onerror="this.src='{{ asset('public/assets/admin/img/160x160/img2.jpg') }}'"
                        src="{{ asset('public/assets/admin/img/160x160/img2.jpg') }}" alt="Logo">
                </a>
                <!-- End Logo -->

                <!-- Navbar Vertical Toggle -->
                <button type="button"
                    class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                    <i class="tio-clear tio-lg"></i>
                </button>
                <!-- End Navbar Vertical Toggle -->

                <div class="navbar-nav-wrap-content-left">
                    <!-- Navbar Vertical Toggle -->
                    <button type="button" class="js-navbar-vertical-aside-toggle-invoker close">
                        <i class="tio-first-page navbar-vertical-aside-toggle-short-align" data-toggle="tooltip"
                            data-placement="right" title="Collapse"></i>
                        <i class="tio-last-page navbar-vertical-aside-toggle-full-align"
                            data-template='<div class="tooltip d-none d-sm-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'></i>
                    </button>
                    <!-- End Navbar Vertical Toggle -->
                </div>

            </div>

            <!-- Content -->
            <div class="navbar-vertical-content bg--005555" id="navbar-vertical-content">
                <form class="sidebar--search-form">
                    <div class="search--form-group">
                        <button type="button" class="btn"><i class="tio-search"></i></button>
                        <input type="text" class="form-control form--control" placeholder="Search Menu..."
                            id="search-sidebar-menu">
                    </div>
                </form>
                <ul class="navbar-nav navbar-nav-lg nav-tabs">
                    <!-- Dashboards -->
                    <li class="navbar-vertical-aside-has-menu {{ Request::is('admin') ? 'show active' : '' }}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('admin.dashboard') }}"
                            title="Dashboard">
                            <i class="tio-home-vs-1-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                Dashboard
                            </span>
                        </a>
                    </li>
                    <!-- End Dashboards -->
                    <!-- Pos -->
                    <!-- Pos -->

                    <!-- Orders -->
                    @if (\App\CentralLogics\Helpers::module_permission_check('order'))
                        <li class="nav-item">
                            <small class="nav-subtitle">{{ __('messages.order_management') }}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/order') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                                title="{{ __('messages.orders') }}">
                                <i class="tio-shopping-cart nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{ __('messages.orders') }}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display:{{ Request::is('admin/order*') ? 'block' : 'none' }}">
                                <li class="nav-item {{ Request::is('admin/order/list/all') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('admin.order.list', ['all']) }}"
                                        title="{{ __('messages.all_orders') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            {{ __('messages.all') }}
                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                {{ \App\Models\Order::StoreOrder()->module(Config::get('module.current_module_id'))->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('admin/order/list/scheduled') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('admin.order.list', ['scheduled']) }}"
                                        title="{{ __('messages.scheduled_orders') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            {{ __('messages.scheduled') }}
                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                {{ \App\Models\Order::Scheduled()->StoreOrder()->module(Config::get('module.current_module_id'))->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('admin/order/list/pending') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.order.list', ['pending']) }}"
                                        title="{{ __('messages.pending_orders') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            {{ __('messages.pending') }}
                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                {{ \App\Models\Order::Pending()->OrderScheduledIn(30)->StoreOrder()->module(Config::get('module.current_module_id'))->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{ Request::is('admin/order/list/accepted') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.order.list', ['accepted']) }}"
                                        title="{{ __('messages.accepted_orders') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            {{ __('messages.accepted') }}
                                            <span class="badge badge-soft-success badge-pill ml-1">
                                                {{ \App\Models\Order::AccepteByDeliveryman()->OrderScheduledIn(30)->StoreOrder()->module(Config::get('module.current_module_id'))->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('admin/order/list/processing') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.order.list', ['processing']) }}"
                                        title="{{ __('messages.processing_orders') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            {{ __('messages.processing') }}
                                            <span class="badge badge-soft-warning badge-pill ml-1">
                                                {{ \App\Models\Order::Preparing()->OrderScheduledIn(30)->StoreOrder()->module(Config::get('module.current_module_id'))->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li
                                    class="nav-item {{ Request::is('admin/order/list/item_on_the_way') ? 'active' : '' }}">
                                    <a class="nav-link text-capitalize"
                                        href="{{ route('admin.order.list', ['item_on_the_way']) }}"
                                        title="{{ __('messages.order_on_the_way') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            {{ __('messages.order_on_the_way') }}
                                            <span class="badge badge-soft-warning badge-pill ml-1">
                                                {{ \App\Models\Order::ItemOnTheWay()->OrderScheduledIn(30)->StoreOrder()->module(Config::get('module.current_module_id'))->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('admin/order/list/delivered') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.order.list', ['delivered']) }}"
                                        title="{{ __('messages.delivered_orders') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            {{ __('messages.delivered') }}
                                            <span class="badge badge-soft-success badge-pill ml-1">
                                                {{ \App\Models\Order::Delivered()->StoreOrder()->module(Config::get('module.current_module_id'))->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('admin/order/list/canceled') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.order.list', ['canceled']) }}"
                                        title="{{ __('messages.canceled_orders') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            {{ __('messages.canceled') }}
                                            <span class="badge badge-soft-warning bg-light badge-pill ml-1">
                                                {{ \App\Models\Order::Canceled()->StoreOrder()->module(Config::get('module.current_module_id'))->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('admin/order/list/failed') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.order.list', ['failed']) }}"
                                        title="{{ __('messages.payment_failed_orders') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container text-capitalize">
                                            {{ __('messages.payment_failed') }}
                                            <span class="badge badge-soft-danger bg-light badge-pill ml-1">
                                                {{ \App\Models\Order::failed()->StoreOrder()->module(Config::get('module.current_module_id'))->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('admin/order/list/refunded') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.order.list', ['refunded']) }}"
                                        title="{{ __('messages.refunded_orders') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            {{ __('messages.refunded') }}
                                            <span class="badge badge-soft-danger bg-light badge-pill ml-1">
                                                {{ \App\Models\Order::Refunded()->StoreOrder()->module(Config::get('module.current_module_id'))->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>

                                <li
                                    class="nav-item {{ Request::is('admin/order/offline/payment/list*') ? 'active' : '' }}">
                                    <a class="nav-link "
                                        href="{{ route('admin.order.offline_verification_list', ['all']) }}"
                                        title="{{ __('Offline_Payments') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            {{ __('messages.Offline_Payments') }}
                                            <span class="badge badge-soft-danger bg-light badge-pill ml-1">
                                                {{ \App\Models\Order::has('offline_payments')->StoreOrder()->module(Config::get('module.current_module_id'))->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <!-- Order refund -->
                        <li
                            class="navbar-vertical-aside-has-menu {{ Request::is('admin/refund/*') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                                title="{{ __('Order Refunds') }}">
                                <i class="tio-receipt nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{ __('Order Refunds') }}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{ Request::is('admin/refund*') ? 'block' : 'none' }}">

                                <li
                                    class="nav-item {{ Request::is('admin/refund/requested') || Request::is('admin/refund/rejected') || Request::is('admin/refund/refunded') ? 'active' : '' }}">
                                    <a class="nav-link "
                                        href="{{ route('admin.refund.refund_attr', ['requested']) }}"
                                        title="{{ __('Refund Requests') }} ">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            {{ __('Refund Requests') }}
                                            <span class="badge badge-soft-danger badge-pill ml-1">
                                                {{ \App\Models\Order::Refund_requested()->StoreOrder()->module(Config::get('module.current_module_id'))->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>

                                {{-- <li class="nav-item {{ Request::is('admin/refund/settings') ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('admin.refund.refund_settings') }}"
                                title="{{ __('refund_settings') }}">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate sidebar--badge-container">
                                    {{ __('refund_settings') }}

                                </span>
                            </a>
                        </li> --}}
                            </ul>
                        </li>
                        @endif
                        <!-- Order refund End-->
                        @if (\App\CentralLogics\Helpers::module_permission_check('Item'))
                            <li class="nav-item">
                                <small class="nav-subtitle" title="item_section">Product Management</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>
                            <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('admin/item*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:" title="Product Setup">
                                    <i class="tio-premium-outlined nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize">Product
                                        Setup</span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display:{{ Request::is('admin/item*') ? 'block' : 'none' }}">
                                    <li
                                        class="nav-item {{ Request::is('admin/item/add-new') || (Request::is('admin/item/edit/*') && strpos(request()->fullUrl(), 'product_gellary=1') !== false) ? 'active' : '' }}">
                                        <a class="nav-link " href="{{ route('admin.item.add-new') }}"
                                            title="add_new">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate"> Add New </span>
                                        </a>
                                    </li>
                                    <li
                                        class="nav-item {{ Request::is('admin/item/list') || (Request::is('admin/item/edit/*') && (strpos(request()->fullUrl(), 'temp_product=1') == false && strpos(request()->fullUrl(), 'product_gellary=1') == false)) ? 'active' : '' }}">
                                        <a class="nav-link " href="{{ route('admin.item.list') }}"
                                            title="Item List">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">List</span>
                                        </a>
                                    </li>

                                    <li
                                        class="nav-item {{ Request::is('admin/item/new/item/list') || (Request::is('admin/item/edit/*') && strpos(request()->fullUrl(), 'temp_product=1') !== false) ? 'active' : '' }}">
                                        <a class="nav-link " href="" title="New_Item_Request">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">New Item Request</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{ Request::is('admin/item/reviews') ? 'active' : '' }}">
                                        <a class="nav-link " href="" title="review_list">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">Review</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('admin/category*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:" title="categories">
                                    <i class="tio-category nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Categories</span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display:{{ Request::is('admin/category*') ? 'block' : 'none' }}">
                                    <li class="nav-item {{ Request::is('admin/category') ? 'active' : '' }}">
                                        <a class="nav-link " href="{{ route('admin.category.index') }}"
                                            title="Category">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">Category</span>
                                        </a>
                                    </li>

                                    <li
                                        class="nav-item {{ Request::is('admin/category/sub-category') || Request::is('admin/category/sub-category/add') ? 'active' : '' }}">
                                        <a class="nav-link " href="{{ route('admin.category.sub-category') }}"
                                            title="Sub Category">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">Sub Category</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link " href="" title="sub_category">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">New Category Request</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('admin/attribute*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('admin.attribute.index') }}" title="attributes">
                                    <i class="tio-apps nav-icon"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        Attributes
                                    </span>
                                </a>
                            </li>
                            <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('admin/unit*') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('admin.unit.index') }}" title="units">
                                    <i class="tio-ruler nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize">
                                        {{ __('messages.units') }}
                                    </span>
                                </a>
                            </li>
                        @endif
                        <!-- Store Store -->
                        @if (
                            \App\CentralLogics\Helpers::module_permission_check('Retailer Manage') ||
                                \App\CentralLogics\Helpers::module_permission_check('Wholesaler Manage'))
                            <li class="nav-item">
                                <small class="nav-subtitle" title="Store section">Store Mnagement</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>
                        @endif
                        @if (\App\CentralLogics\Helpers::module_permission_check('Wholesaler Manage'))
                            <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('admin/wholesaler/list') || Request::is('admin/wholesaler/pending-requests') || Request::is('admin/wholesaler/deny-requests') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('admin.wholesaler.list') }}" title="Wholesaler list">
                                    <span class="tio-layout nav-icon"></span>
                                    <span class="text-truncate">Wholesaler list</span>
                                </a>
                            </li>
                        @endif
                        @if (\App\CentralLogics\Helpers::module_permission_check('Retailer Manage'))
                            <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('admin/retailer/list') || Request::is('admin/retailer/pending-requests') || Request::is('admin/retailer/deny-requests') ? 'active' : '' }}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{ route('admin.retailer.list') }}" title="Retailer list">
                                    <span class="tio-poi-user nav-icon"></span>
                                    <span class="text-truncate">Retailer list</span>
                                </a>
                            </li>
                        @endif
                        @if (\App\CentralLogics\Helpers::module_permission_check('employee'))
                            <!-- Employee-->
                            <li class="nav-item">
                                <small class="nav-subtitle" title="Employee handle">Employee Management</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>
                            <li
                                class="navbar-vertical-aside-has-menu {{ Request::is('admin/employee*') ? 'active' : '' }} ">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                    href="javascript:" title="Employee">
                                    <i class="tio-incognito nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Employees</span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display:{{ Request::is('admin/employee*') || Request::is('admin/custom-role*') ? 'block' : 'none' }}">
                                    <li class="nav-item {{ Request::is('admin/employee/add-new') ? 'active' : '' }}">
                                        <a class="nav-link " href="{{ route('admin.employee.add-new') }}"
                                            title="Add new Employee">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">Add New</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{ Request::is('admin/employee/list') ? 'active' : '' }}">
                                        <a class="nav-link " href="{{ route('admin.employee.list') }}"
                                            title="Employee list">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">Employees List</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{ Request::is('admin/custom-role*') ? 'active' : '' }}">
                                        <a class="nav-link " href="{{ route('admin.custom-role.create') }}"
                                            title="Employee Role">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate">Employees Role</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <li
                            class="navbar-vertical-aside-has-menu {{ Request::is('admin/delivery-man*') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                                title="categories">
                                <i class="tio-running nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Deliveryman</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display:{{ Request::is('admin/delivery-man*') ? 'block' : 'none' }}">
                                <li
                                    class="nav-item {{ Request::is('admin/delivery-man/list') || Request::is('admin/delivery-man/add') || Request::is('admin/delivery-man/edit*') || Request::is('admin/delivery-man/preview*') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.delivery-man.list') }}"
                                        title="Sub Category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">Deliveryman list</span>
                                    </a>
                                </li>
                                <li
                                    class="nav-item {{ Request::is('admin/delivery-man/vehicle/list') || Request::is('admin/delivery-man/vehicle/add') || Request::is('admin/delivery-man/vehicle/edit*') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.delivery-man.vehicle.list') }}"
                                        title="sub_category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">Vehicles category</span>
                                    </a>
                                </li>
                                <li
                                    class="nav-item {{ Request::is('admin/delivery-man/reviews/list') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.delivery-man.reviews.list') }}"
                                        title="sub_category">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">Deliveryman reviews</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item py-5">

                        </li>

            </div>
            <!-- End Content -->
        </div>
    </aside>
</div>

<div id="sidebarCompact" class="d-none">

</div>


@push('script_2')
    <script>
        $(window).on('load', function() {
            if ($(".navbar-vertical-content li.active").length) {
                $('.navbar-vertical-content').animate({
                    scrollTop: $(".navbar-vertical-content li.active").offset().top - 150
                }, 10);
            }
        });

        var $rows = $('#navbar-vertical-content li');
        $('#search-sidebar-menu').keyup(function() {
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

            $rows.show().filter(function() {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~text.indexOf(val);
            }).hide();
        });
    </script>
@endpush
