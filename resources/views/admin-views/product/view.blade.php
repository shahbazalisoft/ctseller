@extends('layouts.admin.app')

@section('title', 'Item Preview')

@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between">
                <h1 class="page-header-title text-break">
                    <span class="page-header-icon">
                        <img src="{{ asset('public/assets/admin/img/items.png') }}" class="w--22" alt="">
                    </span>
                    <span>{{ $product['name'] }}</span>
                </h1>
                <a href="{{ route('admin.item.edit', [$product['id']]) }}" class="btn btn--primary">
                    <i class="tio-edit"></i> Edit Info
                </a>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="row review--information-wrapper g-2 mb-3">
            <div class="col-lg-9">
                <div class="card h-100">
                    <!-- Body -->
                    <div class="card-body">
                        <div class="row align-items-md-center">
                            <div class="col-lg-5 col-md-6 mb-3 mb-md-0">
                                <div class="d-flex flex-wrap align-items-center food--media">
                                    <img class="avatar avatar-xxl avatar-4by3 mr-4"
                                        src="{{ asset('storage/app/public/product') }}/{{ $product['image'] }}"
                                        onerror="this.src='{{ asset('public/assets/admin/img/160x160/img2.jpg') }}'"
                                        alt="Image Description">
                                    <div class="d-block">
                                        <div class="rating--review">
                                            <h1 class="title">{{ number_format($product->avg_rating, 1) }}<span
                                                    class="out-of">/5</span></h1>
                                            @if ($product->avg_rating == 5)
                                                <div class="rating">
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star"></i></span>
                                                </div>
                                            @elseif ($product->avg_rating < 5 && $product->avg_rating >= 4.5)
                                                <div class="rating">
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star-half"></i></span>
                                                </div>
                                            @elseif ($product->avg_rating < 4.5 && $product->avg_rating >= 4)
                                                <div class="rating">
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                </div>
                                            @elseif ($product->avg_rating < 4 && $product->avg_rating >= 3.5)
                                                <div class="rating">
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star-half"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                </div>
                                            @elseif ($product->avg_rating < 3.5 && $product->avg_rating >= 3)
                                                <div class="rating">
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                </div>
                                            @elseif ($product->avg_rating < 3 && $product->avg_rating >= 2.5)
                                                <div class="rating">
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star-half"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                </div>
                                            @elseif ($product->avg_rating < 2.5 && $product->avg_rating > 2)
                                                <div class="rating">
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                </div>
                                            @elseif ($product->avg_rating < 2 && $product->avg_rating >= 1.5)
                                                <div class="rating">
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star-half"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                </div>
                                            @elseif ($product->avg_rating < 1.5 && $product->avg_rating > 1)
                                                <div class="rating">
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                </div>
                                            @elseif ($product->avg_rating < 1 && $product->avg_rating > 0)
                                                <div class="rating">
                                                    <span><i class="tio-star-half"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                </div>
                                            @elseif ($product->avg_rating == 1)
                                                <div class="rating">
                                                    <span><i class="tio-star"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                </div>
                                            @elseif ($product->avg_rating == 0)
                                                <div class="rating">
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                    <span><i class="tio-star-outlined"></i></span>
                                                </div>
                                            @endif
                                            <div class="info">
                                                {{-- <span class="mr-3">of {{ $product->rating ? count(json_decode($product->rating, true)): 0 }} Rating</span> --}}
                                                <span>of 2
                                                    Reviews</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-6 mx-auto">
                                <ul class="list-unstyled list-unstyled-py-2 mb-0 rating--review-right py-3">
                                    @php($total = $product->rating ? array_sum(json_decode($product->rating, true)) : 0)
                                    <!-- Review Ratings -->
                                    <li class="d-flex align-items-center font-size-sm">
                                        @php($five = $product->rating ? json_decode($product->rating, true)[5] : 0)
                                        <span class="progress-name mr-3">Excellent</span>
                                        <div class="progress flex-grow-1">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $total == 0 ? 0 : ($five / $total) * 100 }}%;"
                                                aria-valuenow="{{ $total == 0 ? 0 : ($five / $total) * 100 }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="ml-3">{{ $five }}</span>
                                    </li>
                                    <!-- End Review Ratings -->

                                    <!-- Review Ratings -->
                                    <li class="d-flex align-items-center font-size-sm">
                                        @php($four = $product->rating ? json_decode($product->rating, true)[4] : 0)
                                        <span class="progress-name mr-3">Good</span>
                                        <div class="progress flex-grow-1">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $total == 0 ? 0 : ($four / $total) * 100 }}%;"
                                                aria-valuenow="{{ $total == 0 ? 0 : ($four / $total) * 100 }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="ml-3">{{ $four }}</span>
                                    </li>
                                    <!-- End Review Ratings -->

                                    <!-- Review Ratings -->
                                    <li class="d-flex align-items-center font-size-sm">
                                        @php($three = $product->rating ? json_decode($product->rating, true)[3] : 0)
                                        <span class="progress-name mr-3">Average</span>
                                        <div class="progress flex-grow-1">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $total == 0 ? 0 : ($three / $total) * 100 }}%;"
                                                aria-valuenow="{{ $total == 0 ? 0 : ($three / $total) * 100 }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="ml-3">{{ $three }}</span>
                                    </li>
                                    <!-- End Review Ratings -->

                                    <!-- Review Ratings -->
                                    <li class="d-flex align-items-center font-size-sm">
                                        @php($two = $product->rating ? json_decode($product->rating, true)[2] : 0)
                                        <span class="progress-name mr-3">Below average</span>
                                        <div class="progress flex-grow-1">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $total == 0 ? 0 : ($two / $total) * 100 }}%;"
                                                aria-valuenow="{{ $total == 0 ? 0 : ($two / $total) * 100 }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="ml-3">{{ $two }}</span>
                                    </li>
                                    <!-- End Review Ratings -->

                                    <!-- Review Ratings -->
                                    <li class="d-flex align-items-center font-size-sm">
                                        @php($one = $product->rating ? json_decode($product->rating, true)[1] : 0)
                                        <span class="progress-name mr-3">Poor</span>
                                        <div class="progress flex-grow-1">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $total == 0 ? 0 : ($one / $total) * 100 }}%;"
                                                aria-valuenow="{{ $total == 0 ? 0 : ($one / $total) * 100 }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="ml-3">{{ $one }}</span>
                                    </li>
                                    <!-- End Review Ratings -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- End Body -->
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        @if ($product->store)
                            <a class="resturant--information-single"
                                href="{{ route('admin.store.view', $product->store_id) }}">
                                <img class="img--120 rounded mx-auto mb-3"
                                    onerror="this.src='{{ asset('public/assets/admin/img/160x160/img1.jpg') }}'"
                                    src="{{ asset('storage/app/public/store/' . $product->store->logo) }}"
                                    alt="Image Description">
                                <div class="text-center">
                                    <h5 class="text-capitalize text--title font-semibold text-hover-primary d-block mb-1">
                                        {{ $product->store['name'] }}
                                    </h5>
                                    <span class="text--title">
                                        <i class="tio-poi"></i> {{ $product->store['address'] }}
                                    </span>
                                </div>
                            </a>
                        @else
                            <span class="badge-info">Store Deleted</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Description Card Start -->
        <div class="card mb-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless table-thead-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th class="px-4 border-0">
                                    <h4 class="m-0 text-capitalize">Short Description</h4>
                                </th>
                                <th class="px-4 border-0">
                                    <h4 class="m-0 text-capitalize">Price</h4>
                                </th>
                                <th class="px-4 border-0">
                                    <h4 class="m-0 text-capitalize">Variations</h4>
                                </th>
                                @if ($product->module->module_type == 'food')
                                    <th class="px-4 border-0">
                                        <h4 class="m-0 text-capitalize">Addons</h4>
                                    </th>
                                @endif
                                <th class="px-4 border-0">
                                    <h4 class="m-0 text-capitalize">Tags</h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 max-w--220px">
                                    <div class="">
                                        {!! $product['description'] !!}
                                    </div>
                                </td>
                                <td class="px-4">
                                    <span class="d-block mb-1">
                                        <span>Price : </span>
                                        <strong>{{ \App\CentralLogics\Helpers::format_currency($product['price']) }}</strong>
                                    </span>
                                    <span class="d-block mb-1">
                                        <span>Discount :</span>
                                        <strong>{{ \App\CentralLogics\Helpers::format_currency(\App\CentralLogics\Helpers::discount_calculate($product, $product['price'])) }}</strong>
                                    </span>
                                    <span class="d-block mb-1">
                                        <span>Tax :</span>
                                        <strong>{{ $product['tax'] }} %</strong>
                                    </span>
                                    @if (config('module.' . $product->module->module_type)['item_available_time'])
                                        <span class="d-block mb-1">
                                            Available time starts :
                                            <strong>{{ date(config('timeformat'), strtotime($product['available_time_starts'])) }}</strong>
                                        </span>
                                        <span class="d-block mb-1">
                                            Available time ends :
                                            <strong>{{ date(config('timeformat'), strtotime($product['available_time_ends'])) }}</strong>
                                        </span>
                                        
                                    @endif
                                </td>
                                <td class="px-4">
                                        @if ($product->module->module_type == 'food')
                                        @if ($product->food_variations && is_array(json_decode($product['food_variations'], true)))
                                            @foreach (json_decode($product->food_variations, true) as $variation)
                                                @if (isset($variation['price']))
                                                    <span class="d-block mb-1 text-capitalize">
                                                        <strong>
                                                            Please update the food variations
                                                        </strong>
                                                    </span>
                                                @break

                                            @else
                                                <span class="d-block text-capitalize">
                                                    <strong>
                                                        {{ $variation['name'] }} -
                                                    </strong>
                                                    @if ($variation['type'] == 'multi')
                                                    Multiple select
                                                    @elseif($variation['type'] == 'single')
                                                    Single select
                                                    @endif
                                                    @if ($variation['required'] == 'on')
                                                        - Required
                                                    @endif
                                                </span>

                                                @if ($variation['min'] != 0 && $variation['max'] != 0)
                                                    (Min Select: {{ $variation['min'] }} -
                                                    Max Select: {{ $variation['max'] }})
                                                @endif

                                                @if (isset($variation['values']))
                                                    @foreach ($variation['values'] as $value)
                                                        <span class="d-block text-capitalize">
                                                            &nbsp; &nbsp; {{ $value['label'] }} :
                                                            <strong>{{ \App\CentralLogics\Helpers::format_currency($value['optionPrice']) }}</strong>
                                                        </span>
                                                    @endforeach
                                                @endif
                                            @endif
                                        @endforeach
                                        @endif
                                    @else
                                    @if ($product->variations && is_array(json_decode($product['variations'], true)))
                                        @foreach (json_decode($product['variations'], true) as $variation)
                                            <span class="d-block mb-1 text-capitalize">
                                                {{ $variation['type'] }} :
                                                {{ \App\CentralLogics\Helpers::format_currency($variation['price']) }}
                                            </span>
                                        @endforeach
                                    @endif
                                </td>
                            @endif
                            @if ($product->module->module_type == 'food')

                                <td class="px-4">
                                    @if (config('module.' . $product->module->module_type)['add_on'])
                                        @foreach (\App\Models\AddOn::whereIn('id', json_decode($product['add_ons'], true))->get() as $addon)
                                            <span class="d-block mb-1 text-capitalize">
                                                {{ $addon['name'] }} :
                                                {{ \App\CentralLogics\Helpers::format_currency($addon['price']) }}
                                            </span>
                                        @endforeach
                                    @endif
                                </td>
                            @endif
                            @if ($product->tags)
                                <td>
                                    @foreach($product->tags as $c)
                                        {{$c->tag.','}}
                                    @endforeach
                                </td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Description Card End -->
    <!-- Card -->
    <div class="card">
        <div class="card-header border-0">
            <h4 class="card-title">Product reviews</h4>



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
                    <a id="export-excel" class="dropdown-item" href="#">
                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                            src="{{ asset('public/assets/admin') }}/svg/components/excel.svg"
                            alt="Image Description">
                            Excel
                    </a>
                    <a id="export-csv" class="dropdown-item" href="#">
                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                            src="{{ asset('public/assets/admin') }}/svg/components/placeholder-csv-format.svg"
                            alt="Image Description">
                        .csv
                    </a>

                </div>
            </div>



        </div>
        <!-- Table -->
        <div class="table-responsive datatable-custom">
            <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap card-table"
                data-hs-datatables-options='{
                     "columnDefs": [{
                        "targets": [0, 3, 6],
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
                     "pagination": "datatablePagination"
                   }'>
                <thead class="thead-light">
                    <tr>
                        <th class="border-0">Reviewer</th>
                        <th class="border-0">Review</th>
                        <th class="border-0">Date</th>
                        <th class="border-0">Status</th>
                    </tr>
                </thead>

                <tbody>

                        <tr>
                            <td>
                                
                            </td>
                            <td>
                                <div class="text-wrap min--240">
                                    <div class="d-flex mb-2">
                                        <label class="badge badge-soft-info">
                                           3 <i class="tio-star"></i>
                                        </label>
                                    </div>

                                    <p>
                                       Hello
                                    </p>
                                </div>
                            </td>
                            <td>
                                24/02/2025
                            </td>
                            <td>
                                dasdad
                            </td>
                        </tr>
                </tbody>
            </table>
            
                <div class="empty--data">
                    <img src="{{ asset('/public/assets/admin/svg/illustrations/sorry.svg') }}" alt="public">
                    <h5>
                        No data found
                    </h5>
                </div>
        </div>

        <!-- Footer -->
    </div>
    <!-- End Card -->
</div>
@endsection

@push('script_2')
<script>
    function status_form_alert(id, message, e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure',
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
                $('#' + id).submit()
            }
        })
    }
</script>
@endpush
