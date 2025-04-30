@extends('layouts.admin.app')

@section('title','Wholesaler List')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title"><i class="tio-filter-list"></i> Wholesaler <span class="badge badge-soft-dark ml-2" id="itemCount">{{$stores->total()}}</span></h1>
            <div class="page-header-select-wrapper">

                {{-- <div class="select-item">
                    <select name="module_id" class="form-control js-select2-custom"
                            onchange="set_filter('{{url()->full()}}',this.value,'module_id')" title="{{translate('messages.select_modules')}}">
                        <option value="" {{!request('module_id') ? 'selected':''}}>{{translate('messages.all_modules')}}</option>
                        @foreach (\App\Models\Module::notParcel()->get() as $module)
                            <option
                                value="{{$module->id}}" {{request('module_id') == $module->id?'selected':''}}>
                                {{$module['module_name']}}
                            </option>
                        @endforeach
                    </select>
                </div> --}}
                {{-- @if(!isset(auth('admin')->user()->zone_id))
                <div class="select-item">
                    <select name="zone_id" class="form-control js-select2-custom"
                            onchange="set_filter('{{url()->full()}}',this.value,'zone_id')">
                        <option value="" {{!request('zone_id')?'selected':''}}>All Zones</option>
                        @foreach(\App\Models\Zone::orderBy('name')->get() as $z)
                            <option
                                value="{{$z['id']}}" {{isset($zone) && $zone->id == $z['id']?'selected':''}}>
                                {{$z['name']}}
                            </option>
                        @endforeach
                    </select>
                </div> --}}
            </div>
        </div>
        <!-- End Page Header -->


        <!-- Resturent Card Wrapper -->
        <div class="row g-3 mb-3">
            <div class="col-xl-3 col-sm-6">
                <div class="resturant-card card--bg-1">
                    @php($total_store = \App\Models\Store::whereHas('vendor', function($query){
                        return $query->where('status', 1);
                    })->where('module_id', Config::get('module.current_module_id'))->count())
                    @php($total_store = isset($total_store) ? $total_store : 0)
                    <h4 class="title">{{$total_store}}</h4>
                    <span class="subtitle">Total stores</span>
                    <img class="resturant-icon" src="{{asset('/public/assets/admin/img/total-store.png')}}" alt="store">
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="resturant-card card--bg-2">
                    @php($active_stores = \App\Models\Store::where(['status'=>1])->where('module_id', Config::get('module.current_module_id'))->count())
                    @php($active_stores = isset($active_stores) ? $active_stores : 0)
                    <h4 class="title">{{$active_stores}}</h4>
                    <span class="subtitle">Active stores</span>
                    <img class="resturant-icon" src="{{asset('/public/assets/admin/img/active-store.png')}}" alt="store">
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="resturant-card card--bg-3">
                    @php($inactive_stores = \App\Models\Store::whereHas('vendor', function($query){
                        return $query->where('status', 1);
                    })->where(['status'=>0])->where('module_id', Config::get('module.current_module_id'))->count())
                    @php($inactive_stores = isset($inactive_stores) ? $inactive_stores : 0)
                    <h4 class="title">{{$inactive_stores}}</h4>
                    <span class="subtitle">Inactive stores</span>
                    <img class="resturant-icon" src="{{asset('/public/assets/admin/img/close-store.png')}}" alt="store">
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="resturant-card card--bg-4">
                    @php($data = \App\Models\Store::where('created_at', '>=', now()->subDays(30)->toDateTimeString())->where('module_id', Config::get('module.current_module_id'))->count())
                    <h4 class="title">{{$data}}</h4>
                    <span class="subtitle">Newly joined stores</span>
                    <img class="resturant-icon" src="{{asset('/public/assets/admin/img/add-store.png')}}" alt="store">
                </div>
            </div>
        </div>
        <!-- Resturent Card Wrapper -->
        <!-- Transaction Information -->
        <div class="row">
            <div class="col-md-12">
                <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
                    <!-- Nav -->
                    <ul class="nav nav-tabs mb-3 border-0 nav--tabs">
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('admin.wholesaler.pending-requests') }}" aria-disabled="true">Pending Wholesaler</a>
                            {{-- active --}}
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.wholesaler.deny-requests') }}" aria-disabled="true">Denied Wholesaler</a>
                        </li>
                    </ul>
                    <!-- End Nav -->
                </div>
            </div>
        </div>
        <!-- Transaction Information -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header py-2">
                <div class="search--button-wrapper">
                    <h5 class="card-title">Wholesaler list</h5>
                    <form  class="search-form">
                                    <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" value="{{ request()?->search ?? null }}" name="search" class="form-control"
                                    placeholder="Ex : Search Store Name" aria-label="Search" >
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>

                        </div>
                        <!-- End Search -->
                    </form>
                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        data-hs-datatables-options='{
                            "order": [],
                            "orderCellsTop": true,
                            "paging":false

                        }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0">Sl</th>
                        <th class="border-0">Store information</th>
                        <th class="border-0">Module</th>
                        <th class="border-0">Owner information</th>
                        <th class="border-0">Zone</th>
                        <th class="text-uppercase border-0">Featured</th>
                        <th class="text-uppercase border-0">Status</th>
                        <th class="text-center border-0">Action</th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    @foreach($stores as $key=>$store)
                        <tr>
                            <td>{{$key+$stores->firstItem()}}</td>
                            <td>
                                <div>
                                    <a href="{{route('admin.wholesaler.view', $store->id)}}" class="table-rest-info" alt="view store">
                                    <img class="img--60 circle" onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                            src="{{asset('storage/app/public/store')}}/{{$store['logo']}}">
                                        <div class="info"><div class="text--title">
                                            {{Str::limit($store->name,20,'...')}}
                                            </div>
                                            <div class="font-light">
                                                Id:{{$store->id}}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <span class="d-block font-size-sm text-body">
                                    {{Str::limit($store->module->module_name,20,'...')}}
                                </span>
                            </td>
                            <td>
                                <span class="d-block font-size-sm text-body">
                                    {{Str::limit($store->vendor->f_name.' '.$store->vendor->l_name,20,'...')}}
                                </span>
                                <div>
                                    {{$store['phone']}}
                                </div>
                            </td>
                            <td>
                                {{$store->zone?$store->zone->name:'Zone deleted'}}
                                {{--<span class="d-block font-size-sm">{{$banner['image']}}</span>--}}
                            </td>
                            <td>
                                <label class="toggle-switch toggle-switch-sm" for="featuredCheckbox{{$store->id}}">
                                    <input type="checkbox" onclick="location.href='" class="toggle-switch-input" id="featuredCheckbox{{$store->id}}" {{$store->featured?'checked':''}}>
                                    <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                            </td>

                            <td>
                                @if(isset($store->vendor->status))
                                    @if($store->vendor->status)
                                    <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$store->id}}">
                                        <input type="checkbox" onclick="status_change_alert('{{route('admin.wholesaler.status',[$store->id,$store->status?0:1])}}', 'You want to change this store status', event)" class="toggle-switch-input" id="stocksCheckbox{{$store->id}}" {{$store->status?'checked':''}}>
                                        <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                    @else
                                    <span class="badge badge-soft-danger">Denied</span>
                                    @endif
                                @else
                                    <span class="badge badge-soft-danger">Pending</span>
                                @endif
                            </td>

                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn--warning btn-outline-warning"
                                            href="{{route('admin.wholesaler.view', $store->id)}}"
                                            title="View"><i
                                                class="tio-visible-outlined"></i>
                                        </a>
                                    <a class="btn action-btn btn--primary btn-outline-primary"
                                    href="{{route('admin.wholesaler.edit',[$store['id']])}}" title="Edit store"><i class="tio-edit"></i>
                                    </a>
                                    <a class="btn action-btn btn--danger btn-outline-danger" href="javascript:"
                                    onclick="form_alert('vendor-{{$store['id']}}','You want to remove this store')" title="Delete store"><i class="tio-delete-outlined"></i>
                                    </a>
                                    <form action="{{route('admin.wholesaler.delete',[$store['id']])}}" method="post" id="vendor-{{$store['id']}}">
                                        @csrf @method('delete')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if(count($stores) !== 0)
                <hr>
                @endif
                <div class="page-area">
                    {!! $stores->withQueryString()->links() !!}
                </div>
                @if(count($stores) === 0)
                <div class="empty--data">
                    <img src="{{asset('/public/assets/admin/svg/illustrations/sorry.svg')}}" alt="public">
                    <h5>
                        No data found
                    </h5>
                </div>
                @endif

            </div>
            <!-- End Table -->
        </div>
        <!-- End Card -->
    </div>

@endsection

@push('script_2')
    <script>
        function status_change_alert(url, message, e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?' ,
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    location.href=url;
                }
            })
        }
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('keyup', function () {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function () {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>

@endpush
