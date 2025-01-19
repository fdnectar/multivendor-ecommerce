@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin Home Page')


@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Add Product</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('seller.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Add Product</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<form action="{{ route('seller.product.create') }}" method="POST" enctype="multipart/form-data" id="addProductForm">
    <div class="row">
        <div class="col-xl-8 col-lg-8">
            <div class="card">
                <div class="card-body">
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
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name"
                                value="">
                                <span class="text-danger error-text product_name_error"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Product Summary</label>
                                <textarea name="product_summary" id="product_summary" placeholder="Enter Product Summary" cols="4" rows="4" class="form-control summernote"
                                ></textarea>
                                <span class="text-danger error-text product_summary_error"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Product Image (Must be square and Maximum dimension of (1080 X 1080))</label>
                                <input type="file" class="form-control" id="product_image" name="product_image">
                                <span class="text-danger erro-text product_image_error"></span>
                                <div class="mb-2 mt-1" style="max-width: 250px;">
                                    <img src="" alt="" class="img-thumbnail" id="product-image-preview">
                                </div>
                                <b>NB</b>: <small class="text-danger">You will be able to add more images related to this product when you are on edit product page.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Category</label>
                                <select name="category" id="category" class="form-select">
                                    <option value="">-- Not Set --</option>
                                    @foreach ($categories as $value)
                                        <option value="{{ $value->id }}">{{ $value->category_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text category_error"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Sub Category</label>
                                <select name="subcategory" id="subcategory" class="form-select">
                                    <option value="">-- Not Set --</option>
                                </select>
                                <span class="text-danger error-text subcategory_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Product Price</label>
                                <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Eg: ₹ 500"
                                value="">
                                <span class="text-danger erro-text product_price_error"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Compare Product Price</label>
                                <input type="text" class="form-control" id="compare_price" name="compare_price" placeholder="Eg: ₹ 500"
                                value="">
                                <span class="text-danger error-text compare_price_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Product Visibility</label>
                                <select name="visibility" id="visibility" class="form-select">
                                    <option value="">-- Visibility --</option>
                                    <option value="1">Public</option>
                                    <option value="0">Private</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="mb-2">
        <button type="submit" class="btn btn-primary w-md">Add Product</button>
    </div>
</form>

@endsection

@push('custom-scripts')

<script>
    //logo preview
    $('input[type="file"][name="product_image"][id="product_image"]').on('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                $('#product-image-preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    $(document).on('change', 'select#category', function(e) {
        e.preventDefault();
        var category_id = $(this).val();
        // console.log(category_id);
        var url = "{{ route('seller.product.get-product-category') }}";
        if(category_id == '') {
            $("select#subcategory").find("option").not(":first").remove();
        } else {
            $.get(url, {category_id:category_id}, function(response) {
                $("select#subcategory").find("option").not(":first").remove();
                $("select#subcategory").append(response.data);
            }, 'JSON');
        }
    });

    $("#addProductForm").on('submit', function(e) {
        e.preventDefault();
        var summary = $('textarea.summernote').summernote('code');
        var form = this;
        var formdata = new FormData(form);
            formdata.append('product_summary', summary);

        $.ajax({
            url:$(form).attr('action'),
            method:$(form).attr('method'),
            data:formdata,
            processData:false,
            dataType:'json',
            contentType:false,
            beforeSend:function() {
                $(form).find('span.error-text').text('');
            },
            success:function(response) {
                if(response.status == 1) {
                    $(form)[0].reset();
                    $('textarea.summernote').summernote('code', '');
                    $('select#subcategory').find('option').not(':first').remove();
                    $('#img#product-image-preview').attr('src', '');
                    $('#success .toast-body').text(response.msg);
                    var successToast = new bootstrap.Toast(document.getElementById('success'));
                    successToast.show();
                } else {
                    $('#danger .toast-body').text(response.msg);
                    var dangerToast = new bootstrap.Toast(document.getElementById('danger'));
                    dangerToast.show();
                }
            },
            error:function(response) {
                $.each(response.responseJSON.errors, function(prefix, val) {
                    $(form).find('span.'+prefix+'_error').text(val[0]);
                });
            }
        });
    });


</script>

@endpush
