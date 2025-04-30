@extends('layouts.admin.app')

@section('title', 'Add Category')

@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{ asset('public/assets/admin/img/add.png') }}" class="w--20" alt="">
                </span>
                <span>
                    Add Sub Category
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.category.store-sub-category') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">Name <span class="input-label-secondary">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="New Category"
                                    value="{{ old('name') }}" maxlength="191">
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlSelect1">Main category
                                    <span class="input-label-secondary">*</span></label>
                                <select id="exampleFormControlSelect1" name="parent_id"
                                    class="form-control js-select2-custom" required>
                                    <option value="" selected disabled>Select Main Category</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat['id'] }}">{{ $cat['name'] }}
                                            ({{ Str::limit($cat->module->module_name, 15, '...') }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end mt-3">
                        <a href="{{ route('admin.category.sub-category') }}" class="btn btn--reset">Back</a>
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

    <script></script>
@endpush
