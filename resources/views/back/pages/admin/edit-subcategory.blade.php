@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin Home Page')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Edit SubCategory</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.manage-categories.cat-subcats-list') }}">Go Back</a></li>
                    {{-- <li class="breadcrumb-item active">Profile</li> --}}
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Category</h4>
            </div>
            <div class="card-body">
                <form class="" action="{{ route('admin.manage-categories.update-subcategory') }}" method="POST">
                    <input type="hidden" name="subcategory_id" value="{{ Request('id') }}">
                    @csrf

                    @if(Session::get('fail'))
                        <div class="alert alert-danger alert-top-border alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-block-helper me-3 align-middle text-danger"></i><strong>Error</strong> - {{ Session::get('fail') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(Session::get('success'))
                        <div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>SubCategory Updated</strong> - {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-7 mb-3">
                            <div class="">
                                <label class="form-label">Parent Category</label>
                                <select name="parent_category" id="parent_category" class="form-select">
                                    <option value="">Not Set</option>
                                    @foreach ($categories as $value)
                                        <option value="{{ $value->id }}" {{ $subcategory->category_id == $value->id ? 'selected' : '' }}>{{ $value->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('parent_category')
                                <div class="d-block text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-7 mb-3">
                            <div class="">
                                <label class="form-label">SubCategory Name</label>
                                <input type="text" class="form-control" id="subcategory_name" name="subcategory_name" value="{{ $subcategory->subcategory_name }}" placeholder="Enter Subcategroy name">
                            </div>
                            @error('subcategory_name')
                                <div class="d-block text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-7 mb-3">
                            <div class="">
                                <label class="form-label">Is Child Of</label>
                                <select name="is_child_of" id="is_child_of" class="form-select">
                                    <option value="0">--- Independent ---</option>
                                    @foreach ($subcategories as $value)
                                        @if ($value->id != $subcategory->id)
                                            <option value="{{ $value->id }}" {{ $subcategory->is_child_of != 0 && $subcategory->is_child_of == $value->id ? 'selected' : '' }}>{{ $value->subcategory_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @error('is_child_of')
                                <div class="d-block text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('custom-scripts')

<script>

</script>

@endpush
