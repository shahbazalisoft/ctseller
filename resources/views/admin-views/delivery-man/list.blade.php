@extends('layouts.admin.app')

@section('title','Deliverymen')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <!-- Page Heading -->
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <h1 class="page-header-title mb-3 mr-1">
                        <span class="page-header-icon">
                            <img src="{{asset('public/assets/admin/img/delivery-man.png')}}" class="w--26" alt="">
                        </span>
                        <span>
                            Deliverymen
                        </span>
                    </h1>
                    <a href="{{ route('admin.delivery-man.add') }}" class="btn btn--primary mb-3">
                        <i class="tio-add-circle"></i>
                        <span class="text">Add New</span>
                    </a>
                </div>
            </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    <h5 class="card-title">
                        Deliveryman list<span class="badge badge-soft-dark ml-2" id="itemCount">{{$delivery_men->total()}}</span>
                    </h5>
                    
                    <form class="search-form">
                                    <!-- Search -->
                        {{-- @csrf --}}
                        <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" name="search" class="form-control h--45px"
                                    placeholder="Ex : search name" value="{{ request()->get('search') }}" aria-label="Search" required>
                            <button type="submit" class="btn btn--secondary h--45px"><i class="tio-search"></i></button>

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
                        <th class="border-0 text-capitalize">SL</th>
                        <th class="border-0 text-capitalize">Name</th>
                        <th class="border-0 text-capitalize">Contact info</th>
                        <th class="border-0 text-capitalize">Zone</th>
                        <th class="border-0 text-capitalize">Total orders</th>
                        <th class="border-0 text-capitalize">Availability status</th>
                        <th class="border-0 text-center text-capitalize">Action</th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    @foreach($delivery_men as $key=>$dm)
                        <tr>
                            <td>{{$key+$delivery_men->firstItem()}}</td>
                            <td>
                                <a class="table-rest-info" href="{{route('admin.delivery-man.preview',[$dm['id']])}}">
                                    <img onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                            src="{{asset('storage/app/public/delivery-man')}}/{{$dm['image']}}" alt="{{$dm['f_name']}} {{$dm['l_name']}}">
                                    <div class="info">
                                        <h5 class="text-hover-primary mb-0">{{$dm['f_name'].' '.$dm['l_name']}}</h5>
                                        <span class="d-block text-body">
                                            <span class="rating">
                                            <i class="tio-star"></i> {{count($dm->rating)>0?number_format($dm->rating[0]->average, 1, '.', ' '):0}}
                                            </span>
                                        </span>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a class="deco-none" href="tel:{{$dm['phone']}}">{{$dm['phone']}}</a>
                            </td>
                            <td>
                                @if($dm->zone)
                                <label class="text--title font-medium mb-0">{{$dm->zone->name}}</label>
                                @else
                                <label class="text--title font-medium mb-0">Zone deleted</label>
                                @endif
                            </td>
                            <td>
                                <a class="deco-none" href="tel:{{$dm['phone']}}">{{count($dm['orders'])}}</a>
                            </td>
                            <td>
                                <div>
                                    Currently assigned orders : {{$dm->current_orders}}
                                </div>
                                <div>
                                    Active status :
                                    @if($dm->application_status == 'approved')
                                        @if($dm->active)
                                        <strong class="text-capitalize text-primary">Online</strong>
                                        @else
                                        <strong class="text-capitalize text-secondary">Offline</strong>
                                        @endif
                                    @elseif ($dm->application_status == 'denied')
                                        <strong class="text-capitalize text-danger">Denied</strong>
                                    @else
                                        <strong class="text-capitalize text-info">Pending</strong>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn--warning btn-outline-warning"
                                            href="{{route('admin.delivery-man.preview',[$dm['id']])}}"
                                            title="View"><i
                                                class="tio-visible-outlined"></i>
                                        </a>
                                    <a class="btn action-btn btn--primary btn-outline-primary" href="{{route('admin.delivery-man.edit',[$dm['id']])}}" title="Edit"><i class="tio-edit"></i>
                                        </a>
                                        <a class="btn action-btn btn--danger btn-outline-danger" href="javascript:" onclick="form_alert('delivery-man-{{$dm['id']}}','Want to remove this deliveryman ?')" title="Delete"><i class="tio-delete-outlined"></i>
                                    </a>
                                    <form action="{{route('admin.delivery-man.delete',[$dm['id']])}}" method="post" id="delivery-man-{{$dm['id']}}">
                                        @csrf @method('delete')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if(count($delivery_men) !== 0)
                <hr>
                @endif
                <div class="page-area">
                    {!! $delivery_men->links() !!}
                </div>
                @if(count($delivery_men) === 0)
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

    <script>
        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.delivery-man.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('#itemCount').html(data.count);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
