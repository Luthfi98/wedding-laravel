@php
    $menuModel = new \App\Models\Menu();
    $permissions = Auth::user()->roles->first()->permissions;
    $permissions = $permissions->pluck('id')->toArray();
    $menus = $menuModel::whereHas('permissions', function($permission) use ($permissions) {
        $permission->whereIn('id', $permissions);
    })
    ->with(['children' => function($query) use ($permissions) {
        $query->whereHas('permissions', function($permission) use ($permissions) {
            $permission->whereIn('id', $permissions);
        });
    }])
    ->where('parent_id', null)
    ->orderBy('order')
    ->get();
@endphp


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ $title??'Starter Template' }} - Modern Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/datatable-theme.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <!-- DataTables Responsive -->
    <link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
@stack('styles')

</head>
<body>
  <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
            <div class="d-flex align-items-center">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?w=32&h=32&fit=crop" alt="Logo" class="me-2">
                    <span>Dashboard</span>
                </a>
                <button class="btn btn-link text-dark me-3 d-lg-none" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <button class="btn btn-link text-dark me-3 d-none d-lg-block" id="desktopSidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=32&h=32&fit=crop" class="profile-img me-2" alt="Profile">
                        <span>John Doe</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
                <!-- Theme Toggle Buttons -->
                <div class="theme-toggle-group ms-3">
                    <button class="btn btn-outline-primary btn-sm" id="lightModeBtn" title="Light Mode">
                        <i class="bi bi-sun-fill"></i>
                    </button>
                    <button class="btn btn-outline-primary btn-sm" id="darkModeBtn" title="Dark Mode">
                        <i class="bi bi-moon-fill"></i>
                    </button>
                </div>
            </div>
    </div>
  </nav>

  <!-- Sidebar -->
    <div class="sidebar">
        <div class="nav flex-column">
            <div class="submenu-label">Main Menu</div>

           @foreach ($menus as $menu)
                @php
                    // Cek apakah salah satu submenu aktif
                    $isChildActive = false;
                    foreach ($menu->children as $child) {
                        if ($child->route) {
                            $routeArray = explode('.', $child->route);
                            if (request()->routeIs($routeArray[0] . '*')) {
                                $isChildActive = true;
                                break;
                            }
                        }
                    }
                @endphp

                @if ($menu->children->count() > 0)
                    <a class="nav-link {{ $isChildActive ? 'active' : '' }}" data-bs-toggle="collapse" href="#{{ $menu->id }}" aria-expanded="{{ $isChildActive ? 'true' : 'false' }}">
                        <i class="{{ $menu->icon }}"></i>
                        <span>{{ __($menu->name) }}</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse {{ $isChildActive ? 'show' : '' }}" id="{{ $menu->id }}">
                        <div class="nav flex-column submenu">
                            @foreach ($menu->children as $child)
                                @php
                                    $routeArray = explode('.', $child->route);
                                    $isActive = request()->routeIs($routeArray[0] . '*');
                                @endphp
                                <a class="nav-link {{ $isActive ? 'active' : '' }}" href="{{ $child->route ? route($child->route) : '#' }}">
                                    <i class="{{ $child->icon }}"></i>
                                    <span>{{ __($child->name) }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a class="nav-link {{ request()->routeIs($menu->route) ? 'active' : '' }}" href="{{ $menu->route ? route($menu->route) : '#' }}">
                        <i class="{{ $menu->icon }}"></i>
                        <span>{{ __($menu->name) }}</span>
                    </a>
                @endif
            @endforeach
        </div>
  </div>

  <!-- Add overlay div after sidebar -->
  <div class="sidebar-overlay"></div>

  <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
    
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        function deleteData(obj) {
            const id = $(obj).data('id');
            const route = $(obj).data('route');
            const redirect = $(obj).data('redirect');
            const dt = $(obj).data('dt');

            if (!id || !route) {
                Swal.fire('Error', 'ID atau route tidak ditemukan', 'error');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: route,
                        type: 'DELETE',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                response.message || 'Data has been deleted.',
                                'success'
                            );
                            if (dt) {
                                $(`#${dt}`).DataTable().ajax.reload();
                            } else if (redirect) {
                                window.location.href = redirect;
                            }
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON?.message || 'Failed to delete data.',
                                'error'
                            );
                        }
                    });
                }
            });
        }

        function showToast(message, type = 'success') {
            swal.fire({
                icon: type,
                title: type === 'success' ? 'Success!' : 'Error!',
                text: message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                width: '350px'
            })
        }

    </script>

    @if (session()->has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                width: '350px'
            });
        </script>
    @endif

    @if (session()->has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                width: '350px'
            });
        </script>
    @endif
    
    <!-- Initialize Select2 -->
    <script>
        $(document).ready(function() {
            // Initialize all select elements with class 'select2'
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        });
    </script>
</body>
</html>
