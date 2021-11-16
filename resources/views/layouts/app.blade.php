<?php

use App\Utils;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Patel Consultancy') }}</title>

    <!-- Fonts -->
    <?php $start_with = asset(''); ?>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ $start_with.'adminlte/plugins/fontawesome-free/css/all.min.css' }}">
    <link rel="stylesheet" href="{{ $start_with.'adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css' }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ $start_with.'adminlte/dist/css/adminlte.min.css' }}">
    <link rel="stylesheet" href="{{ $start_with.'adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css' }}">
    <link rel="stylesheet" href="{{ $start_with.'adminlte/plugins/daterangepicker/daterangepicker.css' }}">
    <link rel="stylesheet" href="{{ $start_with.'adminlte/plugins/summernote/summernote-bs4.css' }}">
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    <script>
        var config = {
            viewFolder: '<?= url('views') ?>'
        }
        var apis = {
            get_all_clients: '<?= route("client.getAll") ?>',
            sip_add: '<?= route("user-sip.store") ?>',
        }
    </script>

    <style>
        tfoot td {
            padding: 8px 5px !important;
        }

        td input,
        td select {
            width: 100%;
        }

        .select2-selection {
            height: 35px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0;
            border: 0;
            margin: 0;
        }
    </style>

    {{-- <script src="{{ asset('js/jquery.js') }}"></script> --}}

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php if (empty($hide_header)) : ?>
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php if (empty($hide_sidebar)) : ?>
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link">
                    <span class="brand-text font-weight-light">{{config('app.name')}}</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route("home") }}" class="nav-link {{ request()->is('home') || request()->is('home/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route("dashboard-insurance") }}" class="nav-link {{ request()->is('dashboard-insurance') || request()->is('dashboard-insurance') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Insurance Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route("change-password") }}" class="nav-link {{ request()->is('change-password') || request()->is('change-password/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-key"></i>
                                    <p>Change Password</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route("client.index") }}" class="nav-link {{ request()->is('client') || request()->is('client/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>Clients</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route("greetings.calendar") }}" class="nav-link {{ request()->is('greetings') || request()->is('greetings/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>Greetings</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview {{ request()->is('mutual-fund/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ request()->is('mutual-fund/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Mutual Funds
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('type.index') }}" class="nav-link {{ request()->is('mutual-fund/type*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Types</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('company.index') }}" class="nav-link {{ request()->is('mutual-fund/company*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Companies</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('funds.index') }}" class="nav-link {{ request()->is('mutual-fund/funds*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Mutual Fund</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview {{ request()->is('mutual-fund-investment/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ request()->is('mutual-fund-investment/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Mutual Funds Investment
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('user-mutual-fund.index') }}" class="nav-link {{ request()->is('mutual-fund-investment/user-mutual-fund*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>User Mutual Funds</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('user-sip.index') }}" class="nav-link {{ request()->is('mutual-fund-investment/user-sip*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Client SIPs</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('user-lump-sum.index') }}" class="nav-link {{ request()->is('mutual-fund-investment/user-lump-sum*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Client Lump Sum</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview {{ request()->is('insurance/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ request()->is('insurance/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Insurances
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('life-insurance-traditional.index') }}" class="nav-link {{ request()->is('insurance/life-insurance-traditional*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p><?= Utils::titles('life_traditional_insurance') ?></p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('life-insurance-ulip.index') }}" class="nav-link {{ request()->is('insurance/life-insurance-ulip*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Life Insurance Ulip</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('policy.index') }}" class="nav-link {{ request()->is('insurance/policy*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p><?= Utils::titles('general_insurance') ?></p>
                                        </a>
                                    </li>
                                    <?php if (false) : ?>
                                        <li class="nav-item">
                                            <a href="{{ route('category.index') }}" class="nav-link {{ request()->is('insurance/category*') ? 'active' : '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Category</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('sub-category.index') }}" class="nav-link {{ request()->is('insurance/sub-category*') ? 'active' : '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Sub Category</p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <li class="nav-item">
                                        <a href="{{ route('insurance-company.index') }}" class="nav-link {{ request()->is('insurance/insurance-company*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p><?= Utils::titles('insurance_companies') ?></p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('field.index') }}" class="nav-link {{ (request()->is('insurance/field*')) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Fields</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route("plan.index") }}" class="nav-link {{ request()->is('plan') || request()->is('plan/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-table"></i>
                                    <p>User Plan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route("main-slider.index") }}" class="nav-link {{ request()->is('main-slider') || request()->is('main-slider/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-image"></i>
                                    <p>Main Slider</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                                    <p>
                                        <i class="fas fa-sign-out-alt">

                                        </i>
                                        <span>Logout</span>
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>
        <?php endif; ?>

        <?php if (empty($is_loggedin)) : ?>
            <div class="content-wrapper">
                @yield('content')
            </div>
        <?php else : ?>
            @yield('content')
        <?php endif; ?>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
    <script src="{{ $start_with.'adminlte/plugins/jquery/jquery.min.js' }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/lodash.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/cleave.min.js') }}"></script>
    <script src="{{ $start_with.'adminlte/plugins/jquery-ui/jquery-ui.min.js' }}"></script>
    <script src="{{ $start_with.'adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js' }}"></script>
    <script src="{{ $start_with.'adminlte/plugins/chart.js/Chart.min.js' }}"></script>
    <script src="{{ $start_with.'adminlte/plugins/sparklines/sparkline.js' }}"></script>
    <script src="{{ $start_with.'adminlte/plugins/jqvmap/jquery.vmap.min.js' }}"></script>
    <script src="{{ $start_with.'adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js' }}"></script>
    <script src="{{ $start_with.'adminlte/plugins/jquery-knob/jquery.knob.min.js' }}"></script>
    <script src="{{ $start_with.'adminlte/plugins/moment/moment.min.js' }}"></script>
    <script src="{{ $start_with.'adminlte/plugins/daterangepicker/daterangepicker.js' }}"></script>
    <script src="{{ $start_with.'adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js' }}"></script>
    <script src="{{ $start_with.'adminlte/plugins/summernote/summernote-bs4.min.js' }}"></script>
    <script src="{{ $start_with.'adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js' }}"></script>
    <script src="{{ $start_with.'adminlte/dist/js/adminlte.js' }}"></script>
    <!-- <script src="{{ $start_with.'adminlte/dist/js/pages/dashboard.js' }}"></script> -->
    <script src="{{ $start_with.'adminlte/dist/js/demo.js' }}"></script>
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/utils.js') }}"></script>
    
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fullcalendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fullcalendar-daygrid/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fullcalendar-timegrid/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fullcalendar-bootstrap/main.min.css') }}">

    <script src="{{ asset('adminlte/plugins/fullcalendar/main.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/fullcalendar-daygrid/main.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/fullcalendar-timegrid/main.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/fullcalendar-interaction/main.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/fullcalendar-bootstrap/main.min.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            if($('input[type="file"].custom-file-input').length){
                $('input[type="file"].custom-file-input').on('change', function() {
                    //get the file name
                    var fileName = _.get($(this), '0.files.0.name', "Choose file");
                    //replace the "Choose a file" label
                    $(this).next('.custom-file-label').html(fileName);
                })
            }
        })
    </script>

    @stack('scripts')
</body>


</html>