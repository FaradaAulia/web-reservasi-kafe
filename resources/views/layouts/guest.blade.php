<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-stone-200 antialiased bg-stone-950 selection:bg-amber-600 selection:text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center py-12 sm:py-16 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-stone-900 via-stone-950 to-stone-950 px-4 relative overflow-hidden">
            
            <!-- Dekorasi Latar Belakang -->
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-amber-600/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute top-40 -left-40 w-72 h-72 bg-rose-600/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="mb-8 text-center relative z-10">
                <a href="/" wire:navigate class="inline-flex flex-col items-center gap-4 text-amber-500 font-bold tracking-widest hover:opacity-90 transition">
                    <span class="flex h-16 w-16 items-center justify-center rounded-2xl border border-amber-500/30 bg-amber-500/10 shadow-lg shadow-amber-900/20 backdrop-blur-md">
                        <!-- Icon Cup Hot (Bootstrap Icon) -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-cup-hot-fill text-amber-400" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M.5 6a.5.5 0 0 0-.488.608l1.652 7.434A2.5 2.5 0 0 0 4.104 16h5.792a2.5 2.5 0 0 0 2.44-1.958l.131-.59a3 3 0 0 0 1.3-5.854l.221-.99A.5.5 0 0 0 13.5 6H.5ZM13 12.5a2.01 2.01 0 0 1-.316-.025l.867-3.898A2.001 2.001 0 0 1 13 12.5"/>
                          <path d="m4.4.8-.003.004-.014.019a4 4 0 0 0-.204.31 2 2 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.6.6 0 0 0 .091.248c.075.114.163.231.25.348.428.577.927 1.254.927 2.298 0 1.044-.499 1.72-.927 2.298-.086.117-.175.234-.25.348a.6.6 0 0 0-.091.248c.003.011.011.043.037.103a2 2 0 0 0 .141.267c.064.103.136.205.204.31.01.014.011.018.014.019l.003.004a.26.26 0 0 0 .252.07c.08-.02.158-.088.243-.19.168-.201.378-.52.545-.96.25-.662.4-1.488.4-2.528s-.15-1.866-.4-2.528c-.167-.44-.377-.759-.545-.96-.085-.102-.163-.17-.243-.19a.26.26 0 0 0-.252.07zm2.5 0-.003.004-.014.019a4 4 0 0 0-.204.31 2 2 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.6.6 0 0 0 .091.248c.075.114.163.231.25.348.428.577.927 1.254.927 2.298 0 1.044-.499 1.72-.927 2.298-.086.117-.175.234-.25.348a.6.6 0 0 0-.091.248c.003.011.011.043.037.103a2 2 0 0 0 .141.267c.064.103.136.205.204.31.01.014.011.018.014.019l.003.004a.26.26 0 0 0 .252.07c.08-.02.158-.088.243-.19.168-.201.378-.52.545-.96.25-.662.4-1.488.4-2.528s-.15-1.866-.4-2.528c-.167-.44-.377-.759-.545-.96-.085-.102-.163-.17-.243-.19a.26.26 0 0 0-.252.07zm2.5 0-.003.004-.014.019a4 4 0 0 0-.204.31 2 2 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.6.6 0 0 0 .091.248c.075.114.163.231.25.348.428.577.927 1.254.927 2.298 0 1.044-.499 1.72-.927 2.298-.086.117-.175.234-.25.348a.6.6 0 0 0-.091.248c.003.011.011.043.037.103a2 2 0 0 0 .141.267c.064.103.136.205.204.31.01.014.011.018.014.019l.003.004a.26.26 0 0 0 .252.07c.08-.02.158-.088.243-.19.168-.201.378-.52.545-.96.25-.662.4-1.488.4-2.528s-.15-1.866-.4-2.528c-.167-.44-.377-.759-.545-.96-.085-.102-.163-.17-.243-.19a.26.26 0 0 0-.252.07z"/>
                        </svg>
                    </span>
                    <span class="text-2xl sm:text-3xl font-extrabold uppercase drop-shadow-md">Aroma Kafe</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-6 py-10 sm:px-10 sm:py-12 bg-stone-900/80 backdrop-blur-xl border border-stone-800 shadow-2xl overflow-hidden sm:rounded-[2rem] relative z-10">
                {{ $slot }}
            </div>
            
            <p class="mt-10 text-xs text-stone-600 font-medium relative z-10">&copy; {{ date('Y') }} Aroma Kafe. Semua hak cipta dilindungi.</p>
        </div>
    </body>
</html>
