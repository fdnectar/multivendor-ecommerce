@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin Settings Page')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Settings</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            @livewire('admin-settings')
        </div>
    </div>
</div>


@endsection

@push('custom-scripts')

<script>
    //logo preview
    $('input[type="file"][name="site_logo"][id="site_logo"]').on('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                $('#site_logo_img_preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    //favicon preview
    $('input[type="file"][name="site_favicon"][id="site_favicon"]').on('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                $('#site_favicon_img_preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });


    //change logo ajax
    $('#change_site_logo_form').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formdata = new FormData(form);
        var inputFileVal = $(form).find('input[type="file"][name="site_logo"]').val();

        if(inputFileVal.length > 0) {
            $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:formdata,
                processData:false,
                dataType:'json',
                contentType:false,
                beforSend:function() {
                    toastr.remove();
                    $(form).find('span.error-text').text('');
                },
                success: function(response) {
                    if (response.status == 1) {
                        $('#success .toast-body').text(response.msg);
                        var successToast = new bootstrap.Toast(document.getElementById('success'));
                        successToast.show();
                        $(form)[0].reset();
                    } else {
                        $('#danger .toast-body').text(response.msg);
                        var dangerToast = new bootstrap.Toast(document.getElementById('danger'));
                        dangerToast.show();
                    }
                }
            })
        } else {
            $(form).find('span.error-text').text('Please, select a logo image file. PNG file is recommended...');
        }
    });

    //change favicon ajax
    $('#change_site_favicon_form').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formdata = new FormData(form);
        var inputFileVal = $(form).find('input[type="file"][name="site_favicon"]').val();

        if(inputFileVal.length > 0) {
            $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:formdata,
                processData:false,
                dataType:'json',
                contentType:false,
                beforSend:function() {
                    toastr.remove();
                    $(form).find('span.error-text').text('');
                },
                success: function(response) {
                    if (response.status == 1) {
                        $('#success .toast-body').text(response.msg);
                        var successToast = new bootstrap.Toast(document.getElementById('success'));
                        successToast.show();
                        $(form)[0].reset();
                    } else {
                        $('#danger .toast-body').text(response.msg);
                        var dangerToast = new bootstrap.Toast(document.getElementById('danger'));
                        dangerToast.show();
                    }
                }
            })
        } else {
            $(form).find('span.error-text').text('Please, select a favicon image file. PNG file is recommended...');
        }
    });

</script>

@endpush
