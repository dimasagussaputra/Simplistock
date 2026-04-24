<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Simplistock - @yield('title', 'Manajemen Stok')</title>

    <!-- Bootstrap 5 CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <!-- Bootstrap Icons -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css' rel='stylesheet'>

    <style>
        body { background-color: #f8f9fa; font-family: Arial, sans-serif; }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.4rem;
            color: #fff !important;
        }

        /* NAV MENU TENGAH */
        .navbar-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 500;
            margin: 0 8px;
        }

        .navbar-nav .nav-link:hover {
            opacity: 0.8;
        }

        .dropdown-toggle {
            color: #fff !important;
        }

        .content-area { padding: 20px; }

        .card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        /* =========================
           ALERT ANIMATION (GLOBAL)
        ========================== */
        .auto-alert {
            position: fixed;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            min-width: 300px;
            max-width: 600px;
            z-index: 9999;
            transition: all 0.5s ease;
        }

        .auto-alert.showing {
            top: 20px;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class='navbar navbar-expand-lg navbar-dark bg-primary position-relative'>
    <div class='container-fluid'>

        <!-- LOGO -->
        <a class='navbar-brand' href='{{ route("dashboard") }}'>
            <i class='bi bi-boxes'></i> Simplistock
        </a>

        <!-- TOGGLER -->
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav'>
            <span class='navbar-toggler-icon'></span>
        </button>

        <div class='collapse navbar-collapse' id='navbarNav'>

            <!-- MENU TENGAH -->
            <ul class='navbar-nav navbar-center'>
                <li class='nav-item'>
                    <a class='nav-link' href='{{ route("dashboard") }}'>
                        <i class='bi bi-house'></i> Dashboard
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='{{ route("products.index") }}'>
                        <i class='bi bi-box'></i> Produk
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='{{ route("transactions.index") }}'>
                        <i class='bi bi-arrow-left-right'></i> Transaksi
                    </a>
                </li>
                @if(auth()->user()->isAdmin())
                <li class='nav-item'>
                    <a class='nav-link' href='{{ route("categories.index") }}'>
                        <i class='bi bi-tags'></i> Kategori
                    </a>
                </li>
                @endif
            </ul>

            <!-- USER MENU (KANAN) -->
            <ul class='navbar-nav ms-auto'>
                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' href='#' data-bs-toggle='dropdown'>
                        <i class='bi bi-person-circle'></i>
                        {{ auth()->user()->name }}
                        <span class='badge {{ auth()->user()->isAdmin() ? "bg-danger" : "bg-secondary" }} ms-1'>
                            {{ auth()->user()->role }}
                        </span>
                    </a>
                    <ul class='dropdown-menu dropdown-menu-end'>
                        <li>
                            <form method='POST' action='{{ route("logout") }}'>
                                @csrf
                                <button type='submit' class='dropdown-item text-danger'>
                                    <i class='bi bi-box-arrow-right'></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class='container-fluid mt-4 px-4'>

    @if(session('success'))
        <div class='alert alert-success alert-dismissible fade show auto-alert'>
            {{ session('success') }}
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        </div>
    @endif

    @if(session('error'))
        <div class='alert alert-danger alert-dismissible fade show auto-alert'>
            {{ session('error') }}
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        </div>
    @endif

    @yield('content')
</div>

<!-- JS -->
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const alerts = document.querySelectorAll('.auto-alert');

    alerts.forEach(alert => {

        // munculkan (slide down)
        setTimeout(() => {
            alert.classList.add('showing');
        }, 100);

        // auto close setelah 3 detik
        setTimeout(() => {
            alert.classList.remove('showing');

            setTimeout(() => {
                alert.remove();
            }, 500);

        }, 3000);
    });
});
</script>

</body>
</html>