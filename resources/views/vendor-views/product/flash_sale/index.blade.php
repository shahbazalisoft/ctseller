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
                    {{translate('messages.flash_sale_setup')}}
                </span>
            </h1>
        </div>
        @php($language=\App\Models\BusinessSetting::where('key','language')->first())
        @php($language = $language->value ?? null)
        @php($default_lang = str_replace('_', '-', app()->getLocale()))
        <!-- End Page Header -->
        <div class="row g-3">

            <div class="col-12">
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper">
                            <h5 class="card-title">
                                {{translate('messages.flash_sale_list')}}<span class="badge badge-soft-dark ml-2" id="itemCount">{{$flash_sales->total()}}</span>
                            </h5>
                            <form  class="search-form">
                                <!-- Search -->

                                <div class="input-group input--group">
                                    <input id="datatableSearch_" value="{{ request()?->search ?? null }}" type="search" name="search" class="form-control"
                                            placeholder="{{translate('ex_:_flash_sale_title')}}" aria-label="Search" >
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
                                <th class="border-0">{{translate('messages.title')}}</th>
                                <th class="border-0">{{ translate('messages.discount') }}</th>
                                <th class="border-0">{{translate('messages.duration')}}</th>
                                <th class="border-0">{{translate('messages.active_products')}}</th>
                                <th class="border-0">{{translate('messages.publish')}}</th>
                                <th class="border-0">{{translate('messages.action')}}</th>
                            </tr>

                            </thead>

                            <tbody id="set-rows">
                            @foreach($flash_sales as $key=>$flash_sale)
                                <tr>
                                    <td class="text-center">
                                        <span class="mr-3">
                                            {{$key+$flash_sales->firstItem()}}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="font-size-sm text-body mr-3">
                                            {{Str::limit($flash_sale['title'],20,'...')}}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="bg-gradient-light text-dark">{{$flash_sale->admin_discount_percentage}}% Admin - {{$flash_sale->vendor_discount_percentage}}% Store</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="bg-gradient-light text-dark">{{$flash_sale->start_date?$flash_sale->start_date->format('d/M/Y'). ' - ' .$flash_sale->end_date->format('d/M/Y'): 'N/A'}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="font-size-sm text-body mr-3">
                                            {{ $flash_sale->activeProducts->count()}}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <label class="toggle-switch toggle-switch-sm" for="is_publish-{{$flash_sale['id']}}">
                                            <input type="checkbox" onclick="return false" disabled class="toggle-switch-input" id="is_publish-{{$flash_sale['id']}}" {{$flash_sale->is_publish?'checked':''}}>
                                            <span class="toggle-switch-label mx-auto">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        <form action="{{route('admin.flash-sale.publish',[$flash_sale['id'],$flash_sale->is_publish?0:1])}}" method="get" id="is_publish-{{$flash_sale['id']}}_form">
                                        </form>
                                        {{-- <label class="toggle-switch toggle-switch-sm" for="publishCheckbox{{$flash_sale->id}}">
                                            <input type="checkbox" onclick="location.href='{{route('admin.flash-sale.publish',[$flash_sale['id'],$flash_sale->is_publish?0:1])}}'"class="toggle-switch-input" id="publishCheckbox{{$flash_sale->id}}" {{$flash_sale->is_publish?'checked':''}}>
                                            <span class="toggle-switch-label mx-auto">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label> --}}
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--primary btn-outline-primary" href="{{ route('vendor.flash-sale.flash_sale_item',['id='.$flash_sale['id']]) }}" title="{{translate('messages.edit')}}"><i class="tio-visible-outlined"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if(count($flash_sales) !== 0)
                        <hr>
                        @endif
                        <div class="page-area">
                            {!! $flash_sales->links() !!}
                        </div>
                        @if(count($flash_sales) === 0)
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
        </div>
    </div>

@endsection

@push('script_2')

<script>
        $("#from").on("change", function () {
            $('#to').attr('min',$(this).val());
        });

        $("#to").on("change", function () {
            $('#from').attr('max',$(this).val());
        });
        $(document).on('ready', function () {
            $('#from').attr('min',(new Date()).toISOString().split('T')[0]);
            $('#to').attr('min',(new Date()).toISOString().split('T')[0]);
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

            $(".lang_link").click(function(e){
                e.preventDefault();
                $(".lang_link").removeClass('active');
                $(".lang_form").addClass('d-none');
                $(this).addClass('active');

                let form_id = this.id;
                let lang = form_id.substring(0, form_id.length - 5);
                console.log(lang);
                $("#"+lang+"-form").removeClass('d-none');
                if(lang == '{{$default_lang}}')
                {
                    $("#from_part_2").removeClass('d-none');
                }
                else
                {
                    $("#from_part_2").addClass('d-none');
                }
            })
        </script>
@endpush
