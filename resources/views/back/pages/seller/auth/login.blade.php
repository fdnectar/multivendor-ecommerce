@extends('back.layouts.auth-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Login')

@section('content')

<div class="auth-full-page-content d-flex p-sm-5 p-4">
    <div class="w-100">
        <div class="d-flex flex-column h-100">
            <div class="mb-4 mb-md-5 text-center">
                <a href="index.html" class="d-block auth-logo">
                    <img src="/images/site/{{ get_settings()->site_logo }}" alt="" height="28">
                </a>
            </div>
            <div class="auth-content my-auto">
                <div class="text-center">
                    <h5 class="mb-0">Welcome Back Seller!</h5>
                    {{-- <p class="text-muted mt-2">Sign in to continue to Minia.</p> --}}
                </div>
                <form class="mt-4 pt-2" action="{{ route('seller.login-handler') }}" method="POST">
                    @csrf

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

                    @if(Session::get('info'))
                        <div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Good</strong> - {{ Session::get('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(Session::get('pass'))
                        <div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Password Changed</strong> - {{ Session::get('pass') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="login_id" name="login_id" value="{{ old('login_id') }}" placeholder="Enter email/username">
                        @error('login_id')
                            <div class="d-block text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <label class="form-label">Password</label>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="">
                                    <a href="{{ route('seller.forgot-password') }}" class="text-muted">Forgot password?</a>
                                </div>
                            </div>
                        </div>

                        <div class="input-group auth-pass-inputgroup">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                            <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                        </div>
                        @error('password')
                            <div class="d-block text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-check">
                                <label class="form-check-label" for="remember-check">
                                    Remember me
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log In</button>
                    </div>
                </form>


            </div>
            <div class="mt-4 mt-md-5 text-center">
                <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Minia   . Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
            </div>
        </div>
    </div>
</div>

@endsection
