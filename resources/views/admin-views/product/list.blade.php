@extends('layouts.admin.app')

@section('title','Item List')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center g-2">
                <div class="col-md-9 col-12">
                    <h1 class="page-header-title">
                        <span class="page-header-icon">
                            <img src="{{asset('public/assets/admin/img/items.png')}}" class="w--22" alt="">
                        </span>
                        <span>
                            Item List <span class="badge badge-soft-dark ml-2" id="foodCount">{{$items->total()}}</span>
                        </span>
                    </h1>
                </div>
                {{-- <div class="col-sm-6 col-md-3">
                    <select name="module_id" class="form-control js-select2-custom" onchange="set_filter('{{url()->full()}}',this.value,'module_id')" title="{{translate('messages.select_modules')}}">
                        <option value="" {{!request('module_id') ? 'selected':''}}>{{translate('messages.all_modules')}}</option>
                        @foreach (\App\Models\Module::notParcel()->get() as $module)
                            <option
                                value="{{$module->id}}" {{request('module_id') == $module->id?'selected':''}}>
                                {{$module['module_name']}}
                            </option>
                        @endforeach
                    </select>
                </div> --}}
            </div>

        </div>
        <!-- End Page Header -->
        <!-- Card -->
            <div class="card mb-3">
                <!-- Header -->
                <div class="card-header py-2 border-0">
                    <h1>Search Data</h1>
                </div>
                    <div class="row mr-1 ml-2 mb-5">
                        <div class="col-sm-6 col-md-3   ">
                            <div class="select-item">
                            <select name="store_id" id="store" onchange="set_store_filter('{{url()->full()}}',this.value)" data-placeholder="Select Store" class="js-data-example-ajax form-control" onchange="getStoreData('{{url('/')}}/admin/store/get-addons?data[]=0&store_id=',this.value,'add_on')" required title="Select Store" oninvalid="this.setCustomValidity('please_select_store')">
                                @if($store)
                                <option value="{{$store->id}}" selected>{{$store->name}}</option>
                                @else
                                <option value="all" selected>All Stores</option>
                                @endif
                                </select>
                            </div>
                        </div>
                        

                        <div class="col-sm-6 col-md-3">
                            <div class="select-item">

                                <select name="category_id" id="category_id" data-placeholder="Select Category"
                                    class="js-data-example-ajax form-control" id="category_id"
                                    onchange="set_filter('{{url()->full()}}',this.value,'category_id')">
                                    @if($category)
                                    <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                    @else
                                    <option value="all" selected>All Category</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="select-item">
                                <select name="sub_category_id" class="form-control js-select2-custom" data-placeholder="Select Sub Category" id="sub-categories" onchange="set_filter('{{url()->full()}}',this.value,'sub_category_id')">
                                    <option value="all" selected>All Sub Category</option>
                                    @foreach($sub_categories as $z)
                                    <option
                                        value="{{$z['id']}}" {{ request()?->sub_category_id == $z['id']?'selected':''}}>
                                        {{$z['name']}}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

            </div>

        <div class="card">
            <!-- Header -->
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper justify-content-end">
                    <form class="search-form">
                    {{-- @csrf --}}
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch" name="search" value="{{ request()?->search ?? null }}" type="search" class="form-control h--40px" placeholder="Search.." aria-label="Search Here">
                            <button type="submit" class="btn btn--secondary h--40px"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>
                    <div>
                        <a href="{{ route('admin.item.add-new') }}" class="btn btn--primary font-regular"><i class="tio-add-circle"></i> New Product</a>
                    </div>
                    
                    <div>
                        <a href="" class="btn btn--primary font-regular">Limited Stock</a>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom" id="table-div">
                <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                    data-hs-datatables-options='{
                        "columnDefs": [{
                            "targets": [],
                            "width": "5%",
                            "orderable": false
                        }],
                        "order": [],
                        "info": {
                        "totalQty": "#datatableWithPaginationInfoTotalQty"
                        },

                        "entries": "#datatableEntries",

                        "isResponsive": false,
                        "isShowPaging": false,
                        "paging":false
                    }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0">SL</th>
                        <th class="border-0">Name</th>
                        <th class="border-0">Category</th>
                        <th class="border-0">Store</th>
                        <th class="border-0 text-center">Price</th>
                        <th class="border-0 text-center">Tax</th>
                        <th class="border-0 text-center">Status</th>
                        <th class="border-0 text-center">Action</th>
                    </tr>
                    </thead>
                    
                    <tbody id="set-rows">
                    @foreach($items as $key=>$item)
                        <tr>
                            <td>{{$key+$items->firstItem()}}</td>
                            <td>
                                <a class="media align-items-center" href="{{route('admin.item.view',[$item['id']])}}">
                                    <img class="avatar avatar-lg mr-3" src="{{asset('storage/app/public/product')}}/{{$item['image']}}"
                                            onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" alt="{{$item->name}} image">
                                    <div class="media-body">
                                        <h5 class="text-hover-primary mb-0">{{Str::limit($item['name'],20,'...')}}</h5>
                                    </div>
                                </a>
                            </td>
                            <td>
                            {{$item->category->name}}
                            </td>
                            <td>
                                @if ($item->store)
                                <a href="{{route('admin.store.view', $item->store->id)}}" class="table-rest-info" alt="view store"> {{  Str::limit($item->store->name, 20, '...') }}</a>
                                @else
                                Store Deleted!
                                @endif

                            </td>
                            <td>
                                <div class="text-right mw--85px">
                                    {{\App\CentralLogics\Helpers::format_currency($item['price'])}}
                                </div>
                            </td>
                            <td>
                                <div class="text-center mw--85px">
                                    {{ $item['tax'] }}%
                                </div>
                            </td>
                            <td>
                                <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$item->id}}">
                                    <input type="checkbox" onclick="location.href='{{route('admin.item.status',[$item['id'],$item->status?0:1])}}'"class="toggle-switch-input" id="stocksCheckbox{{$item->id}}" {{$item->status?'checked':''}}>
                                    <span class="toggle-switch-label mx-auto">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn--primary btn-outline-primary"
                                        href="{{route('admin.item.edit',[$item['id']])}}" title="Edit Item"><i class="tio-edit"></i>
                                    </a>
                                    <a class="btn  action-btn btn--danger btn-outline-danger" href="javascript:"
                                        onclick="form_alert('food-{{$item['id']}}','Want to delete this item ?')" title="Delete item"><i class="tio-delete-outlined"></i>
                                    </a>
                                    <form action="{{route('admin.item.delete',[$item['id']])}}"
                                            method="post" id="food-{{$item['id']}}">
                                        @csrf @method('delete')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if(count($items) !== 0)
                <hr>
                @endif
                <div class="page-area">
                        <tfoot class="border-top">
                        {!! $items->withQueryString()->links() !!}
                </div>
                @if(count($items) === 0)
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
        var datatable = $.HSCore.components.HSDatatables.init($('#datatable'), {
          select: {
            style: 'multi',
            classMap: {
              checkAll: '#datatableCheckAll',
              counter: '#datatableCounter',
              counterInfo: '#datatableCounterInfo'
            }
          },
          language: {
            zeroRecords: '<div class="text-center p-4">' +
                '<img class="w-7rem mb-3" src="{{asset('public/assets/admin/svg/illustrations/sorry.svg')}}" alt="Image Description">' +

                '</div>'
          }
        });

        $('#datatableSearch').on('mouseup', function (e) {
          var $input = $(this),
            oldValue = $input.val();

          if (oldValue == "") return;

          setTimeout(function(){
            var newValue = $input.val();

            if (newValue == ""){
              // Gotcha
              datatable.search('').draw();
            }
          }, 1);
        });

        $('#toggleColumn_index').change(function (e) {
          datatable.columns(0).visible(e.target.checked)
        })
        $('#toggleColumn_name').change(function (e) {
          datatable.columns(1).visible(e.target.checked)
        })

        $('#toggleColumn_type').change(function (e) {
          datatable.columns(2).visible(e.target.checked)
        })

        $('#toggleColumn_vendor').change(function (e) {
          datatable.columns(3).visible(e.target.checked)
        })

        $('#toggleColumn_status').change(function (e) {
          datatable.columns(5).visible(e.target.checked)
        })
        $('#toggleColumn_price').change(function (e) {
          datatable.columns(4).visible(e.target.checked)
        })
        $('#toggleColumn_action').change(function (e) {
          datatable.columns(6).visible(e.target.checked)
        })

            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

        $('#store').select2({
            ajax: {
                url: '{{url('/')}}/admin/store/get-stores',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        all:true,
                        module_id:1,
                        page: params.page
                    };
                },
                processResults: function (data) {
                    return {
                    results: data
                    };
                },
                __port: function (params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#category_id').select2({
            ajax: {
                url: '{{route("admin.category.get-all")}}',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        all:true,
                        module_id:1,
                        page: params.page
                    };
                },
                processResults: function (data) {
                    return {
                    results: data
                    };
                },
                __port: function (params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });


        $('#condition_id').select2({
            ajax: {
                url: '{{ url('/') }}/admin/common-condition/get-all',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        all:true,
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });
    </script>
@endpush
