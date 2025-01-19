@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin Home Page')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Udate Category</h4>

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
                <h4 class="card-title">Update Category</h4>
            </div>
            <div class="card-body">
                <form class="" action="{{ route('admin.manage-categories.store-updated-category') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="category_id" value="{{ Request('id') }}">
                    @csrf

                    @if(Session::get('fail'))
                        <div class="alert alert-danger alert-top-border alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-block-helper me-3 align-middle text-danger"></i><strong>Error</strong> - {{ Session::get('fail') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(Session::get('success'))
                        <div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Category Update</strong> - {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-7 mb-3">
                            <div class="">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $category->category_name }}" placeholder="Enter categroy name">
                            </div>
                            @error('category_name')
                                <div class="d-block text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-7 mb-3">
                            <div class="">
                                <label class="form-label">Category Image</label>
                                <input type="file" class="form-control" id="category_image" name="category_image">
                            </div>
                            @error('category_image')
                                <div class="d-block text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-7">
                            <div class="mb-2 mt-1" style="max-width: 150px;">
                                <img src="/images/categories/{{ $category->category_image }}" class="img-thumbnail" id="category_img_preview" alt="">
                            </div>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Update Category</button>
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
    $('input[type="file"][name="category_image"][id="category_image"]').on('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                $('#category_img_preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
</script>

@endpush
