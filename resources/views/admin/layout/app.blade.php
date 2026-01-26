<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>@include('admin.layout.head')</head>
    <body>
        <div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
            @include('admin.layout.navigation')
        </div>
        <div class="page-content">
            <div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">
                <div class="sidebar-content">
                    <div class="sidebar-section">
                        <div class="sidebar-section-body d-flex justify-content-center">
                            <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigation</h5>
                            <div>
                                <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                                    <i class="ph-arrows-left-right"></i>
                                </button>
                                <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                                    <i class="ph-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-section">
                        <ul class="nav nav-sidebar" data-nav-type="accordion">
                            @include('admin.layout.sidebar')
                        </ul>
                    </div>
                </div>
            </div>
            <div class="content-wrapper">
                <div class="content-inner">
                    <div class="page-header page-header-light shadow">
                        @yield('header')
                    </div>
                    <div class="content">
                        <div class="row">
                            @yield('content')
                        </div>
                    </div>
                    <div class="navbar navbar-sm navbar-footer border-top">
                        @include('admin.layout.footer')
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="notifications">
            @include('admin.layout.notification')
        </div>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="demo_config">
            @include('admin.layout.configuration')
        </div>
    </body>
</html>