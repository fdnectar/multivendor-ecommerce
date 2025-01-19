@extends('back.layouts.auth-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Reset Password')

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
                        <h5 class="mb-0">Reset Password</h5>
                    </div>
                    <form class="mt-4" action="{{ route('admin.reset-password-handler', ['token'=>request()->token]) }}" method="POST">
                        @csrf
                        @if(Session::get('fail'))
                            <div class="alert alert-danger alert-top-border alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-block-helper me-3 align-middle text-danger"></i><strong>Error</strong> - {{ Session::get('fail') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(Session::get('success'))
                            <div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Logged Out</strong> - {{ Session::get('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="input-group auth-pass-inputgroup mb-3">
                            <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter new password" value="{{ old('new_password') }}" aria-label="Password" aria-describedby="password-addon">
                            <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                        </div>
                        @error('new_password')
                            <div class="d-block text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="input-group auth-pass-inputgroup">
                            <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" placeholder="Confirm new password" aria-label="Password" aria-describedby="password-addon">
                            <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                        </div>
                        @error('new_password_confirmation')
                            <div class="d-block text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="mb-3 mt-4">
                            <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Reset</button>
                        </div>
                    </form>

                    <div class="mt-5 text-center">
                        <p class="text-muted mb-0">Remember It ?  <a href="{{ route('admin.login') }}" class="text-primary fw-semibold"> Sign In </a> </p>
                    </div>
                </div>
                <div class="mt-4 mt-md-5 text-center">
                    <p class="mb-0">© <script>document.write(new Date().getFullYear())</script>2024 Minia   . Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                </div>
            </div>
        </div>
    </div>

@endsection
