@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin Home Page')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">All Products</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('seller.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">All Products</li>
                </ol>
            </div>

        </div>
    </div>
</div>

@livewire('seller.products')

@endsection

@push('custom-scripts')

<script>
    $(document).on('click', '#deleteProductBtn', function(e) {
        e.preventDefault();
        var url = "{{ route('seller.product.delete-product') }}";
        var token = "{{ csrf_token() }}";
        var product_id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete this product!",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#2ab57d",
            cancelButtonColor: "#fd625e",
            confirmButtonText: "Yes, delete it!",
            allowOutsideClick: false,
        }).then(function (result) {
            if(result.value) {
                $.post(url, { _token:token, product_id:product_id }, function(response){
                    if(response.status == 1) {
                        Livewire.dispatch('refreshProductList');
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
