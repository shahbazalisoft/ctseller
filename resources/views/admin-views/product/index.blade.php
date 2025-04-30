@extends('layouts.admin.app')

@section('title', 'Add New Item')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('public/assets/admin/css/tags-input.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header d-flex flex-wrap __gap-15px justify-content-between align-items-center">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{ asset('public/assets/admin/img/items.png') }}" class="w--22" alt="">
                </span>
                <span>
                    Add New Item
                </span>
            </h1>
            <div class="d-flex align-items-end">
                <div class="text--primary-2 d-flex flex-wrap align-items-center mr-2">
                    <a href="{{ route('admin.item.list') }}" class="btn btn--danger font-regular">Back</a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <form action="javascript:" method="post" id="item_form" enctype="multipart/form-data">
            @csrf
            <div class="row g-2">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                                <div class="lang_form" id="default-form">
                                    <div class="form-group">
                                        <label class="input-label" for="default_name">Name </label>
                                        <input type="text" name="name" id="default_name" class="form-control" placeholder="New Item" required
                                            oninvalid="document.getElementById('en-link').click()">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlInput1">Short Description</label>
                                        <textarea type="text" name="description" class="form-control min-h-90px ckeditor"></textarea>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-wrap align-items-center">
                            <div class="w-100 d-flex flex-wrap __gap-15px">
                                <div class="flex-grow-1 mx-auto">
                                    <label class="text-dark d-block">
                                        Item Image
                                        <small class="text-danger">* ( ratio 1:1 )</small>
                                    </label>
                                    <div class="d-flex flex-wrap __gap-12px __new-coba" id="coba"></div>
                                </div>
                                <div class="flex-grow-1 mx-auto">
                                    <label class="text-dark d-block">
                                        Item Thumbnail
                                        <small class="text-danger">* ( ratio 1:1 )</small>
                                    </label>
                                    <label class="d-inline-block m-0">
                                        <img class="img--100" id="viewer"
                                            src="{{ asset('public/assets/admin/img/upload.png') }}" alt="thumbnail" />
                                        <input type="file" name="image" id="customFileEg1"
                                            class="custom-file-input d-none"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2">
                                    <i class="tio-dashboard-outlined"></i>
                                </span>
                                <span> Item Details </span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="store_id">Store<span
                                                class="input-label-secondary"></span></label>
                                        <select name="store_id" id="store_id"
                                            data-placeholder="Select Store"
                                            id="store_id" class="js-data-example-ajax form-control"
                                            onchange="getRestaurantData('{{ url('/') }}/admin/store/get-addons?data[]=0&store_id=',this.value,'add_on')"
                                            oninvalid="this.setCustomValidity('Please Select Store')">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="category_id">Category<span
                                                class="input-label-secondary">*</span></label>
                                        <select name="category_id" id="category_id" data-placeholder="Select Category"
                                            class="js-data-example-ajax form-control" id="category_id"
                                            onchange="categoryChange(this.value)">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="sub-categories">Sub Category<span
                                                class="input-label-secondary"
                                                title="Category Required Warning"><img
                                                    src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                                    alt="Category Required Warning"></span></label>
                                        <select name="sub_category_id" class="js-data-example-ajax form-control" data-placeholder="Select Sub Category"
                                            id="sub-categories">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3" id="condition_input">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="condition_id">Suitable For<span
                                                class="input-label-secondary"></span></label>
                                        <select name="condition_id" id="condition_id"
                                            data-placeholder="Select Condition"
                                            id="condition_id" class="js-data-example-ajax form-control"
                                            oninvalid="this.setCustomValidity('Select Condition')">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3" id="unit_input">
                                    <div class="form-group mb-0">
                                        <label class="input-label text-capitalize"
                                            for="unit">Unit</label>
                                        <select name="unit" id="unit" class="form-control js-select2-custom">
                                            @foreach (\App\Models\Unit::all() as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3" id="veg_input">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">Item Type</label>
                                        <select name="veg" id="veg" class="form-control js-select2-custom"
                                            required>
                                            <option value="0">non_veg</option>
                                            <option value="1">veg</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3" id="stock_input">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="total_stock">Total Stock</label>
                                        <input type="number" placeholder="Ex: 10" class="form-control" name="current_stock" min="0" id="quantity">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3" id="maximum_cart_quantity">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="maximum_cart_quantity">Maximum Purchase Quantity Limit
                                            <span
                                            class="input-label-secondary text--title" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="If_this limit_is exceeded, customers_can_not_buy_the_item_in_a_single_purchase.">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                        </label>
                                        <input type="number"  placeholder="Ex: 10" class="form-control" name="maximum_cart_quantity" min="0" id="cart_quantity">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3" id="organic">
                                    <div class="form-check mb-0 p-6">
                                        <input class="form-check-input" name="organic" type="checkbox" value="1" id="flexCheckDefault" checked>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Is Organic
                                        </label>
                                      </div>
                                </div>
                                <div class="col-sm-6 col-lg-3" id="basic">
                                    <div class="form-check mb-0 p-6">
                                        <input class="form-check-input" name="basic" type="checkbox" value="1" id="flexCheckDefault" checked>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Is Basic Medicine
                                        </label>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" id="addon_input">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon"><i class="tio-dashboard-outlined"></i></span>
                                <span>Addon</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <label class="input-label"
                                    for="exampleFormControlSelect1">Addon<span
                                        class="input-label-secondary"
                                        title="addon"><img
                                            src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                            alt="Store Required Warning"></span></label>
                                <select name="addon_ids[]" class="form-control js-select2-custom"
                                    multiple="multiple" id="add_on">

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" id="time_input">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon"><i class="tio-date-range"></i></span>
                                <span>Time Schedule</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">Available Time Starts</label>
                                        <input type="time" name="available_time_starts" class="form-control"
                                            id="available_time_starts"
                                            placeholder="Ex: 10:30 am">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">Available Time Ends</label>
                                        <input type="time" name="available_time_ends" class="form-control"
                                            id="available_time_ends" placeholder="5:45 pm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon"><i class="tio-dollar-outlined"></i></span>
                                <span>Amount</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-sm-4 col-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">Price</label>
                                        <input type="number" min="0" max="999999999999.99" step="0.01"
                                            value="1" name="price" class="form-control"
                                            placeholder="Ex: 100" required>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">Discount Type<span
                                                class="input-label-secondary text--title" data-toggle="tooltip"
                                                data-placement="right"
                                                data-original-title="Admin_shares_the_same_percentage/amount_on_discount_as_he_takes_commissions_from_stores">
                                                <i class="tio-info-outined"></i>
                                            </span>
                                        </label>
                                        <select name="discount_type" id="discount_type"
                                            class="form-control js-select2-custom">
                                            <option value="percent">Percent</option>
                                            <option value="amount">Amount</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">Discount</label>
                                        <input type="number" min="0" max="9999999999999999999999" value="0"
                                            name="discount" class="form-control"
                                            placeholder="Ex: 100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" id="food_variation_section">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header flex-wrap">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2">
                                    <i class="tio-canvas-text"></i>
                                </span>
                                <span>Food Variations</span>
                            </h5>
                            <a class="btn text--primary-2" id="add_new_option_button">
                                Add New Variation
                                <i class="tio-add"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <!-- Empty Variation -->
                            <div id="empty-variation">
                                <div class="text-center">
                                    <img src="{{asset('/public/assets/admin/img/variation.png')}}" alt="">
                                    <div>No variation added</div>
                                </div>
                            </div>
                            <div id="add_new_option">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" id="attribute_section">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon"><i class="tio-canvas-text"></i></span>
                                <span>Attribute</span>
                            </h5>
                        </div>
                        <div class="card-body pb-0">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlSelect1">Attribute<span
                                                class="input-label-secondary"></span></label>
                                        <select name="attribute_id[]" id="choice_attributes"
                                            class="form-control js-select2-custom" multiple="multiple">
                                            @foreach (\App\Models\Attribute::orderBy('name')->get() as $attribute)
                                                <option value="{{ $attribute['id'] }}">{{ $attribute['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <div class="customer_choice_options d-flex __gap-24px"
                                        id="customer_choice_options">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="variant_combination" id="variant_combination">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon"><i class="tio-label"></i></span>
                                <span>Tags</span>
                            </h5>
                        </div>
                        <div class="card-body pb-0">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="tags" placeholder="Search Tags" data-role="tagsinput">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="btn--container justify-content-end">
                        <button type="reset" id="reset_btn"
                            class="btn btn--reset">Reset</button>
                        <button type="submit" class="btn btn--primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal" id="food-modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" onclick="foodModalClose()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/IkoF9gPH6zs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                      </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="attribute-modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" onclick="attributeModalClose()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/xG8fO7TXPbk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                      </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('script_2')
    <script>
        var count = 0;
        $(document).ready(function() {
            $("#add_new_option_button").click(function(e) {
                $('#empty-variation').hide();
                count++;
                var add_option_view = `
                    <div class="__bg-F8F9FC-card view_new_option mb-2">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <label class="form-check form--check">
                                    <input id="options[` + count + `][required]" name="options[` + count + `][required]" class="form-check-input" type="checkbox">
                                    <span class="form-check-label">Required</span>
                                </label>
                                <div>
                                    <button type="button" class="btn btn-danger btn-sm delete_input_button" onclick="removeOption(this)"
                                        title="Delete">
                                        <i class="tio-add-to-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-xl-4 col-lg-6">
                                    <label for="">Name</label>
                                    <input required name=options[` + count +
                    `][name] class="form-control" type="text" onkeyup="new_option_name(this.value,` +
                    count + `)">
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label class="input-label text-capitalize d-flex align-items-center"><span class="line--limit-1">Selcetion_type </span>
                                        </label>
                                        <div class="resturant-type-group px-0">
                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input" type="radio" value="multi"
                                                name="options[` + count + `][type]" id="type` + count +
                    `" checked onchange="show_min_max(` + count + `)"
                                                >
                                                <span class="form-check-label">
                                                    Multiple Selection
                                                </span>
                                            </label>

                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input" type="radio" value="single"
                                                name="options[` + count + `][type]" id="type` + count +
                    `" onchange="hide_min_max(` + count + `)"
                                                >
                                                <span class="form-check-label">
                                                    Single Selection
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label for="">Min</label>
                                            <input id="min_max1_` + count + `" required  name="options[` + count + `][min]" class="form-control" type="number" min="1">
                                        </div>
                                        <div class="col-6">
                                            <label for="">Max</label>
                                            <input id="min_max2_` + count + `"   required name="options[` + count + `][max]" class="form-control" type="number" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="option_price_` + count + `" >
                                <div class="bg-white border rounded p-3 pb-0 mt-3">
                                    <div  id="option_price_view_` + count + `">
                                        <div class="row g-3 add_new_view_row_class mb-3">
                                            <div class="col-md-4 col-sm-6">
                                                <label for="">Option Name</label>
                                                <input class="form-control" required type="text" name="options[` +
                    count +
                    `][values][0][label]" id="">
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label for="">Additional Price</label>
                                                <input class="form-control" required type="number" min="0" step="0.01" name="options[` +
                    count + `][values][0][optionPrice]" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 p-3 mr-1 d-flex "  id="add_new_button_` + count +
                    `">
                                        <button type="button" class="btn btn--primary btn-outline-primary" onclick="add_new_row_button(` +
                    count + `)" >Add New Option</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

                $("#add_new_option").append(add_option_view);
            });
        });

        function show_min_max(data) {
            $('#min_max1_' + data).removeAttr("readonly");
            $('#min_max2_' + data).removeAttr("readonly");
            $('#min_max1_' + data).attr("required", "true");
            $('#min_max2_' + data).attr("required", "true");
        }

        function hide_min_max(data) {
            $('#min_max1_' + data).val(null).trigger('change');
            $('#min_max2_' + data).val(null).trigger('change');
            $('#min_max1_' + data).attr("readonly", "true");
            $('#min_max2_' + data).attr("readonly", "true");
            $('#min_max1_' + data).attr("required", "false");
            $('#min_max2_' + data).attr("required", "false");
        }




        function new_option_name(value, data) {
            $("#new_option_name_" + data).empty();
            $("#new_option_name_" + data).text(value)
            console.log(value);
        }

        function removeOption(e) {
            element = $(e);
            element.parents('.view_new_option').remove();
        }

        function deleteRow(e) {
            element = $(e);
            element.parents('.add_new_view_row_class').remove();
        }


        function add_new_row_button(data) {
            count = data;
            countRow = 1 + $('#option_price_view_' + data).children('.add_new_view_row_class').length;
            var add_new_row_view = `
            <div class="row add_new_view_row_class mb-3 position-relative pt-3 pt-sm-0">
                <div class="col-md-4 col-sm-5">
                        <label for="">Option Name</label>
                        <input class="form-control" required type="text" name="options[` + count + `][values][` +
                countRow + `][label]" id="">
                    </div>
                    <div class="col-md-4 col-sm-5">
                        <label for="">Additional Price</label>
                        <input class="form-control"  required type="number" min="0" step="0.01" name="options[` +
                count +
                `][values][` + countRow + `][optionPrice]" id="">
                    </div>
                    <div class="col-sm-2 max-sm-absolute">
                        <label class="d-none d-sm-block">&nbsp;</label>
                        <div class="mt-1">
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)"
                                title="Delete">
                                <i class="tio-add-to-trash"></i>
                            </button>
                        </div>
                </div>
            </div>`;
            $('#option_price_view_' + data).append(add_new_row_view);

        }
    </script>
    <script src="{{ asset('public/assets/admin') }}/js/tags-input.min.js"></script>
    <script>
    function foodModalClose() {
        $('#food-modal').hide();

    }
    function foodModalShow() {
        $('#food-modal').show();
    }
    function attributeModalClose() {
        $('#attribute-modal').hide();

    }
    function attributeModalShow() {
        $('#attribute-modal').show();
    }
        function getRestaurantData(route, store_id, id) {
            $.get({
                url: route + store_id,
                dataType: 'json',
                success: function(data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }

        function getRequest(route, id) {
            $.get({
                url: route,
                dataType: 'json',
                success: function(data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function() {
            readURL(this);
        });
    </script>

    <script>
        var module_id = 1;
        var parent_category_id = 0;
        var module_data = null;
        var stock = true;

        function modulChange(id) {
            $.get({
                url: "{{ url('/') }}/admin/module/" + id,
                dataType: 'json',
                success: function(data) {
                    module_data = data.data;
                    stock = module_data.stock;
                    module_type = data.type;
                    if (stock) {
                        $('#stock_input').show();
                    } else {
                        $('#stock_input').hide();
                    }
                    if (module_data.add_on) {
                        $('#addon_input').show();
                    } else {
                        $('#addon_input').hide();
                    }

                    if (module_data.item_available_time) {
                        $('#time_input').show();
                    } else {
                        $('#time_input').hide();
                    }

                    if (module_data.veg_non_veg) {
                        $('#veg_input').show();
                    } else {
                        $('#veg_input').hide();
                    }
                    if (module_data.unit) {
                        $('#unit_input').show();
                    } else {
                        $('#unit_input').hide();
                    }
                    if (module_data.common_condition) {
                        $('#condition_input').show();
                    } else {
                        $('#condition_input').hide();
                    }
                    combination_update();
                    if (module_type == 'food') {
                        $('#food_variation_section').show();
                        $('#attribute_section').hide();
                    } else {
                        $('#food_variation_section').hide();
                        $('#attribute_section').show();
                    }
                    if (module_data.organic) {
                        $('#organic').show();
                    } else {
                        $('#organic').hide();
                    }
                    if (module_data.basic) {
                        $('#basic').show();
                    } else {
                        $('#basic').hide();
                    }
                },
            });
            module_id = id;
        }
        modulChange(1);
        function categoryChange(id) {
            parent_category_id = id;
            console.log(parent_category_id);
        }

        $(document).on('ready', function() {
            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function() {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
        $('#condition_id').select2({
            ajax: {
                url: '{{ url('/') }}/admin/common-condition/get-all',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
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
        $('#store_id').select2({
            ajax: {
                url: '{{ url('/') }}/admin/store/get-stores',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id:1,
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

        $('#category_id').select2({
            ajax: {
                url: '{{ url('/') }}/admin/item/get-categories?parent_id=0',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id:1,
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

        $('#sub-categories').select2({
            ajax: {
                url: '{{ url('/') }}/admin/item/get-categories',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id:1,
                        parent_id: parent_category_id,
                        sub_category: true
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

        $('#choice_attributes').on('change', function() {
            if (module_id == 0) {
                toastr.error('Select a module', {
                    CloseButton: true,
                    ProgressBar: true
                });
                $(this).val("");
                return false;
            }
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function() {
                if ($(this).val().length > 50) {
                    toastr.error(
                        'kkkkkk');
                    return false;
                }
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name;

            $('#customer_choice_options').append(
                `<div class="__choos-item"><div><input type="hidden" name="choice_no[]" value="${i}"><input type="text" class="form-control d-none" name="choice[]" value="${n}" placeholder="Choose Title" readonly> <label class="form-label">${n}</label> </div><div><input type="text" class="form-control" name="choice_options_${i}[]" placeholder="Enter choice values" data-role="tagsinput" onchange="combination_update()"></div></div>`
            );
            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }

        function combination_update() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                type: "POST",
                url: "{{ route('admin.item.variant-combination') }}",
                data: $('#item_form').serialize() + '&stock=' + stock,
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    $('#variant_combination').html(data.view);
                    if (data.length < 1) {
                        $('input[name="current_stock"]').attr("readonly", false);
                    }
                }
            });
        }
    </script>

    <script>
        $('#item_form').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('admin.item.store') }}',
                data: $('#item_form').serialize(),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
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
                        toastr.success("Product added successfully", {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function() {
                            location.href =
                                "{{ \Request::server('HTTP_REFERER') ?? route('admin.item.list') }}";
                        }, 2000);
                    }
                }
            });
        });
    </script>
    
    <script src="{{ asset('public/assets/admin/js/spartan-multi-image-picker.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'item_images[]',
                maxCount: 5,
                rowHeight: '100px !important',
                groupClassName: 'spartan_item_wrapper min-w-100px max-w-100px',
                maxFileSize: '',
                placeholderImage: {
                    image: "{{ asset('public/assets/admin/img/upload.png') }}",
                    width: '100px'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error(
                        "please_only_input_png_or_jpg_type_file", {
                            CloseButton: true,
                            ProgressBar: true
                        });
                },
                onSizeErr: function(index, file) {
                    toastr.error("file_size_too_big", {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
    <script>
        // $('#reset_btn').click(function() {
        //     $('#module_id').val(null).trigger('change');
        //     $('#store_id').val(null).trigger('change');
        //     $('#category_id').val(null).trigger('change');
        //     $('#sub-categories').val(null).trigger('change');
        //     $('#unit').val(null).trigger('change');
        //     $('#veg').val(0).trigger('change');
        //     $('#add_on').val(null).trigger('change');
        //     $('#discount_type').val(null).trigger('change');
        //     $('#choice_attributes').val(null).trigger('change');
        //     $('#customer_choice_options').empty().trigger('change');
        //     $('#variant_combination').empty().trigger('change');
        //     $('#viewer').attr('src', "{{ asset('public/assets/admin/img/upload.png') }}");
        //     $('#customFileEg1').val(null).trigger('change');
        //     $("#coba").empty().spartanMultiImagePicker({
        //         fieldName: 'item_images[]',
        //         maxCount: 6,
        //         rowHeight: '100px !important',
        //         groupClassName: 'spartan_item_wrapper min-w-100px max-w-100px',
        //         maxFileSize: '',
        //         placeholderImage: {
        //             image: "{{ asset('public/assets/admin/img/upload.png') }}",
        //             width: '100%'
        //         },
        //         dropFileLabel: "Drop Here",
        //         onAddRow: function(index, file) {

        //         },
        //         onRenderedPreview: function(index) {

        //         },
        //         onRemoveRow: function(index) {

        //         },
        //         onExtensionErr: function(index, file) {
        //             toastr.error(
        //                 "Please only input png or jpg type file", {
        //                     CloseButton: true,
        //                     ProgressBar: true
        //                 });
        //         },
        //         onSizeErr: function(index, file) {
        //             toastr.error("File size too big", {
        //                 CloseButton: true,
        //                 ProgressBar: true
        //             });
        //         }
        //     });
        // })
    </script>
@endpush
