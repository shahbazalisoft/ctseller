@extends('layouts.admin.app')

@section('title','Retailer Details')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-print-none pb-3">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title mb-0">RetailerId #{{$customer['id']}}</h1>
                    <span>
                        <i class="tio-date-range"></i>
                        Joined_at : {{date('d M Y '.config('timeformat'),strtotime($customer['created_at']))}}
                        |  TAX_ID : {{$customer->tax_id}}
                    </span>

                </div>

                <div class="col-sm-auto">
                    <a class="btn btn-icon btn-sm btn-soft-secondary rounded-circle mr-1"
                       href="{{route('admin.retailer.view',[$customer['id']-1])}}"
                       data-toggle="tooltip" data-placement="top" title="Previous Retailer">
                        <i class="tio-arrow-backward"></i>
                    </a>
                    <a class="btn btn-icon btn-sm btn-soft-secondary rounded-circle"
                       href="{{route('admin.retailer.view',[$customer['id']+1])}}" data-toggle="tooltip"
                       data-placement="top" title="Next Retailer">
                        <i class="tio-arrow-forward"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row mb-2 g-2">
            <!-- Collected Cash Card Example -->
            <div class="col-lg-6 col-md-4 col-sm-4">
                <div class="resturant-card card--bg-1">
                    <img class="resturant-icon" src="{{asset('public/assets/admin/img/customer-loyality/1.png')}}" alt="public">
                    <div class="title text-capitalize">{{$customer->wallet_balance??0}}</div>
                    <div class="subtitle">Wallet balance</div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-lg-6 col-md-4 col-sm-4">
                <div class="resturant-card card--bg-2">
                    <img class="resturant-icon" src="{{asset('public/assets/admin/img/customer-loyality/2.png')}}" alt="public">
                    <div class="title text-capitalize">{{$customer->loyalty_point??0}}</div>
                    <div class="subtitle    ">Loyalty point balance</div>
                </div>
            </div>

            <!-- Retailler Docs -->
            <div class="col-lg-6 col-md-4 col-sm-4">
                <div class="card-header">
                    <h5 class="card-title m-0 d-flex align-items-center">
                        <span class="card-header-icon mr-2">
                            <i class="tio-shop-outlined"></i>
                        </span>
                        <span class="ml-1">Retailer documents </span>
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($customer_docs as $keyDoc=>$docVal)
                    <a href="{{route('admin.customer.doc-download',[$customer->id,$docVal])}}" class="text-decoration-none">
                        {{ Str::of($docVal)->limit(30)}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"></path>
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                            </svg>
                      </a>
                      @if($keyDoc < count($customer_docs)-1)&nbsp; | &nbsp;@endif
                    @endforeach
                    {{-- <div class="resturant--info-address">
                        <a href="https://sloop-app.de/admin/store/download/4/2024-03-05-65e70af9714c8.png" class="text-decoration-none"> Document 1</a>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="row" id="printableArea">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="card">
                    <div class="card-header border-0 py-2 d-flex gap-2">
                        <div class="search--button-wrapper">
                            <h5 class="card-title"> Order list <span class="badge badge-soft-secondary">{{ $orders->total() }}</span></h5>
                            <div class="min--260">
                                <div class="input--group input-group">
                                    <input type="text" id="column1_search" class="form-control form-control-sm" placeholder="Ex : search ID">
                                    <button type="button" class="btn btn--secondary">
                                        <i class="tio-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <!-- Unfold -->
                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40" href="javascript:;"
                            data-hs-unfold-options='{
                                    "target": "#usersExportDropdown",
                                    "type": "css-animation"
                                }'>
                            <i class="tio-download-to mr-1"></i> Export
                        </a>

                        <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                            <span class="dropdown-header">Download options</span>
                            <a id="export-excel" class="dropdown-item" href="{{route('admin.retailer.order-export', ['type'=>'excel','id'=>$customer->id,request()->getQueryString()])}}">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{ asset('public/assets/admin') }}/svg/components/excel.svg"
                                    alt="Image Description">
                                    Excel
                            </a>
                            <a id="export-csv" class="dropdown-item" href="{{route('admin.retailer.order-export', ['type'=>'csv','id'=>$customer->id,request()->getQueryString()])}}">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{ asset('public/assets/admin') }}/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                                .csv
                            </a>
                        </div>
                    </div>
                    <!-- End Unfold -->
                    </div>
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
                                <th class="border-0 pl-4">SL</th>
                                <th class="border-0 text-center">Order id</th>
                                <th class="border-0 text-center">Total amount</th>
                                <th class="border-0 text-center">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($orders as $key=>$order)
                                <tr>
                                    <td>
                                        <div class="pl-2">
                                            {{$key+$orders->firstItem()}}
                                        </div>
                                    </td>
                                    <td class="table-column-pl-0 text-center">
                                        <a href="">{{$order['id']}}</a>
                                    </td>
                                    <td>
                                        <div class="text-right mw--85px mx-auto">
                                            {{\App\CentralLogics\Helpers::format_currency($order['order_amount'])}}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--warning btn-outline-warning" href="" title="View "><i class="tio-visible"></i></a>
                                            <a class="btn action-btn btn--primary btn-outline-primary" target="_blank" href="" title="Invoice"><i class="tio-print"></i> </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if(count($orders) !== 0)
                        <hr>
                        @endif
                        <div class="page-area">
                            {!! $orders->links() !!}
                        </div>
                        @if(count($orders) === 0)
                        <div class="empty--data">
                            <img src="{{asset('/public/assets/admin/svg/illustrations/sorry.svg')}}" alt="public">
                            <h5>
                                No data found
                            </h5>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-title">
                            <span class="card-header-icon">
                                <i class="tio-user"></i>
                            </span>
                            <span>{{$customer['f_name'].' '.$customer['l_name']}}</span>
                        </h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    @if($customer)
                        <div class="card-body">
                            <div class="customer--information-single media align-items-center" href="javascript:">
                                <div class="avatar avatar-circle">
                                    <img class="avatar-img" onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'" src="{{asset('storage/app/public/profile/'.$customer->image)}}" alt="Image Description">
                                </div>
                                <div class="media-body">
                                    <ul class="list-unstyled m-0">
                                        <li class="pb-1 d-flex align-items-center">
                                            <i class="tio-layout mr-2"></i>
                                            <span>{{$customer['store_name']}}</span>
                                        </li>
                                        <li class="pb-1 d-flex align-items-center">
                                            <i class="tio-email mr-2"></i>
                                            <span>{{$customer['email']}}</span>
                                        </li>
                                        <li class="pb-1 d-flex align-items-center">
                                            <i class="tio-call-talking-quiet mr-2"></i>
                                            <span>{{$customer['phone']}}</span>
                                        </li>
                                        <li class="pb-1 d-flex align-items-center">
                                            <i class="tio-shopping-basket-outlined mr-2"></i>
                                            <span>{{$customer->order_count}} Orders</span>
                                        </li>
                                        
                                        <li class="pb-1 d-flex align-items-center">
                                            <i class="tio-home-vs-1-outlined mr-2"></i>
                                            <span>{{$customer['store_address']}}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <hr>
                            @foreach($customer->addresses as $address)
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>Addresses</h5>
                                </div>
                                <ul class="list-unstyled list-unstyled-py-2">
                                    <li class="d-flex align-items-center">
                                        <i class="tio-tab mr-2"></i>
                                        <span>{{$address['address_type']}}</span>
                                    </li>
                                    @if($address['contact_person_umber'])
                                    <li class="d-flex align-items-center">
                                        <i class="tio-android-phone-vs mr-2"></i>
                                        <span>{{$address['contact_person_number']}}</span>
                                    </li>
                                    @endif
                                    <li>
                                        <a target="_blank" href="http://maps.google.com/maps?z=12&t=m&q=loc:{{$address['latitude']}}+{{$address['longitude']}}" class="d-flex align-items-center">
                                            <i class="tio-poi mr-2"></i>
                                            {{$address['address']}}
                                        </a>
                                    </li>
                                </ul>
                                <hr>
                            @endforeach

                        </div>
                @endif
                <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->
    </div>
@endsection

@push('script_2')

    <script>
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


            $('#column3_search').on('change', function () {
                datatable
                    .columns(2)
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
