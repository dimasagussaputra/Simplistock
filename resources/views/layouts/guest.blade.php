<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Simplistock') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <script>
            // Anti Back Button Script (Lebih Agresif)
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
        </script>

        <!-- Splash Screen Overlay -->
        <div id="splash-screen">
            <div class="splash-content">
                <div class="splash-logo">
                    <i class="bi bi-boxes"></i>
                </div>
                <h1 class="splash-title">Simplistock</h1>
                
                <div class="loading-container">
                    <div class="progress-bar">
                        <div class="progress-fill" id="progress-fill"></div>
                    </div>
                    <div class="percentage" id="percentage">0%</div>
                </div>
            </div>
        </div>

        <style>
            #splash-screen {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, #0d6efd 0%, #084298 100%);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
                transition: opacity 1s ease, visibility 1s;
            }

            .splash-content {
                text-align: center;
                color: white;
                width: 300px;
                animation: fadeInUp 1s ease-out;
            }

            .splash-logo {
                font-size: 80px;
                margin-bottom: 10px;
                animation: pulse 2s infinite ease-in-out;
            }

            .splash-title {
                font-size: 28px;
                font-weight: 800;
                letter-spacing: 2px;
                margin-bottom: 40px;
                text-shadow: 0 4px 10px rgba(0,0,0,0.2);
            }

            .loading-container {
                width: 100%;
                background: rgba(255, 255, 255, 0.1);
                padding: 20px;
                border-radius: 20px;
                backdrop-filter: blur(5px);
            }

            .progress-bar {
                width: 100%;
                height: 6px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 10px;
                overflow: hidden;
                margin-bottom: 10px;
            }

            .progress-fill {
                width: 0%;
                height: 100%;
                background: white;
                box-shadow: 0 0 15px rgba(255,255,255,0.8);
                transition: width 0.1s linear;
            }

            .percentage {
                font-size: 1.2rem;
                font-weight: 700;
                font-family: monospace;
            }

            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }

            #splash-screen.fade-out {
                opacity: 0;
                visibility: hidden;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const splash = document.getElementById('splash-screen');
                const progressFill = document.getElementById('progress-fill');
                const percentageText = document.getElementById('percentage');
                
                // Cek apakah splash screen sudah pernah ditampilkan di sesi ini
                if (sessionStorage.getItem('splashShown')) {
                    splash.style.display = 'none';
                    return;
                }

                let progress = 0;
                const duration = 1500; // 1.5 detik total loading
                const interval = 30; // Update setiap 30ms
                const step = 100 / (duration / interval);

                const timer = setInterval(() => {
                    progress += step;
                    if (progress >= 100) {
                        progress = 100;
                        clearInterval(timer);
                        
                        // Tandai splash sudah ditampilkan
                        sessionStorage.setItem('splashShown', 'true');
                        
                        setTimeout(() => {
                            splash.classList.add('fade-out');
                        }, 500);
                    }
                    
                    const roundedProgress = Math.floor(progress);
                    progressFill.style.width = roundedProgress + '%';
                    percentageText.textContent = roundedProgress + '%';
                }, interval);
            });
        </script>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="auth-card">
                {{ $slot }}
            </div>
        </div>

        <style>
            .auth-card {
                width: 100%;
                max-width: 450px;
                margin-top: 1.5rem;
                padding: 2.5rem 2rem;
                background-color: white;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
                overflow: hidden;
                border-radius: 20px;
                border: 1px solid rgba(0,0,0,0.05);
                animation: fadeInUp 0.8s ease-out;
            }
        </style>
    </body>
</html>
