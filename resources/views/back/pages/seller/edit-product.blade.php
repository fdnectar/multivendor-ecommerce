@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin Home Page')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Edit Product</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('seller.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Edit Product</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<form action="{{ route('seller.product.update-product') }}" method="POST" enctype="multipart/form-data" id="updateProductForm">
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
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name"
                                value="{{ $product->product_name }}">
                                <span class="text-danger error-text product_name_error"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Product Summary</label>
                                <textarea name="product_summary" id="product_summary" placeholder="Enter Product Summary" cols="4" rows="4" class="form-control summernote"
                                >{!! $product->product_summary !!}</textarea>
                                <span class="text-danger error-text product_summary_error"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Product Image (Must be square and Maximum dimension of (1080 X 1080))</label>
                                <input type="file" class="form-control" id="product_image" name="product_image">
                                <span class="text-danger erro-text product_image_error"></span>
                                <div class="mb-2 mt-1" style="max-width: 250px;">
                                    <img src="/images/products/{{ $product->product_image }}" alt="" class="img-thumbnail" id="product-image-preview">
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
                                    @foreach ($categories as $value)
                                        <option value="{{ $value->id }}" {{ $product->category_id == $value->id ? 'selected' : '' }}>{{ $value->category_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text category_error"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Sub Category</label>
                                <select name="subcategory" id="subcategory" class="form-select">
                                    <option value="">-- Not Set --</option>
                                    @foreach ($subcategories as $value)
                                        <option value="{{ $value->id }}" {{ $value->id == $product->subcategory_id ? 'selected' : '' }}>{{ $value->subcategory_name }}</option>

                                        @if (count($value->children) > 0)
                                            @foreach ($value->children as $child)
                                                <option value="{{ $child->id }}" {{ $child->id == $product->subcategory_id ? 'selected' : '' }}>-- {{ $child->subcategory_name }}</option>
                                            @endforeach
                                        @endif
                                    @endforeach
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
                                value="{{ $product->product_price }}">
                                <span class="text-danger erro-text product_price_error"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Compare Product Price</label>
                                <input type="text" class="form-control" id="compare_price" name="compare_price" placeholder="Eg: ₹ 500"
                                value="{{ $product->compare_price }}">
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
                                    <option value="1" {{ $product->visibility == 1 ? 'selected' : '' }}>Public</option>
                                    <option value="0" {{ $product->visibility == 0 ? 'selected' : '' }}>Private</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="mb-2">
        <button type="submit" class="btn btn-primary w-md">Update Product</button>
    </div>
</form>

<div class="row mt-5">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header bg-transparent">
                <h5 class="my-0 text-dark">Additional Images</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('seller.product.upload-product-images') }}" class="dropzone">
                    <input type="hidden" name="product_id" value="{{ request('id') }}">
                    @csrf
                </form>
                <div class="mb-2 mt-2">
                    <button type="submit" class="btn btn-primary w-md" id="uploadAdditionalImagesBtn">Upload Images</button>
                </div>
            </div>
        </div>
    </div>
    <div class="box-container mb-2" id="product_images">

    </div>
</div>


@endsection

@push('custom-styles')

    <link rel="stylesheet" href="/extra-assets/dropzonejs/min/dropzone.min.css">
    <style>
        .box-container {
            width: 100%;
            display: flex;
            flex-direction: row;
            gap: 1rem;
            justify-content: flex-start;
            flex-wrap: wrap;
        }

        .box-container .box {
            background: #423838;
            width: 110px;
            height: 110px;
            position: relative;
            overflow: hidden;
        }

        .box-container .box img{
            width: 100%;
            height: auto;
        }

        .box-container .box a {
            position: absolute;
            right: 7px;
            bottom: 5px;
        }

    </style>

@endpush

@push('custom-scripts')

<script src="/extra-assets/dropzonejs/min/dropzone.min.js"></script>

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

    $("#updateProductForm").on('submit', function(e) {
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

    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone('.dropzone', {
        autoProcessQueue:false,
        parallelUploads:1,
        addRemoveLinks:true,
        maxFileSize:2,
        acceptedFiles:'image/*',
        init:function() {
            thisDz = this;
            var uploadBtn = document.getElementById('uploadAdditionalImagesBtn');
            uploadBtn.addEventListener('click', function() {
                var nFiles = myDropzone.getQueuedFiles().length;
                thisDz.options.parallelUploads = nFiles;
                thisDz.processQueue();
            });
            thisDz.on('queuecomplete', function(){
                this.removeAllFiles();
                getProductImages();
            });
        }
    });

    getProductImages()
    function getProductImages() {
        var url = "{{ route('seller.product.get-product-images', ['product_id' => request('id')]) }}";
        $.get(url, {}, function(response) {
            $('div#product_images').html(response.data);
        }, 'json');
    }

    $(document).on('click', '#deleteProductImage', function(e) {
        e.preventDefault();
        var url = "{{ route('seller.product.delete-product-image') }}";
        var token = "{{ csrf_token() }}";
        var image_id = $(this).data("image");
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete this image!",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#2ab57d",
            cancelButtonColor: "#fd625e",
            confirmButtonText: "Yes, delete it!",
            allowOutsideClick: false,
        }).then(function (result) {
            if(result.value) {
                $.post(url, { _token:token, image_id:image_id }, function(response){
                    if(response.status == 1) {
                        getProductImages();
                        $('#success .toast-body').text(response.msg);
                        var successToast = new bootstrap.Toast(document.getElementById('success'));
                        successToast.show();
                    } else {
                        $('#danger .toast-body').text(response.msg);
                        var dangerToast = new bootstrap.Toast(document.getElementById('danger'));
                        dangerToast.show();
                    }
                }, 'json');
            }
        });
    });

</script>

@endpush
