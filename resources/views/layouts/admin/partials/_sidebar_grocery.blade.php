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
                    @if (\App\CentralLogics\Helpers::module_permission_check('Order'))
                        <li class="nav-item">
                            <small class="nav-subtitle">Order Management</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/order') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                                title="Orders">
                                <i class="tio-shopping-cart nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    Orders
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display:{{ Request::is('admin/order*') ? 'block' : 'none' }}">
                                <li class="nav-item {{ Request::is('admin/order/list/all') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('admin.order.list', ['all']) }}"
                                        title="all_orders">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            All
                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                0
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('admin/order/list/scheduled') ? 'active' : '' }}">
                                    <a class="nav-link" href="" title="scheduled_orders">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            Scheduled
                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                0
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (\App\CentralLogics\Helpers::module_permission_check('Item'))
                        <li class="nav-item">
                            <small class="nav-subtitle" title="item_section">Product Management</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/item*') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                                title="Product Setup">
                                <i class="tio-premium-outlined nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize">Product
                                    Setup</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display:{{ Request::is('admin/item*') ? 'block' : 'none' }}">
                                <li
                                    class="nav-item {{ Request::is('admin/item/add-new') || (Request::is('admin/item/edit/*') && strpos(request()->fullUrl(), 'product_gellary=1') !== false) ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.item.add-new') }}" title="add_new">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate"> Add New </span>
                                    </a>
                                </li>
                                <li
                                    class="nav-item {{ Request::is('admin/item/list') || (Request::is('admin/item/edit/*') && (strpos(request()->fullUrl(), 'temp_product=1') == false && strpos(request()->fullUrl(), 'product_gellary=1') == false)) ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.item.list') }}" title="Item List">
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
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                                title="categories">
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
                        <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/unit*') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{ route('admin.unit.index') }}" title="units">
                                <i class="tio-ruler nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize">
                                    Units
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
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                                title="Employee">
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

                    <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/delivery-man*') ? 'active' : '' }}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                            title="categories">
                            <i class="tio-running nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Deliveryman</span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display:{{ Request::is('admin/delivery-man*') ? 'block' : 'none' }}">
                            <li class="nav-item {{ Request::is('admin/delivery-man/list') || Request::is('admin/delivery-man/add') || Request::is('admin/delivery-man/edit*') || Request::is('admin/delivery-man/preview*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('admin.delivery-man.list') }}"
                                    title="Sub Category">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Deliveryman list</span>
                                </a>
                            </li>
                            <li class="nav-item {{ Request::is('admin/delivery-man/vehicle/list') || Request::is('admin/delivery-man/vehicle/add') || Request::is('admin/delivery-man/vehicle/edit*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('admin.delivery-man.vehicle.list') }}" title="sub_category">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">Vehicles category</span>
                                </a>
                            </li>
                            <li class="nav-item {{ Request::is('admin/delivery-man/reviews/list') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('admin.delivery-man.reviews.list') }}" title="sub_category">
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
