@extends('layouts.admin.app')

@section('title', 'New joining requests')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title mr-3">
                <span class="page-header-icon">
                    <img src="{{asset('/public/assets/admin/img/people.png')}}" class="w--26" alt="">
                </span>
                <span>
                    New joining requests
                </span>
            </h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
                        <!-- Nav -->
                        <ul class="nav nav-tabs mb-3 border-0 nav--tabs">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.retailer.list') }}"   aria-disabled="true">Retailer list</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.retailer.pending-requests') }}"   aria-disabled="true">Pending retailers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.retailer.deny-requests') }}"  aria-disabled="true">Denied retailers</a>
                            </li>
                        </ul>
                        <!-- End Nav -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header border-0  py-2">
                <h5 class="card-title">Retailer list <span class="badge badge-soft-dark ml-2" id="itemCount">{{ $customers->total() }}</span></h5>
                <div class="search--button-wrapper justify-content-end">
                    <form class="search-form">
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" name="search" class="form-control min-height-40"
                                value="{{ request()->get('search') }}" placeholder="Search by name"
                                aria-label="Search" required>
                            <button type="submit" class="btn btn--secondary min-height-40"><i class="tio-search"></i></button>
                            {{-- @if (request()->get('search'))
                                <button type="reset" class="btn btn-info mx-1 py-1 min-height-40"
                                    onclick="location.href = '{{ route('admin.users.customer.list') }}'">{{ translate('messages.reset') }}</button>
                            @endif --}}
                        </div>
                        <!-- End Search -->
                    </form>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <div class="card-body p-0">
                <!-- Table -->
                <div class="table-responsive datatable-custom">
                    <table id="datatable"
                        class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" data-hs-datatables-options='{
                            "columnDefs": [{
                                "targets": [0],
                                "orderable": false
                            }],
                            "order": [],
                            "info": {
                            "totalQty": "#datatableWithPaginationInfoTotalQty"
                            },
                            "search": "#datatableSearch",
                            "entries": "#datatableEntries",
                            "pageLength": 25,
                            "isResponsive": false,
                            "isShowPaging": false,
                            "paging":false
                        }'>
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0">
                                    SL
                                </th>
                                <th class="table-column-pl-0 border-0">Name</th>
                                <th class="border-0">Contact information</th>
                                <th class="border-0">Category</th>
                                <th class="border-0">Status</th>
                                <th class="border-0">Actions</th>
                            </tr>
                        </thead>

                        <tbody id="set-rows">
                            @foreach ($customers as $key => $customer)
                                <tr class="">
                                    <td class="">
                                        {{ $key + $customers->firstItem() }}
                                    </td>
                                    <td class="table-column-pl-0">
                                        <a href="{{ route('admin.users.customer.view', [$customer['id']]) }}" class="text--hover">
                                            {{ $customer['f_name'] . ' ' . $customer['l_name'] }}
                                        </a>
                                    </td>
                                    <td>
                                        <div>
                                            {{ $customer['email'] }}
                                        </div>
                                        <div>
                                            {{ $customer['phone'] }}
                                        </div>
                                    </td>
                                    <td>
                                        @if(count($customer->requestCategory))
                                        @php $category = ''; @endphp
                                        @foreach($customer->requestCategory as $keyCat=>$valCat)
                                        @php $category .= '<div>'.$valCat->category.'
                                            <a class="btn action-btn text-danger float-right" style="margin-top: -8px;"  onclick="categorStatus('.$valCat->id.')" href="javascript:"><i class="tio-clear font-weight-bold"></i></a>
                                            <a class="btn action-btn text-primary float-right mr-2" style="margin-top: -8px;" onclick="categorRquest('.$valCat->id.')" href="javascript:"><i class="tio-done font-weight-bold"></i></a>

                                            </div><br>'; @endphp
                                        @endforeach
                                        <span class=""><a href="" data-toggle="modal" data-target="#exampleModal"> {!!$category!!} </a></span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge badge-soft-danger">Pending</span>
                                    </td>
                                    <td>
                                        <div class="btn--container">
                                                <a class="btn action-btn btn--primary btn-outline-primary float-right mr-2" data-toggle="tooltip" data-placement="top"
                                                data-original-title="Approve"
                                                onclick="request_alert('{{route('admin.retailer.update-request',[$customer['id'],1])}}','You want to approve this application')"
                                                    href="javascript:"><i class="tio-done font-weight-bold"></i></a>

                                            <a class="btn action-btn btn--danger btn-outline-danger float-right" data-toggle="tooltip" data-placement="top"
                                            data-original-title="Deny"
                                            onclick="request_alert('{{route('admin.retailer.update-request',[$customer['id'],3])}}','You want to deny this application')"
                                                href="javascript:"><i class="tio-clear font-weight-bold"></i></a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->
            </div>

            @if(count($customers) !== 0)
            <hr>
            @endif
            <div class="page-area">
                {!! $customers->links() !!}
            </div>
            @if(count($customers) === 0)
            <div class="empty--data">
                <img src="{{asset('/public/assets/admin/svg/illustrations/sorry.svg')}}" alt="public">
                <h5>
                    No data found
                </h5>
            </div>
            @endif

        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script_2')
    <script>
        function status_change_alert(url, message, e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
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
                    location.href = url;
                }
            })
        }
        $(document).on('ready', function() {
            // INITIALIZATION OF NAV SCROLLER
            // =======================================================
            $('.js-nav-scroller').each(function() {
                new HsNavScroller($(this)).init()
            });

            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function() {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });


            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#datatable'), {
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        className: 'd-none'
                    },
                    // {
                    //     extend: 'excel',
                    //     className: 'd-none'
                    // },
                    // {
                    //     extend: 'csv',
                    //     className: 'd-none'
                    // },
                    // {
                    //     extend: 'pdf',
                    //     className: 'd-none'
                    // },
                    {
                        extend: 'print',
                        className: 'd-none'
                    },
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child input[type="checkbox"]',
                    classMap: {
                        checkAll: '#datatableCheckAll',
                        counter: '#datatableCounter',
                        counterInfo: '#datatableCounterInfo'
                    }
                },
                language: {
                    zeroRecords: '<div class="text-center p-4">' +
                        '<img class="w-7rem mb-3" src="{{ asset('public/assets/admin') }}/svg/illustrations/sorry.svg" alt="Image Description">' +

                        '</div>'
                }
            });

            $('#export-copy').click(function() {
                datatable.button('.buttons-copy').trigger()
            });

            $('#export-excel').click(function() {
                datatable.button('.buttons-excel').trigger()
            });

            $('#export-csv').click(function() {
                datatable.button('.buttons-csv').trigger()
            });

            $('#export-pdf').click(function() {
                datatable.button('.buttons-pdf').trigger()
            });

            $('#export-print').click(function() {
                datatable.button('.buttons-print').trigger()
            });

            $('#datatableSearch').on('mouseup', function(e) {
                var $input = $(this),
                    oldValue = $input.val();

                if (oldValue == "") return;

                setTimeout(function() {
                    var newValue = $input.val();

                    if (newValue == "") {
                        // Gotcha
                        datatable.search('').draw();
                    }
                }, 1);
            });

            $('#toggleColumn_name').change(function(e) {
                datatable.columns(1).visible(e.target.checked)
            })

            $('#toggleColumn_email').change(function(e) {
                datatable.columns(2).visible(e.target.checked)
            })

            $('#toggleColumn_total_order').change(function(e) {
                datatable.columns(3).visible(e.target.checked)
            })


            $('#toggleColumn_status').change(function(e) {
                datatable.columns(4).visible(e.target.checked)
            })

            $('#toggleColumn_actions').change(function(e) {
                datatable.columns(5).visible(e.target.checked)
            })

            // INITIALIZATION OF TAGIFY
            // =======================================================
            $('.js-tagify').each(function() {
                var tagify = $.HSCore.components.HSTagify.init($(this));
            });
        });
    </script>

    <script>
        $('#search-form').on('submit', function() {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('admin.retailer.search') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#set-rows').html(data.view);
                    $('.card-footer').hide();
                    $('#count').html(data.count);
                },
                complete: function() {
                    $('#loading').hide();
                },
            });
        });
    </script>

    <script>
        function request_alert(url, message) {
            Swal.fire({
                title: 'Are you sure?',
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
                    location.href = url;
                }
            })
        }
        function checkStoreItem(storeId) {
            var url = '{{url('/')}}/admin/store/check-store-item/' + storeId;
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.exists) {
                            Swal.fire({
                            title: 'Warning',
                            text: 'This store has items. Please delete the items first before removing the store.',
                            icon: 'warning',
                            confirmButtonColor: '#FC6A57',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        form_alert('vendor-' + storeId, 'You want to remove this store');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error checking store existence. Status code: ' + xhr.status);
                }
            });
        }
    </script>
@endpush
