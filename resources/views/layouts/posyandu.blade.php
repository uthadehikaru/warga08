<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Posyandu ILP Melati - {{ config('app.name' )}}</title>
        <link rel="icon" href="{{ asset('posyandu.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        <div class="drawer">
            <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content flex flex-col">
                <!-- Navbar -->
                <div class="navbar bg-base-300 w-full">
                    <div class="mx-2 flex-1 px-2"><a href="/" class="flex gap-2"><img src="{{ asset('posyandu.png') }}" width="30px" /> Posyandu ILP Melati</a></div>
                    <div class="flex-none">
                        @auth
                        <a href="{{ route('posyandu.logout') }}" class="btn btn-sm">
                            <img src="{{ asset('images/logout.png') }}" class="w-6 h-6" />
                        </a>
                        @endauth
                    </div>
                </div>
                <!-- Page content here -->
                @yield('content')
            </div>
        </div>
    </body>
</html>
