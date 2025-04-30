@extends('layouts.vendor.app')

@section('title',translate('messages.flash_sales'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/condition.png')}}" class="w--26" alt="">
                </span>
                <span>
                    {{translate('messages.flash_sale_product_setup')}}
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('vendor.flash-sale.store-product') }}" method="post">
                            @csrf
                            <input type="hidden" name="flash_sale_id" value="{{$flash_id}}">
                            {{-- {{ $flash_sale->id }} --}}
                            <div class="row mb-3">
                                <div class="col-12 mb-2">
                                    <div class="form-group mb-0" id="item_wise">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.select_item')}}</label>
                                        <select name="item_id" id="choice_item" class="form-control js-select2-custom" placeholder="{{translate('messages.select_item')}}">
                                            <option value="">---Select---</option>
                                            @foreach($itemFlash as $val)
                                                <option value="{{$val->id}}">{{$val->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.feature_category')}}</label>
                                        <select id="category" name="category[]" class="form-control js-select2-custom" multiple="multiple">
                                            @foreach ($category as $valCat)
                                            <option value="{{$valCat->id}}">{{$valCat->name}}</option>
                                            @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="total_stock">{{ translate('messages.total_stock') }}</label>
                                        <input type="number" placeholder="{{ translate('messages.Ex:_10') }}" class="form-control" name="stock" min="0" id="quantity">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.discount_type') }}<span
                                                class="input-label-secondary text--title" data-toggle="tooltip"
                                                data-placement="right"
                                                data-original-title="{{ translate('Admin_shares_the_same_percentage/amount_on_discount_as_he_takes_commissions_from_stores') }}">
                                                <i class="tio-info-outined"></i>
                                            </span>
                                        </label>
                                        <select name="discount_type" id="discount_type"
                                            class="form-control js-select2-custom">
                                            {{-- <option value="current_active_discount">{{ translate('messages.current_active_discount') }}</option> --}}
                                            <option value="percent">{{ translate('messages.percent') }}</option>
                                            <option value="amount">{{ translate('messages.amount') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.discount') }}</label>
                                        <input type="number" min="0" max="9999999999999999999999" value="0" step="0.001"
                                            name="discount" class="form-control" id="discount_amount"
                                            placeholder="{{ translate('messages.Ex:') }} 100">
                                    </div>
                                </div>
                            </div>

                            <div class="btn--container justify-content-end">
                                <button type="reset" class="btn btn--reset">{{translate('messages.reset')}}</button>
                                <button type="submit" class="btn btn--primary">{{translate('messages.submit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper">
                            <h5 class="card-title">
                                {{translate('messages.flash_sale_product_list')}}<span class="badge badge-soft-dark ml-2" id="itemCount">{{$items->total()}}</span>
                            </h5>
                            <form  class="search-form">
                                <!-- Search -->

                                <div class="input-group input--group">
                                    <input id="datatableSearch_" value="{{ request()?->search ?? null }}" type="search" name="search" class="form-control"
                                            placeholder="{{translate('ex_:_name')}}" aria-label="Search" >
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
                            </form>
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
                                <th class="border-0">{{translate('sl')}}</th>
                                <th class="border-0">{{translate('messages.product')}}</th>
                                <th class="border-0">{{translate('messages.Current_Stock')}}</th>
                                <th class="border-0">{{translate('messages.Flash_sale_Qty')}}</th>
                                <th class="border-0">{{translate('messages.Qty_Sold')}}</th>
                                <th class="border-0">{{translate('messages.Discount')}}</th>
                                <th class="border-0">{{translate('messages.Sold_Amount')}}</th>
                                <th class="border-0">{{translate('messages.status')}}</th>
                                <th class="border-0">{{translate('messages.publish')}}</th>
                                <th class="border-0">{{translate('messages.action')}}</th>
                            </tr>

                            </thead>

                            <tbody id="set-rows">
                            @foreach($items as $key=>$item)
                                <tr>
                                    <td class="text-center">
                                        <span class="mr-3">
                                            {{$key+$items->firstItem()}}
                                        </span>
                                    </td>

                                    <?php
                                    $t2= Carbon\Carbon::parse($item->flashSale->end_date) ;
                                    ?>


                                    <td class="text-center">
                                        <a class="media align-items-center" href="{{route('vendor.item.view',[$item['item_id']])}}">
                                            <img class="avatar avatar-lg mr-3" src="{{asset('storage/app/public/product')}}/{{$item->item['image']}}"
                                                    onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" alt="{{$item->item->name}} image">
                                            <div class="media-body">
                                                <h5 class="text-hover-primary mb-0">{{Str::limit($item->item['name'],20,'...')}}</h5>
                                            </div>
                                        </a>
                                    </td>

                                    <td class="text-center">
                                        {{ $item['available_stock'] }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item['stock'] }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item['sold'] }}
                                    </td>
                                    <td class="text-center">
                                        @if($item->discount_type == 'percent')
                                        {{$item['discount']}} %
                                        @else
                                        {{\App\CentralLogics\Helpers::format_currency($item['discount'])}}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{\App\CentralLogics\Helpers::format_currency($item['price'] * $item['sold'])}}

                                    </td>
                                    <td class="text-center">
                                        @if($item['status'] == 0 || $item->flashSale->is_publish == 0)
                                        <span class="badge badge-soft-info">{{ translate('off')}}</span>
                                        @elseif($item->flashSale->is_publish == 1 && $t2->gte(now())  )
                                        <span class="badge badge-soft-success"> {{ translate('running')}} </span>
                                        @else
                                        <span class="badge badge-soft-danger">{{ translate('expired')}}</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <label class="toggle-switch toggle-switch-sm" for="publishCheckbox{{$item->id}}">
                                            <input type="checkbox" onclick="location.href='{{route('vendor.flash-sale.status-product',[$item['id'],$item->status?0:1])}}'"class="toggle-switch-input" id="publishCheckbox{{$item->id}}" {{$item->status?'checked':''}}>
                                            <span class="toggle-switch-label mx-auto">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--danger btn-outline-danger" href="javascript:" onclick="form_alert('item-{{$item['id']}}','{{ translate('Want to delete this item ?') }}')" title="{{translate('messages.delete')}}"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="{{route('vendor.flash-sale.delete-product',[$item['id']])}}"
                                                    method="post" id="item-{{$item['id']}}">
                                                @csrf @method('delete')
                                            </form>
                                            <a class="btn action-btn btn--primary btn-outline-primary" onclick="show_category('{{$item['id']}}')" title="{{translate('messages.feature_category')}}"><i class="tio-visible-outlined"></i></a>
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
                            {!! $items->links() !!}
                        </div>
                        @if(count($items) === 0)
                        <div class="empty--data">
                            <img src="{{asset('/public/assets/admin/svg/illustrations/sorry.svg')}}" alt="public">
                            <h5>
                                {{translate('no_data_found')}}
                            </h5>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- End Table -->
             <!-- Modal -->
             <div class="modal fade bd-example-modal-sm" id="showCategoryModel" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title h4" id="mySmallModalLabel">{{translate('messages.feature_category')}}</h5>
                                <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal"
                                    aria-label="Close">
                                    <i class="tio-clear tio-lg"></i>
                                </button>

                            </div>
                                @csrf
                                <div class="modal-body">
                                    <span>
                                         {{translate('Selected_Features_Category')}}
                                    </span>
                                    <hr>
                                    <span id="show_category_result"></span>
                                    <!-- Input Group -->
                                </div>


                        </div>
                    </div>
                </div>
        <!-- End Modal -->
        </div>
    </div>

@endsection

@push('script_2')
<script>
    function show_category(id)
        {
            $.get({
                url: '{{ route('vendor.flash-sale.show_category') }}',
                data : { id : id},
                dataType: 'json',
                success: function (data) {
                    if(data.status == 'success'){
                        $('#show_category_result').html(data.result);
                        $('#showCategoryModel').modal('show');
                    }else{
                        $('#show_category_result').html('No Category Selected');
                        $('#showCategoryModel').modal('show');
                    }
                    //
                }
            });
        }
</script>
<script>
    var zone_id = [];
    var module_id = {{Config::get('module.current_module_id')}};
    function get_items()
    {
        var nurl = '{{url('/')}}/admin/item/get-items-flashsale?module_id='+module_id;

        if(!Array.isArray(zone_id))
        {
            nurl += '&zone_id='+zone_id;
        }

        $.get({
            url: nurl,
            dataType: 'json',
            success: function (data) {
                $('#choice_item').empty().append(data.options);
            }
        });
    }
    $(document).on('ready', function () {
        module_id = {{Config::get('module.current_module_id')}};
        get_items();




            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

    $('#discount_type').on('change', function() {
     if($('#discount_type').val() == 'current_active_discount')
        {
            $('#discount_amount').attr("readonly","true");
        }
        else
        {
            $('#discount_amount').removeAttr("readonly");
        }
    });

    </script>
@endpush
