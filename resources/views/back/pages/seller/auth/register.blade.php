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
                    <h5 class="mb-0">Create Seller Account!</h5>
                    {{-- <p class="text-muted mt-2">Sign in to continue to Minia.</p> --}}
                </div>
                <form class="mt-4 pt-2" action="{{ route('seller.create') }}" method="POST">
                    @csrf

                    @if(Session::get('fail'))
                        <div class="alert alert-danger alert-top-border alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-block-helper me-3 align-middle text-danger"></i><strong>Error</strong> - {{ Session::get('fail') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(Session::get('success'))
                        <div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Account Created</strong> - {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Fullname</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Fullname">
                        @error('name')
                            <div class="d-block text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter Email">
                        @error('email')
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

                    <div class="mb-3">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <label class="form-label">Confirm Password</label>
                            </div>
                        </div>

                        <div class="input-group auth-pass-inputgroup">
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter Confirm password" aria-label="Confirm Password" aria-describedby="password-addon">
                            <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                        </div>
                        @error('confirm_password')
                            <div class="d-block text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Create Account</button>
                    </div>
                    <div class="text-center mb-3">Or</div>
                    <div class="mb-3">
                        <a href="{{ route('seller.login') }}" class="btn btn-outline-primary w-100 waves-effect waves-light">Login</a>
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
