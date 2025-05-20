<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="theme-color" content="#2d4724">

        <title>@yield('title', config('app.name'))</title>
        <link rel="icon" href="{{ asset('posyandu.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            body {
                min-height: 100vh;
                /* mobile viewport bug fix */
                min-height: -webkit-fill-available;
            }
            html {
                height: -webkit-fill-available;
            }
            .input-wrapper {
                position: relative;
                padding-bottom: env(safe-area-inset-bottom);
            }
        </style>

        @stack('styles')
    </head>
    <body>
        <!-- Page content here -->
        @yield('main')

        <script>
            // Handle Android WebView keyboard
            let viewheight = window.innerHeight;
            let viewwidth = window.innerWidth;
            let viewport = document.querySelector("meta[name=viewport]");
            viewport.setAttribute("content", "height=" + viewheight + ", width=" + viewwidth + ", initial-scale=1.0");

            // Detect virtual keyboard
            const originalHeight = window.innerHeight;
            window.addEventListener('resize', () => {
                const currentHeight = window.innerHeight;
                if (currentHeight < originalHeight) {
                    // Keyboard is showing
                    document.body.style.height = `${currentHeight}px`;
                    // Scroll to active input
                    if (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA') {
                        setTimeout(() => {
                            document.activeElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }, 100);
                    }
                } else {
                    // Keyboard is hidden
                    document.body.style.height = '100vh';
                }
            });

            // Prevent bounce scrolling on iOS
            document.body.addEventListener('touchmove', function(e) {
                if (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA') {
                    e.preventDefault();
                }
            }, { passive: false });
        </script>

        @stack('scripts')
    </body>
</html>
