<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Admin') | NhaDatVN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Admin dashboard" name="description" />
    <meta content="NhaDatVN" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('admin-assets/images/favicon.ico') }}">
    <script src="{{ asset('admin-assets/js/layout.js') }}"></script>
    <link href="{{ asset('admin-assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin-assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin-assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin-assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .app-search .form-control {
            min-width: 240px;
        }

        .status-toggle {
            position: relative;
            width: 42px;
            height: 22px;
            border: 0;
            border-radius: 999px;
            transition: all 0.2s ease;
        }

        .status-toggle::before {
            content: "";
            position: absolute;
            top: 3px;
            left: 3px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #fff;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.2);
        }

        .status-toggle.is-active {
            background: #10b981;
        }

        .status-toggle.is-inactive {
            background: #f06548;
        }

        .status-toggle.is-active::before {
            transform: translateX(20px);
        }

        .status-toggle:disabled {
            opacity: 0.6;
            cursor: wait;
        }

        .status-toggle-label {
            min-width: 44px;
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            line-height: 1;
        }

        .sort-order-input {
            width: 58px;
            min-width: 58px;
            padding-left: 8px;
            padding-right: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="{{ route('backend.admin.dashboard') }}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ asset('admin-assets/images/logo-sm.png') }}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('admin-assets/images/logo-dark.png') }}" alt="" height="17">
                                </span>
                            </a>
                            <a href="{{ route('backend.admin.dashboard') }}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ asset('admin-assets/images/logo-sm.png') }}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('admin-assets/images/logo-light.png') }}" alt="" height="17">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger material-shadow-none" id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>

                        <form class="app-search d-none d-md-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" placeholder="Search..." autocomplete="off">
                                <span class="mdi mdi-magnify search-widget-icon"></span>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="dropdown d-md-none topbar-head-dropdown header-item">
                            <button type="button" class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-search fs-22"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search...">
                                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user" src="{{ asset('admin-assets/images/users/avatar-1.jpg') }}" alt="Header Avatar">
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth()->user()->name }}</span>
                                        <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">Administrator</span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <h6 class="dropdown-header">Welcome {{ auth()->user()->name }}!</h6>
                                <a class="dropdown-item" href="{{ route('backend.users.index') }}">
                                    <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                                    <span class="align-middle">User</span>
                                </a>
                                <a class="dropdown-item" href="{{ route('backend.admin.logout') }}" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                                    <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                                    <span class="align-middle">Logout</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="app-menu navbar-menu">
            <div class="navbar-brand-box">
                <a href="{{ route('backend.admin.dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('admin-assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('admin-assets/images/logo-dark.png') }}" alt="" height="17">
                    </span>
                </a>
                <a href="{{ route('backend.admin.dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('admin-assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('admin-assets/images/logo-light.png') }}" alt="" height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu"></div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span>Menu</span></li>
                        @php
                            $menuItems = [
                                ['label' => 'Menu', 'icon' => 'ri-menu-line', 'route' => 'backend.menus.index'],
                                ['label' => 'Category', 'icon' => 'ri-list-check-2', 'route' => 'backend.categories.index'],
                                ['label' => 'Product', 'icon' => 'ri-shopping-bag-3-line', 'route' => 'backend.products.index'],
                                ['label' => 'News', 'icon' => 'ri-newspaper-line', 'route' => 'backend.news.index'],
                                ['label' => 'Setting', 'icon' => 'ri-settings-3-line', 'route' => 'backend.settings.edit'],
                                ['label' => 'User', 'icon' => 'ri-user-3-line', 'route' => 'backend.users.index'],
                            ];
                        @endphp
                        @foreach ($menuItems as $item)
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ $item['label'] === 'Menu' && request()->routeIs('backend.menus.*') ? 'active' : '' }} {{ $item['label'] === 'User' && request()->routeIs('backend.users.*') ? 'active' : '' }} {{ $item['label'] === 'Category' && request()->routeIs('backend.categories.*') ? 'active' : '' }} {{ $item['label'] === 'Product' && request()->routeIs('backend.products.*') ? 'active' : '' }} {{ $item['label'] === 'News' && request()->routeIs('backend.news.*') ? 'active' : '' }} {{ $item['label'] === 'Setting' && request()->routeIs('backend.settings.*') ? 'active' : '' }}" href="{{ $item['route'] ? route($item['route']) : '#' }}">
                                    <i class="{{ $item['icon'] }}"></i>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="sidebar-background"></div>
        </div>

        <div class="vertical-overlay"></div>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">@yield('page_title', 'Dashboard')</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('backend.admin.dashboard') }}">Admin</a></li>
                                        <li class="breadcrumb-item active">@yield('breadcrumb', 'Dashboard')</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    @yield('content')
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            {{ now()->year }} © NhaDatVN.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Admin powered by Velzon
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <form id="admin-logout-form" action="{{ route('backend.admin.logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>

    <script src="{{ asset('admin-assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
    <script src="{{ asset('admin-assets/js/customc-keditor.js') }}"></script>
    <script src="{{ asset('admin-assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('admin-assets/js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.uploadUrl = @json(route('backend.admin.uploads.editor-image'));

            function showToast(icon, title, text) {
                Swal.fire({
                    toast: true,
                    position: 'bottom-start',
                    icon: icon,
                    title: title,
                    text: text,
                    timer: 2200,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    showCloseButton: true
                });
            }

            @if (session('success'))
                showToast('success', 'Thanh cong', @json(session('success')));
            @endif

            @if (session('error'))
                showToast('error', 'Co loi xay ra', @json(session('error')));
            @endif

            @if ($errors->any())
                showToast('warning', 'Vui long kiem tra du lieu', @json(collect($errors->all())->implode(' | ')));
            @endif

            document.querySelectorAll('[data-confirm-delete]').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    var message = form.getAttribute('data-confirm-message') || 'Ban co chac muon xoa muc nay?';

                    Swal.fire({
                        icon: 'warning',
                        title: 'Xac nhan xoa',
                        text: message,
                        showCancelButton: true,
                        confirmButtonText: 'Xoa',
                        cancelButtonText: 'Huy',
                        confirmButtonColor: '#f06548',
                        cancelButtonColor: '#405189'
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            document.querySelectorAll('[data-toggle-status]').forEach(function (button) {
                button.addEventListener('click', function () {
                    var url = button.getAttribute('data-url');
                    var label = button.parentElement.querySelector('[data-status-label]');
                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    if (!url) {
                        return;
                    }

                    button.disabled = true;

                    fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                        .then(function (response) {
                            if (!response.ok) {
                                throw new Error('Toggle status failed');
                            }

                            return response.json();
                        })
                        .then(function (data) {
                            button.classList.toggle('is-active', data.is_active);
                            button.classList.toggle('is-inactive', !data.is_active);
                            button.setAttribute('aria-pressed', data.is_active ? 'true' : 'false');

                            if (label) {
                                label.textContent = data.label;
                                label.classList.toggle('text-success', data.is_active);
                                label.classList.toggle('text-danger', !data.is_active);
                            }

                            showToast('success', 'Da cap nhat', data.message);
                        })
                        .catch(function () {
                            showToast('error', 'Khong cap nhat duoc', 'Vui long thu lai.');
                        })
                        .finally(function () {
                            button.disabled = false;
                        });
                });
            });

            document.querySelectorAll('[data-update-sort-order]').forEach(function (input) {
                var submitSortOrder = function () {
                    var url = input.getAttribute('data-url');
                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    var currentValue = input.value.trim();
                    var initialValue = input.getAttribute('data-initial-value');

                    if (!url || currentValue === '' || currentValue === initialValue) {
                        if (currentValue === '') {
                            input.value = initialValue || 0;
                        }

                        return;
                    }

                    input.disabled = true;

                    fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            sort_order: Number(currentValue)
                        })
                    })
                        .then(function (response) {
                            if (!response.ok) {
                                throw new Error('Update sort order failed');
                            }

                            return response.json();
                        })
                        .then(function (data) {
                            input.value = data.sort_order;
                            input.setAttribute('data-initial-value', data.sort_order);
                            showToast('success', 'Da cap nhat', data.message);
                        })
                        .catch(function () {
                            input.value = initialValue || 0;
                            showToast('error', 'Khong cap nhat duoc', 'Vui long thu lai.');
                        })
                        .finally(function () {
                            input.disabled = false;
                        });
                };

                input.addEventListener('blur', submitSortOrder);
                input.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        input.blur();
                    }
                });
            });

            if (typeof initEditor === 'function') {
                initEditor();
            }
        });
    </script>
</body>
</html>
