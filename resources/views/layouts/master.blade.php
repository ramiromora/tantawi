<!doctype html>
<html lang="es" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>TANTAWI 2.0</title>        
        <meta name="author" content="ofepbolivia">
        <meta name="robots" content="noindex, nofollow">
        <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.png')}}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/favicon-192x192.png')}}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/apple-touch-icon-180x180.png')}}">
        <link rel="stylesheet" href="{{ asset('assets/js/plugins/slick/slick.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/js/plugins/slick/slick-theme.css')}}">
        <link rel="stylesheet" href="{{ asset('css/custom.css')}}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
        <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/codebase.css')}}">
        <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/rojo.css')}}">
        <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
        @yield('css')
    </head>
    <body>
        <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-modern main-content-boxed">
            <aside id="side-overlay">
                <div class="content-header content-header-fullrow">
                    <div class="content-header-section align-parent">
                        <button type="button" class="btn btn-circle btn-dual-secondary align-v-r" data-toggle="layout" data-action="side_overlay_close">
                            <i class="fa fa-times text-danger"></i>
                        </button>
                        <div class="content-header-item">
                            <a class="img-link mr-5" href="be_pages_generic_profile.html">
                                <img class="img-avatar img-avatar32" src="{{ asset('assets/media/avatars/avatar15.jpg')}}" alt="">
                            </a>
                            <a class="align-middle link-effect text-primary-dark font-w600" href="be_pages_generic_profile.html">{{Auth::user()->name}}</a>
                        </div>
                    </div>
                </div>
                {{-- <div class="content-side">
                @include('partials.right-sidebar')
                </div> --}}
            </aside>
            <nav id="sidebar">
                <div class="sidebar-content">
                    <div class="content-header content-header-fullrow px-15">
                        <div class="content-header-section sidebar-mini-visible-b">
                            <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                                <span class="text-dual-primary-dark">c</span><span class="text-primary">b</span>
                            </span>
                        </div>
                        <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                            <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                                <i class="fa fa-times text-danger"></i>
                            </button>
                            <div class="content-header-item"> <a href="#"><img src="{{ asset('assets/media/ofep/logosm.png')}}" width="158" height="90" alt=""/></a> </div>
                        </div>
                    </div>  
                @include('partials.sidebar-main')
            </nav>
                @include('partials.header')
            <main id="main-container-fluid">
                <div class="content">
                    @yield('content')
                </div>
                <!-- END Page Content -->

            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            <footer id="page-footer" class="opacity-0">
                <div class="content py-20 font-size-xs clearfix">
                    <div class="float-right">
                        Programado con <i class="fa fa-heart text-pulse"></i> por la <a class="font-w600" href="http://www.ofep.gob.bo" target="_blank">OFEP-  Bolivia</a>
                    </div>
                    <div class="float-left">
                    </div>
                </div>
            </footer>
        </div>
        <script src="{{ asset('assets/js/codebase.core.min.js')}}"></script>
        <script src="{{ asset('assets/js/codebase.app.min.js')}}"></script>

        <!-- Page JS Plugins -->
        <script src="{{ asset('assets/js/plugins/chartjs/Chart.bundle.min.js')}}"></script>
        <script src="{{ asset('assets/js/plugins/slick/slick.min.js')}}"></script>

        <!-- Page JS Code -->
        <script src="{{ asset('assets/js/pages/be_pages_dashboard.min.js')}}"></script>
        <script src="{{asset('js/toastr.js')}}"></script>
        @toastr_render
        @yield('scripts')
    </body>
</html>