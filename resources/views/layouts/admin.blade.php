<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('head-scripts')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="sidebar">
                <a class="navbar-brand" href="#"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="nav-container">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-house-door"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="managementMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-gear"></i> Management
                                </a>
                                <div class="dropdown-menu" aria-labelledby="managementMenu" id="managementSubmenu">
                                    <a class="dropdown-item" href="{{ route('admin.product.index') }}">
                                        <i class="bi bi-box"></i> Product
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.category.index') }}">
                                        <i class="bi bi-tags"></i> Category
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.user.index') }}">
                                    <i class="bi bi-person"></i> User Management
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.orders.index') }}">
                                    <i class="bi bi-basket"></i> Order Management
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.statistics.index') }}">
                                    <i class="bi bi-bar-chart"></i> Statistics
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Main Content -->
            <main role="main" class="col-md-9 ms-sm-auto col-lg-10 px-4">
                @yield('content')
            </main>
        </div>
    </div>
    @yield('scripts')
</body>
</html>
