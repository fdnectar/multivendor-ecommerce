
<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>@yield('pageTitle')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="/images/site/{{ get_settings()->site_favicon }}">

        <link href="/back/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

        <link href="/back/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="/back/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="/back/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- preloader css -->
        <link rel="stylesheet" href="/back/assets/css/preloader.min.css" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="/back/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="/back/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="/back/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="/extra-assets/ijaboCroptool/ijaboCropTool.min.css">
        <link rel="stylesheet" href="/extra-assets/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" href="/extra-assets/jquery-ui/jquery-ui.structure.min.css">
        <link rel="stylesheet" href="/extra-assets/jquery-ui/jquery-ui.theme.min.css">
        <link rel="stylesheet" href="/extra-assets/summernote/summernote-bs4.min.css">

        @livewireStyles
        @stack('custom-styles')

    </head>

    <body>

    <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            @include('back.layouts.inc.header')

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    @include('back.layouts.inc.sidebar')
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- Toaster start here -->
                        <div id="primary" class="toast hide fade align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; right: 20px; top: 80px; z-index: 1050;">
                            <div class="d-flex">
                                <div class="toast-body">
                                    Hello, world! This is a toast message.
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>

                        <div id="success" class="toast hide fade align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; right: 20px; top: 80px; z-index: 1050;">
                            <div class="d-flex">
                                <div class="toast-body">
                                    Hello, world! This is a toast message.
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>

                        <div id="warning" class="toast hide fade align-items-center text-white bg-warning border-0" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; right: 20px; top: 80px; z-index: 1050;">
                            <div class="d-flex">
                                <div class="toast-body">
                                    Hello, world! This is a toast message.
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>

                        <div id="danger" class="toast hide fade align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; right: 20px; top: 80px; z-index: 1050;">
                            <div class="d-flex">
                                <div class="toast-body">
                                    Hello, world! This is a toast message.
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                        <!-- Toaster end here -->

                        @yield('content')

                    </div>



                </div>
                <!-- End Page-content -->


                @include('back.layouts.inc.footer')
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->


        <!-- Right Sidebar -->
        @include('back.layouts.inc.right-sidebar')
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="/back/assets/libs/jquery/jquery.min.js"></script>
        <script src="/back/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/back/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="/back/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="/back/assets/libs/node-waves/waves.min.js"></script>
        <script src="/back/assets/libs/feather-icons/feather.min.js"></script>
        <!-- pace js -->
        <script src="/back/assets/libs/pace-js/pace.min.js"></script>

        <!-- Sweet Alerts js -->
        <script src="/back/assets/libs/sweetalert2/sweetalert2.min.js"></script>

        <!-- Sweet alert init js-->
        <script src="/back/assets/js/pages/sweetalert.init.js"></script>

        <!-- Required datatable js -->
        <script src="/back/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="/back/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="/back/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="/back/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="/back/assets/libs/jszip/jszip.min.js"></script>
        <script src="/back/assets/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="/back/assets/libs/pdfmake/build/vfs_fonts.js"></script>
        <script src="/back/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="/back/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="/back/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

        <!-- Responsive examples -->
        <script src="/back/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="/back/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="/back/assets/js/pages/datatables.init.js"></script>

        <script src="/back/assets/js/pages/bootstrap-toasts.init.js"></script>

        <script src="/extra-assets/ijaboCroptool/ijaboCropTool.min.js"></script>
        <script src="/extra-assets/jquery-ui/jquery-ui.min.js"></script>
        <script src="/back/assets/js/app.js"></script>
        <script src="/extra-assets/summernote/summernote-bs4.min.js"></script>

        <script>
            if(navigator.userAgent.indexOf("Firefox") != -1) {
                history.pushState(null, null, document.URL);
                window.addEventListener('popstate', function(){
                    histoy.pushState(null, null, document.URL);
                });
            }

            $(document).ready(function() {
                $('.summernote').summernote({
                    height: 200
                });
            });
        </script>

        <script>

            window.addEventListener('showToaster', function(event) {
                const type = event.detail[0].type;
                const message = event.detail[0].message;

                // Get the specific toaster based on the type
                const toaster = document.getElementById(type);
                if (toaster) {
                    // Update the toaster message
                    const toasterBody = toaster.querySelector('.toast-body');
                    toasterBody.textContent = message;

                    const toastInstance = new bootstrap.Toast(toaster);
                    toastInstance.show();
                } else {
                    console.error(`No toaster found for type: ${type}`);
                }
            });

            $(document).ready(function(){
                $("#sub-cat-datatable").DataTable({
                    "ordering": false,
                });
            });


        </script>

        @livewireScripts
        @stack('custom-scripts')




    </body>
</html>
