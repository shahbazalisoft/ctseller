@extends('layouts.admin.app')

@section('title', 'Attributes')

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
                                Attribute List<span class="badge badge-soft-dark ml-2"
                                    id="itemCount">{{ $attributes->total() }}</span>
                            </h5>
                            <form class="search-form">
                                <!-- Search -->

                                <div class="input-group input--group">
                                    <input id="datatableSearch_" value="{{ request()?->search ?? null }}" type="search"
                                        name="search" class="form-control" placeholder="Attribute name"
                                        aria-label="Search">
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
                                <button class="btn btn--primary rounded font-regular" id="add_new_attributes" type="button"
                                    data-toggle="modal" data-target="#add-attributes" title="Add Attributes">
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
                                    <th class="border-0">Name</th>
                                    <th class="border-0">Action</th>
                                </tr>

                            </thead>

                            <tbody id="set-rows">
                                @foreach ($attributes as $key => $attribute)
                                    <tr>
                                        <td class="text-center">
                                            <span class="mr-3">
                                                {{ $key + $attributes->firstItem() }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="font-size-sm text-body mr-3">
                                                {{ Str::limit($attribute['name'], 20, '...') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn--container justify-content-center">
                                                <a class="btn action-btn btn--primary btn-outline-primary"
                                                    href="{{ route('admin.attribute.edit', [$attribute['id']]) }}"
                                                    title="Edit"><i class="tio-edit"></i>
                                                </a>
                                                <a class="btn action-btn btn--danger btn-outline-danger" href="javascript:"
                                                    onclick="form_alert('attribute-{{ $attribute['id'] }}','Want to delete this attribute ?')"
                                                    title="Delete"><i class="tio-delete-outlined"></i>
                                                </a>
                                                <form action="{{ route('admin.attribute.delete', [$attribute['id']]) }}"
                                                    method="post" id="attribute-{{ $attribute['id'] }}">
                                                    @csrf @method('delete')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if (count($attributes) !== 0)
                            <hr>
                        @endif
                        <div class="page-area">
                            {!! $attributes->links() !!}
                        </div>
                        @if (count($attributes) === 0)
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


    <div class="modal fade" id="add-attributes" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Attributes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="addAttributeForm">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <div class="form-group">
                                    <label class="input-label">Attribute Name <span
                                            class="input-label-secondary text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Attribute Name">
                                </div>
                            </div>
                        </div>

                        <div class="btn--container justify-content-end">
                            <button type="button" class="btn btn--reset" data-dismiss="modal">Close</button>
                            <button type="button" id="submit_add_attribute" class="btn btn--primary">Submit</button>
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

            $('#submit_add_attribute').on('click', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.attribute.store') }}",
                    data: $('#addAttributeForm').serialize(),
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
                                'Attribute uploaded successfully', {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                            setTimeout(function() {
                                location.href =
                                    '{{ route('admin.attribute.index') }}';
                            }, 2000);
                        }
                    }
                });
            });
        });
    </script>
@endpush
