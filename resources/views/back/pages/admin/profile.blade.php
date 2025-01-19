@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin Profile Page')

@push('custom-styles')
<style>
    .pic-avator {
        position: relative;
    }

    .avator-change {
        position: absolute;
        right: 16px;
    }

</style>
@endpush

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Profile</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Contacts</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-9 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm order-2 order-sm-1">
                            <div class="d-flex align-items-center mt-3 mt-sm-0">
                                <div class="flex-shrink-0 pic-avator">
                                    <a href="javascript:;" class="avator-change" onclick="event.preventDefault();document.getElementById('adminProfilePicturFile').click();"><i class="mdi mdi-pencil-outline" style="font-size: 20px;"></i></a>
                                    <div class="avatar-xl me-3">
                                        <img src="{{ $admin->picture }}" alt="" class="img-fluid rounded-circle d-block" id="adminProfilePicture">
                                    </div>
                                    <input type="file" name="adminProfilePicturFile" id="adminProfilePicturFile" class="d-none" style="opacity: 0;">
                                </div>
                                <div class="flex-grow-1">
                                    <div>
                                        <h5 class="font-size-16 mb-1" id="adminProfileName">{{ $admin->name }}</h5>
                                        <div class="d-flex flex-wrap align-items-start gap-2 gap-lg-3 text-muted font-size-13">
                                            <div id="adminProfileEmail"><i class="mdi mdi-circle-medium me-1 text-success align-middle"></i>{{ $admin->email }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            @livewire('admin-profile-tabs')
            <!-- end tab content -->
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Skills</h5>

                    <div class="d-flex flex-wrap gap-2 font-size-16">
                        <a href="#" class="badge bg-primary-subtle text-primary">Photoshop</a>
                        <a href="#" class="badge bg-primary-subtle text-primary">illustrator</a>
                        <a href="#" class="badge bg-primary-subtle text-primary">HTML</a>
                        <a href="#" class="badge bg-primary-subtle text-primary">CSS</a>
                        <a href="#" class="badge bg-primary-subtle text-primary">Javascript</a>
                        <a href="#" class="badge bg-primary-subtle text-primary">Php</a>
                        <a href="#" class="badge bg-primary-subtle text-primary">Python</a>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>

@endsection

@push('custom-scripts')

<script>
    window.addEventListener('updateAdminInfo', function() {
        $('#adminProfileName').html(event.detail[0].adminName);
        $('#adminProfileEmail').html(event.detail[0].adminEmail);
    });

    $('input[type="file"][name="adminProfilePicturFile"][id="adminProfilePicturFile"]').ijaboCropTool({
        preview : '#adminProfilePicture',
        setRatio:1,
        allowedExtensions: ['jpg', 'jpeg','png'],
        buttonsText:['CROP','QUIT'],
        buttonsColor:['#30bf7d','#ee5155', -15],
        processUrl:'{{ route("admin.change-profile-picture") }}',
        withCSRF:['_token','{{ csrf_token() }}'],
        onSuccess:function(message, element, status){
            Livewire.dispatch('updateAdminSellerHeaderInfo');
            document.querySelector('#success .toast-body').textContent = message;
            var toastElement = document.getElementById('success');
            var toast = new bootstrap.Toast(toastElement);
            toast.show();
        },
        onError:function(message, element, status){
            document.querySelector('#danger .toast-body').textContent = message;
            var toastElement = document.getElementById('danger');
            var toast = new bootstrap.Toast(toastElement);
            toast.show();
        }
    });
</script>

@endpush
