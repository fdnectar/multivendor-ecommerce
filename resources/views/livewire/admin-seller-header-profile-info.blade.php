<div>
    @if (Auth::guard('admin')->check())
        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item bg-light-subtle border-start border-end" id="page-header-user-dropdown"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle header-profile-user" src="{{ $admin->picture }}"
                    alt="Header Avatar">
                <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ $admin->name }}</span>
                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="mdi mdi mdi-face-man font-size-16 align-middle me-1"></i> Profile</a>
                <a class="dropdown-item" href="{{ route('admin.settings') }}"><i data-feather="settings" class="align-middle me-1" width="15" height="15"></i> Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('admin.logout-handler') }}"
                    onclick="event.preventDefault();document.getElementById('adminLogoutForm').submit();" >
                    <i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout
                </a>
                <form action="{{ route('admin.logout-handler') }}" id="adminLogoutForm" method="POST">
                    @csrf
                </form>
            </div>
        </div>
    @elseif (Auth::guard('seller')->check())
        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item bg-light-subtle border-start border-end" id="page-header-user-dropdown"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle header-profile-user" src="{{ $seller->picture }}"
                    alt="Header Avatar">
                <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ $seller->name }}</span>
                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <a class="dropdown-item" href="{{ route('seller.profile') }}"><i class="mdi mdi mdi-face-man font-size-16 align-middle me-1"></i> Profile</a>
                <a class="dropdown-item" href="auth-lock-screen.html"><i data-feather="settings" class="align-middle me-1" width="15" height="15"></i> Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('seller.logout-handler') }}"
                    onclick="event.preventDefault();document.getElementById('sellerLogoutForm').submit();">
                    <i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout
                </a>
                <form action="{{ route('seller.logout-handler') }}" id="sellerLogoutForm" method="POST">
                    @csrf
                </form>
            </div>
        </div>
    @endif
</div>
