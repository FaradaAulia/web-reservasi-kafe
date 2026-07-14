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
<body class="min-h-full bg-stone-950 text-stone-200 font-sans selection:bg-amber-600 selection:text-white">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 border-b border-stone-800 bg-stone-950/90 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex min-h-20 items-center justify-between gap-4 py-3">
                
                <!-- Logo -->
                <div class="flex min-w-0 items-center gap-3">
                    <a href="{{ route('customer.home') }}" class="flex min-w-0 items-center gap-3 text-amber-500 font-bold tracking-wider hover:opacity-90">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl border border-amber-500/25 bg-amber-500/10">
                            <i class="bi bi-cup-hot-fill text-xl text-amber-400"></i>
                        </span>
                        <span class="truncate text-lg sm:text-xl">AROMA KAFE</span>
                    </a>
                </div>

                <!-- Nav links -->
                <div class="hidden items-center rounded-2xl border border-stone-800 bg-stone-900/80 p-1 md:flex">
                    <a href="{{ route('customer.home') }}" class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('customer.home') ? 'bg-amber-500 text-stone-950 shadow-sm shadow-amber-950/30' : 'text-stone-300 hover:bg-stone-800 hover:text-amber-300' }}">
                        <i class="bi bi-calendar-check"></i> Reservasi Saya
                    </a>
                    <a href="{{ route('customer.reservasi.index') }}" class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('customer.reservasi.*') ? 'bg-amber-500 text-stone-950 shadow-sm shadow-amber-950/30' : 'text-stone-300 hover:bg-stone-800 hover:text-amber-300' }}">
                        <i class="bi bi-plus-circle"></i> Buat Reservasi
                    </a>
                </div>

                <!-- Actions -->
                <div class="flex shrink-0 items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs text-stone-400">Selamat datang,</p>
                        <p class="text-sm font-semibold text-stone-200">{{ Auth::user()->name }}</p>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center justify-center gap-2 rounded-2xl border border-stone-700 bg-stone-900 px-3 py-2.5 text-sm text-stone-300 transition hover:border-red-500/40 hover:bg-red-500/10 hover:text-red-300">
                            <i class="bi bi-box-arrow-right text-base"></i>
                            <span class="hidden md:inline">Keluar</span>
                        </button>
                    </form>
                </div>

            </div>

            <div class="grid grid-cols-2 gap-2 pb-3 md:hidden">
                <a href="{{ route('customer.home') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('customer.home') ? 'border-amber-500 bg-amber-500 text-stone-950' : 'border-stone-800 bg-stone-900 text-stone-300' }}">
                    <i class="bi bi-calendar-check"></i> Reservasi
                </a>
                <a href="{{ route('customer.reservasi.index') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('customer.reservasi.*') ? 'border-amber-500 bg-amber-500 text-stone-950' : 'border-stone-800 bg-stone-900 text-stone-300' }}">
                    <i class="bi bi-plus-circle"></i> Buat
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="min-h-[calc(100vh-12rem)] py-8 sm:py-10 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8">
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
    <footer class="border-t border-stone-800 bg-stone-950 py-8 text-center text-xs text-stone-500">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; {{ date('Y') }} Aroma Kafe. Semua hak cipta dilindungi.</p>
            <p class="mt-2 text-stone-600">Terima kasih telah mempercayakan reservasi meja Anda bersama kami.</p>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6282360535593?text=Halo%20Admin%20Aroma%20Kafe,%20saya%20butuh%20bantuan%20terkait%20reservasi." target="_blank" class="fixed bottom-6 right-6 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-green-500 text-white shadow-lg shadow-green-500/30 transition-transform hover:scale-110 hover:bg-green-400">
        <i class="bi bi-whatsapp text-2xl"></i>
    </a>

</body>
</html>
