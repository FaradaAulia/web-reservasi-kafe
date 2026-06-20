<!DOCTYPE html>
<html lang="id" class="h-full bg-stone-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reservasi Meja Online - Cafe Premium</title>
    
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/css/customer-custom.css', 'resources/js/app.js'])
</head>
<body class="h-full text-stone-200 font-sans flex flex-col justify-between selection:bg-amber-600 selection:text-white">

    <!-- Navbar -->
    <nav class="bg-stone-900/80 backdrop-blur-md border-b border-stone-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('customer.home') }}" class="flex items-center gap-2 text-amber-500 font-bold text-xl tracking-wider hover:opacity-90">
                        <i class="bi bi-cup-hot-fill text-2xl text-amber-500"></i>
                        <span>AROMA KAFE</span>
                    </a>
                </div>

                <!-- Nav links -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('customer.home') }}" class="text-stone-300 hover:text-amber-500 font-medium transition {{ request()->routeIs('customer.home') ? 'text-amber-500 border-b-2 border-amber-500 pb-1' : '' }}">
                        <i class="bi bi-calendar-check mr-1"></i> Reservasi Saya
                    </a>
                    <a href="{{ route('customer.reservasi.index') }}" class="text-stone-300 hover:text-amber-500 font-medium transition {{ request()->routeIs('customer.reservasi.*') ? 'text-amber-500 border-b-2 border-amber-500 pb-1' : '' }}">
                        <i class="bi bi-plus-circle mr-1"></i> Buat Reservasi
                    </a>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs text-stone-400">Selamat datang,</p>
                        <p class="text-sm font-semibold text-stone-200">{{ Auth::user()->name }}</p>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-stone-800 hover:bg-stone-700 text-stone-300 hover:text-red-400 p-2.5 rounded-xl border border-stone-700 transition flex items-center justify-center gap-2 text-sm">
                            <i class="bi bi-box-arrow-right text-base"></i>
                            <span class="hidden md:inline">Keluar</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow py-8 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Session Alerts -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-950/50 border border-emerald-500/30 text-emerald-300 p-4 rounded-2xl flex items-start gap-3 shadow-lg">
                <i class="bi bi-check-circle-fill text-xl text-emerald-400 mt-0.5"></i>
                <div>
                    <h4 class="font-semibold text-emerald-200">Berhasil!</h4>
                    <p class="text-sm mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-6 bg-rose-950/50 border border-rose-500/30 text-rose-300 p-4 rounded-2xl flex items-start gap-3 shadow-lg">
                <i class="bi bi-exclamation-triangle-fill text-xl text-rose-400 mt-0.5"></i>
                <div>
                    <h4 class="font-semibold text-rose-200">Error!</h4>
                    <p class="text-sm mt-0.5">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-stone-900 border-t border-stone-850 py-8 text-center text-xs text-stone-500">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; {{ date('Y') }} Aroma Kafe. Semua hak cipta dilindungi.</p>
            <p class="mt-2 text-stone-600">Terima kasih telah mempercayakan reservasi meja Anda bersama kami.</p>
        </div>
    </footer>

</body>
</html>
