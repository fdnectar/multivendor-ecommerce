@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin Home Page')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Shop Settings</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('seller.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Shop Settings</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-9 col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('seller.shop-setup') }}" method="POST" enctype="multipart/form-data">

                    @if(Session::get('fail'))
                        <div class="alert alert-danger alert-top-border alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-block-helper me-3 align-middle text-danger"></i><strong>Error</strong> - {{ Session::get('fail') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(Session::get('success'))
                        <div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Good</strong> - {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Shop Name</label>
                                <input type="text" class="form-control" id="formrow-username-input" name="shop_name" placeholder="Enter Shop Name"
                                value="{{ old('shop_name') ? old('shop_name') : $shopInfo->shop_name }}">
                                @error('shop_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Shop Phone</label>
                                <input type="tel" class="form-control" id="formrow-username-input" name="shop_phone" placeholder="Enter Shop Phone"
                                value="{{ old('shop_phone') ? old('shop_phone') : $shopInfo->shop_phone }}">
                                @error('shop_phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Address</label>
                                <input type="text" class="form-control" id="formrow-username-input" name="shop_address" placeholder="Enter Address"
                                value="{{ old('shop_address') ? old('shop_address') : $shopInfo->shop_address }}">
                                @error('shop_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Shop Description</label>
                                <textarea name="shop_description" id="shop_description" placeholder="Enter Shop Description" cols="4" rows="4" class="form-control"
                                >{{ old('shop_description') ? old('shop_description') : $shopInfo->shop_description }}</textarea>
                                @error('shop_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Shop Logo</label>
                                <input type="file" class="form-control" id="shop_logo" name="shop_logo">
                                <div class="mb-2 mt-1" style="max-width: 200px;">
                                    <img src="{{ $shopInfo->shop_logo != null ? '/images/shop/'.$shopInfo->shop_logo : '' }}" alt="" class="img-thumbnail" id="shop-logo-preview">
                                </div>
                                @error('shop_logo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary w-md">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection

@push('custom-scripts')

<script>
    //logo preview
    $('input[type="file"][name="shop_logo"][id="shop_logo"]').on('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                $('#shop-logo-preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
</script>

@endpush
