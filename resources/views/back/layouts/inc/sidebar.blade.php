<div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title" data-key="t-menu">Menu</li>

        @if (Route::is('admin.*'))
            <li>
                <a href="{{ route('admin.home') }}" class="{{ Route::is('admin.home') ? 'active' : '' }}">
                    <i data-feather="home"></i>
                    <span data-key="t-dashboard">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.manage-categories.cat-subcats-list') }}" class="{{ Route::is('admin.manage-categories.cat-subcats-list') ? 'active' : '' }}">
                    <i data-feather="sliders"></i>
                    <span data-key="t-tables">Manage Categories</span>
                </a>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="grid"></i>
                    <span data-key="t-apps">Apps</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="apps-calendar.html">
                            <span data-key="t-calendar">Calendar</span>
                        </a>
                    </li>

                    <li>
                        <a href="apps-chat.html">
                            <span data-key="t-chat">Chat</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <span data-key="t-email">Email</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="apps-email-inbox.html" data-key="t-inbox">Inbox</a></li>
                            <li><a href="apps-email-read.html" data-key="t-read-email">Read Email</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <span data-key="t-invoices">Invoices</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="apps-invoices-list.html" data-key="t-invoice-list">Invoice List</a></li>
                            <li><a href="apps-invoices-detail.html" data-key="t-invoice-detail">Invoice Detail</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <span data-key="t-contacts">Contacts</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="apps-contacts-grid.html" data-key="t-user-grid">User Grid</a></li>
                            <li><a href="apps-contacts-list.html" data-key="t-user-list">User List</a></li>
                            <li><a href="apps-contacts-profile.html" data-key="t-profile">Profile</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="">
                            <span data-key="t-blog">Blog</span>
                            <span class="badge rounded-pill badge-soft-danger float-end" key="t-new">New</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="apps-blog-grid.html" data-key="t-blog-grid">Blog Grid</a></li>
                            <li><a href="apps-blog-list.html" data-key="t-blog-list">Blog List</a></li>
                            <li><a href="apps-blog-detail.html" data-key="t-blog-details">Blog Details</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.settings') }}" class="{{ Route::is('admin.settings') ? 'active' : '' }}">
                    <i data-feather="settings"></i>
                    <span data-key="t-settings">Settings</span>
                </a>
            </li>
        @else
            <li>
                <a href="#">
                    <i data-feather="home"></i>
                    <span data-key="t-dashboard">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('seller.shop-settings') }}" class="{{ Route::is('seller.shop-settings') ? 'active' : '' }}">
                    <i data-feather="settings"></i>
                    <span data-key="t-settings">Shop Settings</span>
                </a>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow {{ Route::is('seller.product.*') ? 'active' : '' }}">
                    <i data-feather="grid"></i>
                    <span data-key="t-apps">Manage Products</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{ route('seller.product.all-products') }}" class="{{ Route::is('seller.product.all-products') ? 'active' : '' }}">
                            <span data-key="t-calendar">- All Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('seller.product.add-product') }}" class="{{ Route::is('seller.product.add-product') ? 'active' : '' }}">
                            <span data-key="t-calendar">- Add Product</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

    </ul>

</div>
