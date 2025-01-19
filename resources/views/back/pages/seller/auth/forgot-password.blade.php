@extends('back.layouts.auth-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Forgot Password')

@section('content')

    <div class="auth-full-page-content d-flex p-sm-5 p-4">
        <div class="w-100">
            <div class="d-flex flex-column h-100">
                <div class="mb-4 mb-md-5 text-center">
                    <a href="index.html" class="d-block auth-logo">
                        <img src="assets/images/logo-sm.svg" alt="" height="28"> <span class="logo-txt">Minia</span>
                    </a>
                </div>
                <div class="auth-content my-auto">
                    <div class="text-center">
                        <h5 class="mb-0">Seller Reset Password</h5>
                        <p class="text-muted mt-2">Reset Password with Minia.</p>
                    </div>
                    <div class="alert alert-success text-center my-4" role="alert">
                        Enter your Email and instructions will be sent to you!
                    </div>
                    <form class="mt-4" action="{{ route('seller.send-password-reset-link') }}" method="POST">
                        @csrf

                        @if(Session::get('fail'))
                            <div class="alert alert-danger alert-top-border alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-block-helper me-3 align-middle text-danger"></i><strong>Error</strong> - {{ Session::get('fail') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(Session::get('success'))
                            <div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Email Sent</strong> - {{ Session::get('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Enter email" value="{{ old('email') }}">
                            @error('email')
                                <div class="d-block text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 mt-4">
                            <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Reset</button>
                        </div>
                    </form>

                    <div class="mt-5 text-center">
                        <p class="text-muted mb-0">Remember It ?  <a href="{{ route('seller.login') }}" class="text-primary fw-semibold"> Sign In </a> </p>
                    </div>
                </div>
                <div class="mt-4 mt-md-5 text-center">
                    <p class="mb-0">© <script>document.write(new Date().getFullYear())</script>2024 Minia   . Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                </div>
            </div>
        </div>
    </div>

@endsection
