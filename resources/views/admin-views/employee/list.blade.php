@extends('layouts.admin.app')
@section('title','Employee List')
@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid">
    <div class="page-header">
    <!-- Page Heading -->
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <h1 class="page-header-title mb-3 mr-1">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/role.png')}}" class="w--26" alt="">
                </span>
                <span>
                    Employee List
                </span>
            </h1>
            <a href="{{route('admin.employee.add-new')}}" class="btn btn--primary mb-3">
                <i class="tio-add-circle"></i>
                <span class="text">Add New</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2 border-0">
                    <div class="search--button-wrapper">
                        <h5 class="card-title">Employee <span class="badge badge-soft-dark ml-2" id="itemCount">{{$em->total()}}</span></h5>
                        <form class="search-form min--200">
                            {{-- @csrf --}}
                            <!-- Search -->
                            <div class="input-group input--group">
                                <input id="datatableSearch_" type="search" name="search"  value="{{ request()->get('search') }}" class="form-control" placeholder="ex: search name" aria-label="Search">
                                <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                            </div>
                            <!-- End Search -->
                        </form>
                                            <!-- Unfold -->
                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle h--45px min-height-40" href="javascript:;"
                            data-hs-unfold-options='{
                                    "target": "#usersExportDropdown",
                                    "type": "css-animation"
                                }'>
                            <i class="tio-download-to mr-1"></i> Export
                        </a>

                        <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                            <span class="dropdown-header">Download Options</span>
                            <a id="export-excel" class="dropdown-item" href="{{route('admin.employee.export', ['type'=>'excel',request()->getQueryString()])}}">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{ asset('public/assets/admin') }}/svg/components/excel.svg"
                                    alt="Image Description">
                                    Excel
                            </a>
                            <a id="export-csv" class="dropdown-item" href="{{route('admin.employee.export', ['type'=>'csv',request()->getQueryString()])}}">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{ asset('public/assets/admin') }}/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                                .csv
                            </a>
                        </div>
                    </div>
                    <!-- End Unfold -->
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="datatable"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th class="border-0">SL</th>
                                <th class="border-0">Name</th>
                                <th class="border-0">Email</th>
                                <th class="border-0">Phone</th>
                                <th class="border-0">Role</th>
                                <th class="border-0 text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody id="set-rows">
                            @foreach($em as $k=>$e)
                                <tr>
                                    <th scope="row">{{$k+$em->firstItem()}}</th>
                                    <td class="text-capitalize">{{$e['f_name']}} {{$e['l_name']}}</td>
                                    <td >
                                      {{$e['email']}}
                                    </td>
                                    <td>{{$e['phone']}}</td>
                                    <td>{{$e->role?$e->role['name']:'Role deleted'}}</td>
                                    <td>
                                        @if (auth('admin')->id()  != $e['id'])
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--primary btn-outline-primary"
                                                href="{{route('admin.employee.edit',[$e['id']])}}" title="Edit Employee"><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger" href="javascript:"
                                                onclick="form_alert('employee-{{$e['id']}}','Want to delete this role')" title="Delete Employee"><i class="tio-delete-outlined"></i>
                                            </a>
                                        </div>
                                        <form action="{{route('admin.employee.delete',[$e['id']])}}"
                                                method="post" id="employee-{{$e['id']}}">
                                            @csrf @method('delete')
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($em) !== 0)
                <hr>
                @endif
                <div class="page-area">
                    {!! $em->links() !!}
                </div>
                @if(count($em) === 0)
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
</div>
@endsection

@push('script_2')
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.employee.search')}}',
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
