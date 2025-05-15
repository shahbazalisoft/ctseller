@extends('layouts.admin.app')

@section('title','Sub category')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/category.png')}}" class="w--20" alt="">
                </span>
                <span>
                    Add New Sub Category
                </span>
            </h1>
        </div>
        <!-- End Page Header -->

        <div class="card mt-3">
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    <h5 class="card-title">Sub Category List<span class="badge badge-soft-dark ml-2" id="itemCount">{{$categories->total()}}</span></h5>
                    
                    <form class="search-form">
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input type="search" name="search" value="{{ request()?->search ?? null }}" class="form-control min-height-45" placeholder="Search" aria-label="ex:categories">
                            <button type="submit" class="btn btn--secondary min-height-45"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>
                    <!-- Unfold -->
                    <div>
                        <a href="{{ route('admin.category.add-sub-category') }}" class="btn btn--primary font-regular"><i class="tio-add-circle"></i> Add New</a>
                    </div>
                    <!-- End Unfold -->
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive datatable-custom">
                    <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        data-hs-datatables-options='{
                            "search": "#datatableSearch",
                            "entries": "#datatableEntries",
                            "isResponsive": false,
                            "isShowPaging": false,
                            "paging":false,
                        }'>
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0">SL</th>
                                <th class="border-0">Id</th>
                                <th class="border-0 w--1">Main category</th>
                                <th class="border-0 text-center">Sub category</th>
                                <th class="border-0 text-center">Status</th>
                                <th class="border-0 text-center">Priority</th>
                                <th class="border-0 text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody id="table-div">
                        @foreach($categories as $key=>$category)
                            <tr>
                                <td>{{$key+$categories->firstItem()}}</td>
                                <td>{{$category->id}}</td>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        {{Str::limit($category->parent['name'],20,'...')}}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="d-block font-size-sm text-body">
                                        {{Str::limit($category->name,20,'...')}}
                                    </span>
                                </td>
                                <td>
                                    <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$category->id}}">
                                    <input type="checkbox" onclick="location.href='{{route('admin.category.status',[$category['id'],$category->status?0:1])}}'"class="toggle-switch-input" id="stocksCheckbox{{$category->id}}" {{$category->status?'checked':''}}>
                                        <span class="toggle-switch-label mx-auto">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                </td>
                                <td>
                                    <form action="{{route('admin.category.priority',$category->id)}}">
                                        <select name="priority" id="priority" onchange="this.form.submit()" class="form-control form--control-select mx-auto {{$category->priority == 0 ? 'text-title':''}} {{$category->priority == 1 ? 'text-info':''}} {{$category->priority == 2 ? 'text-success':''}}">
                                            <option value="0" {{$category->priority == 0?'selected':''}}>Normal</option>
                                            <option value="1" {{$category->priority == 1?'selected':''}}>Medium</option>
                                            <option value="2" {{$category->priority == 2?'selected':''}}>High</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn action-btn btn--primary btn-outline-primary"
                                            href="{{route('admin.category.edit-sub-category',[$category['id']])}}" title="Edit Sub Category"><i class="tio-edit"></i>
                                        </a>
                                        <a class="btn action-btn btn--danger btn-outline-danger" href="javascript:"
                                        onclick="form_alert('category-{{$category['id']}}','Want to delete this category')" title="Delete category"><i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="{{route('admin.category.delete',[$category['id']])}}" method="post" id="category-{{$category['id']}}">
                                            @csrf @method('delete')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if(count($categories) !== 0)
            <hr>
            @endif
            <div class="page-area">
                {!! $categories->links() !!}
            </div>
            @if(count($categories) === 0)
            <div class="empty--data">
                <img src="{{asset('/public/assets/admin/svg/illustrations/sorry.svg')}}" alt="public">
                <h5>
                    No data found
                </h5>
            </div>
            @endif
        </div>

    </div>

@endsection

@push('script_2')
    <script>
        $(document).on('ready', function () {
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>
@endpush
