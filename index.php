<?php

require_once 'auth.php';

$page = $_GET['page']  ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Csrf Token -->

    <title>Sistem Informasi Inventaris Barang</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.min.css" integrity="sha512-jN4O0AUkRmE6Jwc8la2I5iBmS+tCDcfUd1eq8nrZIBnDKTmCp5YxxNN1/aetnAH32qT+dDbk1aGhhoaw5cJNlw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- datatables  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" />

    <!-- jquery  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- select2  -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- toastsr  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- adminlte  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css" integrity="sha512-IuO+tczf4J43RzbCMEFggCWW5JuX78IrCJRFFBoQEXNvGI6gkUw4OjuwMidiS4Lm9Q2lILzpJwZuMWuSEeT9UQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div> -->
        <nav class="main-header navbar navbar-expand navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
                <li class="nav-item">
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">

                    <div class="nav-link py-1">
                        <label class="theme-switch" for="checkbox" title="Switch Theme">
                            <input type="checkbox" id="checkbox" />
                            <div class="slider"></div>
                            <i class="fas fa-sun"></i>
                            <i class="fas fa-moon"></i>
                        </label>
                    </div>

                </li>


                <li class="dropdown mr-3">
                    <a class="dropdown-toggle font-weight-bold text-dark"  data-toggle="dropdown" href="#">
                        <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="lazy img-circle" width="40" height="40" alt="">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="navbarDropdownMenuLink">
                        <label class="font-weight-bold mb-0 text-uppercase ml-3">Account</label>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/account"><i class="fa fa-user-circle"></i> My Profile</a>
                        <a class="dropdown-item" href="/logout.php" onclick="return confirm('Anda yakin ingin keluar?')"><i class="fa fa-sign-out-alt"></i> Logout</a>
                    </div>
                </li>

            </ul>


        </nav>
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <a href="/" class="brand-link">

                <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="PBW" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">INVENTORY BARANG</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Febri Sutomo</a>
                    </div>
                </div>
                <!-- <div class="form-inline mt-2">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div> -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu">
                        <li class="nav-item">
                            <a href="/" class="nav-link <?= $page == '' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item <?= $page == 'products' || $page == 'categories' ? 'menu-open' : ''; ?>">
                            <a href="#" class="nav-link <?= $page == 'products' || $page == 'categories' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-dolly"></i>
                                <p>
                                    Persediaan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/products" class="nav-link <?= $page == 'products' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Barang</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/categories" class="nav-link <?= $page == 'categories' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kategori</p>
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="../charts/flot.html" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Penyesuaian</p>
                                    </a>
                                </li> -->
                            </ul>
                        </li>

                        <li class="nav-header">TRANSAKSI</li>
                        <li class="nav-item <?= in_array($page, array('sales', 'saleslist', 'saledetail', 'customers')) ? 'menu-open' : ''; ?>">
                            <a href="#" class="nav-link <?= in_array($page, array('sales', 'saleslist', 'customers')) ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>
                                    Penjualan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/sales" class="nav-link <?= $page == 'sales' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tambah Penjualan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/saleslist" class="nav-link <?= $page == 'saleslist' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Daftar Penjualan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/customers" class="nav-link <?= $page == 'customers' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pelanggan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item <?= in_array($page, array('purchases', 'purchaseslist', 'suppliers')) ? 'menu-open' : ''; ?>">
                            <a href="#" class="nav-link <?= in_array($page, array('purchases', 'purchaseslist', 'suppliers')) ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-shopping-bag"></i>
                                <p>
                                    Pembelian
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/purchases" class="nav-link nav-link-child <?= $page == 'purchases' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tambah Pembelian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/purchaseslist" class="nav-link nav-link-child <?= $page == 'purchaseslist' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Daftar Pembelian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/suppliers" class="nav-link nav-link-child <?= $page == 'suppliers' ? 'active' : ''; ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pemasok</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-header">LAPORAN</li>

                        <li class="nav-item">
                            <a href="/reports" class="nav-link  <?= $page == 'reports' ? 'active' : ''; ?>"">
                                <i class=" nav-icon fas fa-chart-line"></i>
                                <p>
                                    Laporan
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">PENGATURAN</li>
                        <li class="nav-item">
                            <a href="/users" class="nav-link <?= $page == 'users' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Pengaturan
                                </p>
                            </a>
                        </li>

                </nav>
            </div>
        </aside>
        <div class="content-wrapper pt-4">

            <!-- <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Data User</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                                <li class="breadcrumb-item active">Data User</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="content">
                <?php
                if (file_exists('pages/' . $page . '.php')) {
                    include 'pages/' . $page . '.php';
                } elseif ($page == '') {
                    include 'pages/dashboard.php';
                } else {
                    include 'pages/error.php';
                }
                ?>
            </div>

        </div>
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                v3.1.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.bundle.min.js" integrity="sha512-mULnawDVcCnsk9a4aG1QLZZ6rcce/jSzEGqUkeOLy0b6q0+T6syHrxlsAGH7ZVoqC93Pd0lBqd6WguPWih7VHA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/js/OverlayScrollbars.min.js" integrity="sha512-B1xv1CqZlvaOobTbSiJWbRO2iM0iii3wQ/LWnXWJJxKfvIRRJa910sVmyZeOrvI854sLDsFCuFHh4urASj+qgw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- datatable  -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>


    <!-- admin lte  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js" integrity="sha512-KBeR1NhClUySj9xBB0+KRqYLPkM6VvXiiWaSz/8LCQNdRpUm38SWUrj0ccNDNSkwCD9qPA4KobLliG26yPppJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        function rupiah(number) {
            return 'Rp' + new Intl.NumberFormat(['ban', 'id']).format(number);
        };


        var toggleSwitch = document.querySelector('.theme-switch input[type=checkbox]');
        var currentTheme = localStorage.getItem('theme');
        var mainHeader = document.querySelector('.main-header');
        var mainSidebar = document.querySelector('.main-sidebar');

        if (currentTheme) {
            if (currentTheme === 'dark') {
                if (!document.body.classList.contains('dark-mode')) {
                    document.body.classList.add("dark-mode");
                }
                if (mainHeader.classList.contains('navbar-light')) {
                    mainHeader.classList.add('navbar-dark');
                    mainHeader.classList.remove('navbar-light');
                }
                if (mainSidebar.classList.contains('sidebar-light-primary')) {
                    mainSidebar.classList.add('sidebar-dark-primary');
                    mainSidebar.classList.remove('sidebar-light-primary');
                }
                toggleSwitch.checked = true;
            }
        }

        function switchTheme(e) {
            if (e.target.checked) {
                if (!document.body.classList.contains('dark-mode')) {
                    document.body.classList.add("dark-mode");
                }
                if (mainHeader.classList.contains('navbar-light')) {
                    mainHeader.classList.add('navbar-dark');
                    mainHeader.classList.remove('navbar-light');
                }
                if (mainSidebar.classList.contains('sidebar-light-primary')) {
                    mainSidebar.classList.add('sidebar-dark-primary');
                    mainSidebar.classList.remove('sidebar-light-primary');
                }
                localStorage.setItem('theme', 'dark');
            } else {
                if (document.body.classList.contains('dark-mode')) {
                    document.body.classList.remove("dark-mode");
                }
                if (mainHeader.classList.contains('navbar-dark')) {
                    mainHeader.classList.add('navbar-light');
                    mainHeader.classList.remove('navbar-dark');
                }
                if (mainSidebar.classList.contains('sidebar-dark-primary')) {
                    mainSidebar.classList.add('sidebar-light-primary');
                    mainSidebar.classList.remove('sidebar-dark-primary');
                }
                localStorage.setItem('theme', 'light');
            }
        }

        toggleSwitch.addEventListener('change', switchTheme, false);
    </script>

    <style>
        .theme-switch {
            display: flex;
            height: 32px;
            position: relative;
            width: 62px;
        }

        .theme-switch input {
            display: none;
        }

        .slider {
            background-color: #CCC;
            border-radius: 32px;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            top: 0;
            cursor: pointer;
            transition: .4s;
        }

        .slider:before {
            content: "";
            position: absolute;
            background-color: #FFF;
            border-radius: 50%;
            bottom: 4px;
            left: 4px;
            height: 24px;
            width: 24px;
            transition: .4s;
            z-index: 421;
        }

        input:checked+.slider {
            background-color: #454d55;
        }

        input:checked+.slider:before {
            transform: translateX(30px);
            background-color: #343a40;
        }

        .theme-switch i {
            color: #FFF;
            width: 50%;
            text-align: center;
            line-height: 24px;
            padding: 0.25em;
            position: relative;
            z-index: 420;
            transition: .4s;
        }

        .theme-switch .fa-moon {
            right: 2px;
        }

        .theme-switch .fa-sun {
            left: 2px;
        }


    </style>
</body>

</html>
