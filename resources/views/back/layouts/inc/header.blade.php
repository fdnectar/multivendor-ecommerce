<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    {{-- <span class="logo-sm">
                        <img src="/images/site/{{ get_settings()->site_logo }}" alt="" height="24">
                    </span> --}}
                    <span class="logo-lg">
                        <img src="/images/site/{{ get_settings()->site_logo }}" alt="" height="33">
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    {{-- <span class="logo-sm">
                        <img src="/images/site/{{ get_settings()->site_logo }}" alt="" height="24">
                    </span> --}}
                    <span class="logo-lg">
                        <img src="/images/site/{{ get_settings()->site_logo }}" alt="" height="33">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex">

            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item right-bar-toggle me-2">
                    <i data-feather="settings" class="icon-lg"></i>
                </button>
            </div>

            {{-- <livewire:admin-seller-header-profile-info> --}}

            @livewire('admin-seller-header-profile-info')

        </div>
    </div>
</header>
