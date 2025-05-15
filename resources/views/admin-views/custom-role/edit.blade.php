@extends('layouts.admin.app')
@section('title','Edit Role')
@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Heading -->
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="{{asset('public/assets/admin/img/edit.png')}}" class="w--26" alt="">
            </span>
            <span>
                Employee Role
            </span>
        </h1>
    </div>
    <!-- Page Heading -->
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.custom-role.update',[$role['id']])}}" method="post">
                        @csrf
                        <div id="default-form">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">Role name</label>
                                <input type="text" name="name" class="form-control" placeholder="Role name example" value="{{$role['name']}}" maxlength="100">
                            </div>
                        </div>

                        <div class="d-flex flex-wrap select--all-checkes">
                            <h5 class="input-label m-0 text-capitalize">Module permission : </h5>
                            <div class="check-item pb-0 w-auto">
                                <div class="form-group form-check form--check m-0 ml-2">
                                    <input type="checkbox" name="modules[]" value="account" class="form-check-input" id="select-all">
                                    <label class="form-check-label ml-2" for="select-all">Select All</label>
                                </div>
                            </div>
                        </div>

                        <div class="check--item-wrapper">
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="attribute" class="form-check-input"
                                           id="attribute" {{in_array('attribute',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont text-dark" for="attribute">Attribute</label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="banner" class="form-check-input"
                                           id="banner" {{in_array('banner',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont text-dark" for="banner">Banner</label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="category" class="form-check-input"
                                           id="category" {{in_array('category',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont text-dark" for="category">Category</label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="Retailer Manage" class="form-check-input"
                                           id="retailer_manage" {{in_array('Retailer Manage',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont text-dark" for="retailer_manage">Retailer Manage</label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="Wholesaler Manage" class="form-check-input"
                                           id="wholesaler_manage" {{in_array('Wholesaler Manage',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont text-dark" for="wholesaler_manage">Wholesaler Manage</label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="deliveryman" class="form-check-input"
                                           id="deliveryman" {{in_array('deliveryman',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont text-dark" for="deliveryman">Deliveryman</label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="employee" class="form-check-input"
                                           id="employee" {{in_array('employee',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont text-dark" for="employee">Employee</label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="item" class="form-check-input"
                                           id="item" {{in_array('item',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont text-dark" for="item">Item</label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="order" class="form-check-input"
                                           id="order" {{in_array('order',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont text-dark" for="order">Order</label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="store" class="form-check-input"
                                           id="store" {{in_array('store',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont text-dark" for="store">Store</label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="report" class="form-check-input"
                                            id="report" {{in_array('report',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont text-dark" for="report">Report</label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="settings" class="form-check-input"
                                           id="settings" {{in_array('settings',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont text-dark" for="settings">Settings</label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="module" class="form-check-input"
                                           id="module_system" {{in_array('module',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont text-dark" for="module_system">Module</label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="unit" class="form-check-input"
                                           id="unit" {{in_array('unit',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont text-dark" for="unit">Unit</label>
                                </div>
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mt-4">
                            <button type="reset" class="btn btn--reset">Reset</button>
                            <button type="submit" class="btn btn--primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script_2')
<script>
    $('#select-all').on('change', function(){
        if(this.checked === true) {
            $('.check--item-wrapper .check-item .form-check-input').attr('checked', true)
        } else {
            $('.check--item-wrapper .check-item .form-check-input').attr('checked', false)
        }
    })
    $('.check--item-wrapper .check-item .form-check-input').on('change', function(){
        if(this.checked === true) {
            $(this).attr('checked', true)
        } else {
            $(this).attr('checked', false)
        }
    })
</script>
<script>
    $(".lang_link").click(function(e){
        e.preventDefault();
        $(".lang_link").removeClass('active');
        $(".lang_form").addClass('d-none');
        $(this).addClass('active');

        let form_id = this.id;
        let lang = form_id.substring(0, form_id.length - 5);
        console.log(lang);
        $("#"+lang+"-form").removeClass('d-none');
        if(lang == 'en')
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
