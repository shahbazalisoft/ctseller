@extends('layouts.admin.app')

@section('title', 'Unit')

@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- End Page Header -->
        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper">
                            <h5 class="card-title">
                                Unit List<span class="badge badge-soft-dark ml-2" id="itemCount">{{ $unit->total() }}</span>
                            </h5>
                            <form class="search-form">
                                <!-- Search -->

                                <div class="input-group input--group">
                                    <input id="datatableSearch_" value="{{ request()?->search ?? null }}" type="search"
                                        name="search" class="form-control" placeholder="Unit name" aria-label="Search">
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
                            </form>
                            <!-- Unfold -->
                            <div class="hs-unfold mr-2">
                                <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40"
                                    href="javascript:;"
                                    data-hs-unfold-options='{
                                            "target": "#usersExportDropdown",
                                            "type": "css-animation"
                                        }'>
                                    <i class="tio-download-to mr-1"></i> Export
                                </a>

                                <div id="usersExportDropdown"
                                    class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">

                                    <span class="dropdown-header">Download Options</span>
                                    <a id="export-excel" class="dropdown-item"
                                        href="{{ route('admin.attribute.export-attributes', ['type' => 'excel', request()->getQueryString()]) }}">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="{{ asset('public/assets/admin') }}/svg/components/excel.svg"
                                            alt="Image Description">
                                        Excel
                                    </a>
                                    <a id="export-csv" class="dropdown-item"
                                        href="{{ route('admin.attribute.export-attributes', ['type' => 'csv', request()->getQueryString()]) }}">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="{{ asset('public/assets/admin') }}/svg/components/placeholder-csv-format.svg"
                                            alt="Image Description">
                                        .csv
                                    </a>

                                </div>
                            </div>
                            <!-- End Unfold -->
                            <div>
                                <button class="btn btn--primary rounded font-regular" id="add_new_unit" type="button"
                                    data-toggle="modal" data-target="#add-unit" title="Add Attributes">
                                    <i class="tio-add-circle-outlined"></i> Add New
                                </button>
                            </div>
                        </div>
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
                                <tr class="text-center">
                                    <th class="border-0">SL</th>
                                    <th class="border-0">Unit</th>
                                    <th class="border-0">Action</th>
                                </tr>

                            </thead>

                            <tbody id="set-rows">
                                @foreach ($unit as $key => $row)
                                    <tr>
                                        <td class="text-center">
                                            <span class="mr-3">
                                                {{ $key + 1 }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="font-size-sm text-body mr-3">
                                                {{ Str::limit($row['unit'], 20, '...') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn--container justify-content-center">
                                                <a class="btn action-btn btn--primary btn-outline-primary"
                                                    href="{{ route('admin.unit.edit', [$row['id']]) }}" title="Edit"><i
                                                        class="tio-edit"></i>
                                                </a>
                                                <a class="btn action-btn btn--danger btn-outline-danger" href="javascript:"
                                                    onclick="form_alert('unit-{{ $row['id'] }}','Want to delete this unit ?')"
                                                    title="Delete"><i class="tio-delete-outlined"></i>
                                                </a>
                                                <form action="{{ route('admin.unit.delete', [$row['id']]) }}"
                                                    method="post" id="unit-{{ $row['id'] }}">
                                                    @csrf @method('delete')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if (count($unit) !== 0)
                            <hr>
                        @endif
                        <div class="page-area">
                            {!! $unit->links() !!}
                        </div>
                        @if (count($unit) === 0)
                            <div class="empty--data">
                                <img src="{{ asset('/public/assets/admin/svg/illustrations/sorry.svg') }}" alt="public">
                                <h5>
                                    No data found
                                </h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- End Table -->
        </div>
    </div>


    <div class="modal fade" id="add-unit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="addUnitForm">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <div class="form-group">
                                    <label class="input-label">Unit Name <span
                                            class="input-label-secondary text-danger">*</span></label>
                                    <input type="text" name="unit" id="unit" class="form-control"
                                        placeholder="Enter Unit Name">
                                </div>
                            </div>
                        </div>

                        <div class="btn--container justify-content-end">
                            <button type="button" class="btn btn--reset" data-dismiss="modal">Close</button>
                            <button type="button" id="submit_add_unit" class="btn btn--primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script_2')
    <script>
        $(document).on('ready', function() {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function() {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });


            $('#column3_search').on('change', function() {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function() {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });

            $('#submit_add_unit').on('click', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.unit.store') }}",
                    data: $('#addUnitForm').serialize(),
                    beforeSend: function() {
                        $('#loading').show();
                    },
                    success: function(data) {
                        $('#loading').hide();
                        if (data.errors) {
                            for (var i = 0; i < data.errors.length; i++) {
                                toastr.error(data.errors[i].message, {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                            }
                        } else {
                            toastr.success(
                                'Unit uploaded successfully', {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                            setTimeout(function() {
                                location.href =
                                    '{{ route('admin.unit.index') }}';
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>
@endpush
