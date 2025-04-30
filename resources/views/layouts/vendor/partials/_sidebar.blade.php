<div id="sidebarMain" class="d-none">
    <aside
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered">
        <div class="navbar-vertical-container">
            <div class="navbar-brand-wrapper justify-content-between">
                <!-- Logo -->
                
                <a class="navbar-brand" href="" aria-label="Front">
                    <img class="navbar-brand-logo initial--36" src="http://localhost/sloop_app/sloop/public/assets/admin/img/160x160/img2.jpg" alt="Logo">{{-- {{asset('storage/app/public/store/'.$store_data->logo)}} --}}
                    <img class="navbar-brand-logo-mini initial--36" src="http://localhost/sloop_app/sloop/public/assets/admin/img/160x160/img2.jpg" alt="Logo">
                </a>
                <!-- End Logo -->

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
            <!-- <div class="navbar-vertical-content text-capitalize bg--005555" id="navbar-vertical-content"> -->
            <div class="navbar-vertical-content  bg--005555" id="navbar-vertical-content">
                {{-- <form class="sidebar--search-form">
                    <div class="search--form-group">
                        <button type="button" class="btn"><i class="tio-search"></i></button>
                        <input type="text" class="form-control form--control" placeholder="{{ translate('messages.Search Menu...') }}" id="search-sidebar-menu">
                    </div>
                </form> --}}
                <ul class="navbar-nav navbar-nav-lg nav-tabs">
                    <!-- Dashboards -->
                    <li class="navbar-vertical-aside-has-menu {{Request::is('store-panel')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link" href="" title="Dashboard">
                            <i class="tio-home-vs-1-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"> Dashboard </span>
                        </a>
                    </li>
                    <!-- End Dashboards -->
                    
                    <li class="nav-item">
                        <small class="nav-subtitle" title="{{translate('messages.order_section')}}">{{translate('messages.order_section')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    <!-- Order -->
                    <li class="navbar-vertical-aside-has-menu {{Request::is('store-panel/order*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                            title="{{translate('messages.orders')}}">
                            <i class="tio-shopping-cart nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{translate('messages.orders')}}
                            </span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display: {{Request::is('store-panel/order*')?'block':'none'}}">
                            
                            <li class="nav-item {{Request::is('store-panel/order/list/cooking')?'active':''}}">
                                <a class="nav-link" href="" title="Orders">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        Orders
                                        <span class="badge badge-soft-info badge-pill ml-1"> 12 </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Order -->


                    <li class="nav-item">
                        <small
                            class="nav-subtitle">{{translate('messages.item_management')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>
                    @if(\App\CentralLogics\Helpers::employee_module_permission_check('item'))
                    <!-- Food -->
                    <li class="navbar-vertical-aside-has-menu {{Request::is('store-panel/item*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="{{translate('messages.items')}}"
                        >
                            <i class="tio-premium-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('messages.items')}}</span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display: {{Request::is('store-panel/item*')?'block':'none'}}">
                            <li class="nav-item {{Request::is('store-panel/item/add-new')?'active':''}}">
                                <a class="nav-link " href="" title="Add New">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="">Add New</span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('store-panel/item/list')?'active':''}}">
                                <a class="nav-link " href="" title="List">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">List</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Food -->
                    @endif
                </ul>
            </div>
            <!-- End Content -->
        </div>
    </aside>
</div>

<div id="sidebarCompact" class="d-none">

</div>

@push('script_2')
<script>
    $(window).on('load' , function() {
        if($(".navbar-vertical-content li.active").length) {
            $('.navbar-vertical-content').animate({
                scrollTop: $(".navbar-vertical-content li.active").offset().top - 150
            }, 10);
        }
    });

    // var $rows = $('#navbar-vertical-content li');
    // $('#search-sidebar-menu').keyup(function() {
    //     var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    //     $rows.show().filter(function() {
    //         var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
    //         return !~text.indexOf(val);
    //     }).hide();
    // });
</script>
@endpush
