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
    <!-- SweetAlert2 CSS -->
    <link href='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css' rel='stylesheet'>

    <style>
        body { 
            background-color: #f8f9fa; 
            font-family: Arial, sans-serif; 
            padding-top: 80px;
            overflow-y: scroll;
        }
        .navbar-brand { font-weight: bold; font-size: 1.4rem; color: #fff !important; }
        
        /* Centered Menu - Only for Desktop */
        @media (min-width: 992px) {
            .navbar-center { position: absolute; left: 50%; transform: translateX(-50%); }
        }
        
        .navbar-nav .nav-link { color: #fff !important; font-weight: 500; margin: 0 8px; }
        .navbar-nav .nav-link.active { font-weight: 700 !important; border-bottom: 2px solid rgba(255,255,255,0.9); padding-bottom: 2px; }
        .navbar-nav .nav-link:hover:not(.active) { opacity: 0.8; }
        .navbar-nav .nav-link { transition: border-bottom 0.2s, opacity 0.2s; }
        .dropdown-toggle { color: #fff !important; }
        .content-area { padding: 20px; }
        .card { border-radius: 10px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }

        /* ALERT ANIMATION (error only) */
        .auto-alert {
            position: fixed; top: -100px; left: 50%; transform: translateX(-50%);
            min-width: 300px; max-width: 600px; z-index: 9999; transition: all 0.5s ease;
        }
        .auto-alert.showing { top: 85px; }

        /* CONFIRM MODAL */
        #confirmModal .modal-content { border: none; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); overflow: hidden; }
        #confirmModal .modal-header { background: linear-gradient(135deg, #ff4757, #c0392b); color: #fff; border-bottom: none; padding: 20px 24px 16px; }
        #confirmModal .modal-header .modal-title { font-weight: 700; font-size: 1.15rem; display: flex; align-items: center; gap: 8px; }
        #confirmModal .modal-header .btn-close { filter: invert(1) brightness(2); }
        #confirmModal .modal-body { padding: 24px; font-size: 0.97rem; color: #444; line-height: 1.6; }
        #confirmModal .modal-icon { width: 64px; height: 64px; border-radius: 50%; background: #fff3f3; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
        #confirmModal .modal-icon i { font-size: 2rem; color: #e74c3c; }
        #confirmModal .modal-footer { border-top: 1px solid #f0f0f0; padding: 16px 24px; gap: 10px; }
        #confirmModal .btn-cancel { border-radius: 8px; padding: 8px 22px; font-weight: 600; border: 2px solid #dee2e6; background: #fff; color: #555; transition: all 0.2s; }
        #confirmModal .btn-cancel:hover { background: #f8f9fa; border-color: #adb5bd; color: #333; }
        #confirmModal .btn-confirm { border-radius: 8px; padding: 8px 22px; font-weight: 700; border: none; transition: all 0.2s; }
        #confirmModal .btn-confirm.danger { background: linear-gradient(135deg, #ff4757, #c0392b); color: #fff; }
        #confirmModal .btn-confirm.danger:hover { background: linear-gradient(135deg, #c0392b, #922b21); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(192,57,43,0.4); }
        #confirmModal .btn-confirm.warning { background: linear-gradient(135deg, #f39c12, #e67e22); color: #fff; }
        #confirmModal .btn-confirm.warning:hover { background: linear-gradient(135deg, #e67e22, #ca6f1e); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(230,126,34,0.4); }

        /* MODERN PAGINATION */
        .pagination-modern { margin-bottom: 50px; }
        .pagination-modern .pagination { margin-bottom: 0; display: flex; gap: 8px; }
        .pagination-modern .page-item .page-link { border: none; background: #fff; color: #555; padding: 10px 20px; border-radius: 12px !important; font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); display: flex; align-items: center; justify-content: center; min-width: 45px; }
        .pagination-modern .page-item.active .page-link { background: linear-gradient(135deg, #4834d4, #686de0); color: #fff !important; box-shadow: 0 10px 20px rgba(72, 52, 212, 0.25); transform: translateY(-2px) scale(1.05); }
        .pagination-modern .page-item:not(.active):not(.disabled) .page-link:hover { background-color: #fff; color: #4834d4; transform: translateY(-3px); box-shadow: 0 8px 15px rgba(0,0,0,0.1); }
        .pagination-modern .page-item.disabled .page-link { background: #f8f9fa; color: #bbb; box-shadow: none; opacity: 0.7; }
        .pagination-info { font-weight: 500; letter-spacing: 0.3px; }

        /* Responsive spacing adjustments */
        @media (max-width: 768px) {
            body { padding-top: 70px; }
            .container-fluid { px-3 !important; }
            h4 { font-size: 1.25rem; }
            .navbar-brand { font-size: 1.2rem; }
            .card-body { padding: 1rem; }
        }

        /* Responsive Table fix */
        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        @media (max-width: 991px) {
            .table-responsive table {
                min-width: 750px;
            }
            .table th, .table td {
                white-space: nowrap;
            }
        }
        @media (max-width: 576px) {
            .table th, .table td { font-size: 0.85rem; padding: 0.5rem; }
            .badge { font-size: 0.75rem; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class='navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow-sm'>
    <div class='container-fluid'>
        <a class='navbar-brand' href='{{ route("dashboard") }}'>
            <i class='bi bi-boxes'></i> Simplistock
        </a>
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarNav'>
            <ul class='navbar-nav navbar-center'>
                <li class='nav-item'>
                    <a class='nav-link {{ request()->routeIs("dashboard") ? "active" : "" }}' href='{{ route("dashboard") }}'>
                        <i class='bi bi-house'></i> Dashboard
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link {{ request()->routeIs("products.*") ? "active" : "" }}' href='{{ route("products.index") }}'>
                        <i class='bi bi-box'></i> Produk
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link {{ request()->routeIs("transactions.*") ? "active" : "" }}' href='{{ route("transactions.index") }}'>
                        <i class='bi bi-arrow-left-right'></i> Transaksi
                    </a>
                </li>
                @if(auth()->user()->isAdmin())
                <li class='nav-item'>
                    <a class='nav-link {{ request()->routeIs("categories.*") ? "active" : "" }}' href='{{ route("categories.index") }}'>
                        <i class='bi bi-tags'></i> Kategori
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link {{ request()->routeIs("trash.*") ? "active" : "" }}' href='{{ route("trash.index") }}'>
                        <i class='bi bi-trash3'></i> Data Terhapus
                    </a>
                </li>
                @endif
            </ul>
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
                                <button type='button' class='dropdown-item text-danger'
                                    data-confirm='Anda akan keluar dari aplikasi Simplistock. Sesi Anda akan dihentikan.'
                                    data-confirm-title='Konfirmasi Keluar'
                                    data-confirm-ok='Logout Sekarang'
                                    data-confirm-type='warning'
                                    data-confirm-icon='bi-box-arrow-right'>
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
<div class='container-fluid mt-3 mt-md-4 px-3 px-md-4'>

    {{-- Error tetap pakai Bootstrap slide alert --}}
    @if(session('error'))
        <div class='alert alert-danger alert-dismissible fade show auto-alert'>
            {{ session('error') }}
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        </div>
    @endif

    @yield('content')
</div>

<!-- GLOBAL CONFIRMATION MODAL -->
<div class='modal fade' id='confirmModal' tabindex='-1' aria-labelledby='confirmModalLabel' aria-hidden='true' data-bs-backdrop='static'>
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='confirmModalLabel'>
                    <i class='bi bi-exclamation-triangle-fill'></i>
                    <span id='confirmModalTitle'>Konfirmasi Tindakan</span>
                </h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body text-center'>
                <div class='modal-icon'>
                    <i class='bi' id='confirmModalIcon'></i>
                </div>
                <p class='mb-0' id='confirmModalMessage'>Apakah Anda yakin?</p>
            </div>
            <div class='modal-footer justify-content-center'>
                <button type='button' class='btn btn-cancel' data-bs-dismiss='modal' id='confirmModalCancelBtn'>
                    <i class='bi bi-x-lg me-1'></i>Batal
                </button>
                <button type='button' class='btn btn-confirm danger' id='confirmModalOkBtn'>
                    <i class='bi bi-check-lg me-1'></i><span id='confirmModalOkLabel'>Konfirmasi</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
<!-- SweetAlert2 JS -->
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    /* ---- SweetAlert2 untuk session('success') ---- */
    @if(session('success'))
    Swal.fire({
        title: 'Berhasil!',
        text: @json(session('success')),
        icon: 'success',
        confirmButtonText: 'Oke',
        confirmButtonColor: '#0d6efd',
        timer: 4000,
        timerProgressBar: true,
    });
    @endif

    /* ---- Auto-slide untuk error alert ---- */
    const alerts = document.querySelectorAll('.auto-alert');
    alerts.forEach(alert => {
        setTimeout(() => alert.classList.add('showing'), 100);
        setTimeout(() => {
            alert.classList.remove('showing');
            setTimeout(() => alert.remove(), 500);
        }, 4000);
    });

    /* ---- Global Confirmation Modal ---- */
    window.confirmModalObj = new bootstrap.Modal(document.getElementById('confirmModal'));
    const modalTitle     = document.getElementById('confirmModalTitle');
    const modalMessage   = document.getElementById('confirmModalMessage');
    const modalIcon      = document.getElementById('confirmModalIcon');
    const modalOkBtn     = document.getElementById('confirmModalOkBtn');
    const modalOkLabel   = document.getElementById('confirmModalOkLabel');
    const modalCancelBtn = document.getElementById('confirmModalCancelBtn');

    let pendingForm = null;
    let pendingUrl  = null;

    window.showConfirm = function(options) {
        pendingForm = options.form || null;
        pendingUrl  = options.url  || null;

        modalTitle.textContent   = options.title   || 'Konfirmasi Tindakan';
        modalMessage.innerHTML   = options.message || 'Apakah Anda yakin?';
        modalOkLabel.textContent = options.okLabel || 'Konfirmasi';
        modalIcon.className      = 'bi ' + (options.icon || (options.type === 'danger' ? 'bi-trash3-fill' : 'bi-archive-fill'));

        modalOkBtn.className = 'btn btn-confirm ' + (options.type || 'danger');

        const headerIcon = document.querySelector('#confirmModalLabel i');
        const header     = document.querySelector('#confirmModal .modal-header');
        
        if (options.type === 'warning') {
            headerIcon.className = 'bi bi-exclamation-triangle-fill';
            header.style.background = 'linear-gradient(135deg, #f39c12, #e67e22)';
        } else if (options.type === 'danger') {
            headerIcon.className = 'bi bi-exclamation-triangle-fill';
            header.style.background = 'linear-gradient(135deg, #ff4757, #c0392b)';
        } else {
            headerIcon.className = 'bi bi-info-circle-fill';
            header.style.background = 'linear-gradient(135deg, #3498db, #2980b9)';
        }

        window.confirmModalObj.show();
    };

    document.querySelectorAll('[data-confirm]').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            window.showConfirm({
                form:    this.closest('form'),
                url:     this.getAttribute('href'),
                title:   this.dataset.confirmTitle,
                message: this.dataset.confirm,
                okLabel: this.dataset.confirmOk,
                type:    this.dataset.confirmType,
                icon:    this.dataset.confirmIcon
            });
        });
    });

    modalOkBtn.addEventListener('click', function () {
        window.confirmModalObj.hide();
        if (pendingForm) {
            pendingForm.submit();
            pendingForm = null;
        } else if (pendingUrl) {
            window.location.href = pendingUrl;
            pendingUrl = null;
        }
    });

    document.getElementById('confirmModal').addEventListener('hidden.bs.modal', function () {
        pendingForm = null;
        pendingUrl  = null;
    });

    /* ---- Auto-select numeric input on focus ---- */
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('focus', function() {
            this.select();
        });
    });

    /* ---- Disable Browser Back Button ---- */
    window.history.pushState(null, null, window.location.href);
    window.onpopstate = function () {
        window.history.pushState(null, null, window.location.href);
    };

    /* ---- Force Reload on Back (Anti-Cache) ---- */
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
});
</script>

@stack('scripts')
</body>
</html>