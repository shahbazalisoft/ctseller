@extends('layouts.admin.app')

@section('title','Add Category')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/add.png')}}" class="w--20" alt="">
                </span>
                <span>
                    Add Category
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.category.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="New Category" value="{{old('name')}}" maxlength="191">
                            </div>
                            {{-- <div class="form-group mb-0 pt-md-4">
                                <label class="input-label">{{translate('messages.module')}}</label>
                                <select name="module_id" id="module_id" required class="form-control js-select2-custom"  data-placeholder="{{translate('messages.select_module')}}">
                                        <option value="" selected disabled>{{translate('messages.select_module')}}</option>
                                    @foreach(\App\Models\Module::notParcel()->get() as $module)
                                        <option value="{{$module->id}}" >{{$module->module_name}}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger">{{translate('messages.module_change_warning')}}</small>
                            </div> --}}
                        </div>
                        <div class="col-md-12">
                            <div class="h-100 d-flex flex-column">
                                <label class="m-0">Image <small class="text-danger">* ( ratio 1:1)</small></label>
                                <center class="py-3 my-auto">
                                    <img class="img--100" id="viewer"
                                        {{-- @if(isset($category))
                                        src="{{asset('storage/app/public/category')}}/{{$category['image']}}"
                                        @else --}}
                                        src="{{asset('public/assets/admin/img/900x400/img1.jpg')}}"
                                        {{-- @endif --}}
                                        alt="image"/>
                                </center>
                                <div class="custom-file">
                                    <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" >
                                    <label class="custom-file-label" for="customFileEg1">Choose File</label>
                                </div>
                                <small class="text-danger mt-1 d-none d-md-block">&nbsp;</small>
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end mt-3">
                        <a href="{{ route('admin.category.index') }}" class="btn btn--reset">Back</a>
                        <button type="submit" class="btn btn--primary">Add</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>
   
    <script>
      
    </script>
@endpush
