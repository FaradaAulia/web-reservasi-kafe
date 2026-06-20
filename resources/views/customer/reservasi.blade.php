@extends('layouts.customer')

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">
    <!-- Step Title -->
    <div>
        <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-wide">Buat Reservasi Baru</h2>
        <p class="text-stone-400 text-sm mt-1">Isi detail jadwal, pilih meja, dan pilih menu makanan & minuman Anda.</p>
    </div>

    <!-- Form Jadwal & Cek Ketersediaan -->
    <div class="bg-stone-900 rounded-3xl border border-stone-850 p-6 shadow-xl">
        <h3 class="text-lg font-bold text-stone-200 mb-4 flex items-center gap-2">
            <i class="bi bi-clock-history text-amber-500"></i> 1. Tentukan Jadwal Reservasi
        </h3>
        
        <form action="{{ route('customer.reservasi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label for="tanggal" class="block text-xs font-semibold uppercase tracking-wider text-stone-400 mb-2">Tanggal Reservasi</label>
                <input type="date" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-stone-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-sm" id="tanggal" name="tanggal" value="{{ $tanggal ?? date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
            </div>
            
            <div>
                <label for="jam_mulai" class="block text-xs font-semibold uppercase tracking-wider text-stone-400 mb-2">Jam Mulai</label>
                <input type="time" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-stone-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-sm" id="jam_mulai" name="jam_mulai" value="{{ $jam_mulai ?? '18:00' }}" required>
            </div>

            <div>
                <label for="jam_selesai" class="block text-xs font-semibold uppercase tracking-wider text-stone-400 mb-2">Jam Selesai</label>
                <input type="time" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-stone-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-sm" id="jam_selesai" name="jam_selesai" value="{{ $jam_selesai ?? '20:00' }}" required>
            </div>

            <div>
                <button type="submit" class="w-full bg-amber-600 hover:bg-amber-500 text-white font-semibold py-3 px-6 rounded-xl text-sm transition flex items-center justify-center gap-2 shadow-lg shadow-amber-900/10">
                    <i class="bi bi-search"></i> Cek Ketersediaan Meja
                </button>
            </div>
        </form>
    </div>

    <!-- Jika Jadwal Sudah Dicek, Tampilkan Langkah Selanjutnya -->
    @if($tanggal && $jam_mulai && $jam_selesai)
        <form action="{{ auth()->check() ? route('customer.reservasi.store') : route('customer.reservasi.store.guest') }}" method="POST" id="reservationForm" class="space-y-8">
            @csrf

            @guest
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-stone-400 mb-2">Nama Pemesan</label>
                    <input id="name" name="name" type="text" required class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-stone-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-sm" value="{{ old('name') }}">
                </div>
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-stone-400 mb-2">Email</label>
                    <input id="email" name="email" type="email" required class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-stone-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-sm" value="{{ old('email') }}">
                </div>
            </div>
            @endguest

            <!-- Hidden inputs untuk menyimpan jadwal -->
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
            <input type="hidden" name="jam_mulai" value="{{ $jam_mulai }}">
            <input type="hidden" name="jam_selesai" value="{{ $jam_selesai }}">

            <!-- Section 2: Pilih Meja -->
            <div class="bg-stone-900 rounded-3xl border border-stone-850 p-6 shadow-xl">
                <h3 class="text-lg font-bold text-stone-200 mb-2 flex items-center gap-2">
                    <i class="bi bi-grid-3x3-gap text-amber-500"></i> 2. Pilih Meja Kafe
                </h3>
                <p class="text-xs text-stone-400 mb-6">{{ $message }}</p>

                @if(!$mejas->isEmpty())
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        @foreach($mejas as $meja)
                            <label class="relative block cursor-pointer group">
                                <input type="radio" name="meja_id" value="{{ $meja->id }}" class="peer sr-only" required>
                                
                                <div class="bg-stone-950 border border-stone-800 peer-checked:border-amber-500 peer-checked:bg-amber-950/20 rounded-2xl p-5 text-center transition group-hover:border-stone-700">
                                    <i class="bi bi-table text-3xl text-stone-500 peer-checked:text-amber-500 group-hover:scale-105 transition block mb-2"></i>
                                    <span class="block font-bold text-white text-base">{{ $meja->nomor_meja }}</span>
                                    <span class="text-xs text-stone-400 mt-1 block">Kapasitas: {{ $meja->kapasitas }} Orang</span>
                                </div>
                                
                                <!-- Indicator checkmark icon -->
                                <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition">
                                    <i class="bi bi-check-circle-fill text-amber-500 text-sm"></i>
                                </div>
                            </label>
                        @endforeach
                    </div>
                @else
                    <div class="bg-stone-950/50 border border-stone-850 p-6 rounded-2xl text-center text-stone-500 text-sm">
                        Silakan pilih jadwal lain untuk mencari meja yang kosong.
                    </div>
                @endif
            </div>

            <!-- Section 3: Pemesanan Menu Makanan & Minuman -->
            @if(!$mejas->isEmpty())
                <div class="bg-stone-900 rounded-3xl border border-stone-850 p-6 shadow-xl">
                    <h3 class="text-lg font-bold text-stone-200 mb-2 flex items-center gap-2">
                        <i class="bi bi-journal-richtext text-amber-500"></i> 3. Tambahkan Makanan & Minuman (Wajib)
                    </h3>
                    <p class="text-xs text-stone-400 mb-6">Pilih menu minimal 1 item. Anda wajib membayar lunas seluruh pesanan ini untuk menyelesaikan reservasi.</p>

                    <div class="space-y-8">
                        @foreach($categories as $category)
                            @if(!$category->menu->isEmpty())
                                <div>
                                    <h4 class="text-sm font-semibold uppercase tracking-wider text-amber-500 border-b border-stone-850 pb-2 mb-4">{{ $category->nama_kategori }}</h4>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($category->menu as $menu)
                                            <div class="bg-stone-950 border border-stone-850 hover:border-stone-800 p-4 rounded-2xl flex items-center gap-4 transition">
                                                
                                                <!-- Image -->
                                                <div class="shrink-0">
                                                    @if($menu->foto)
                                                        <img src="{{ asset($menu->foto) }}" alt="{{ $menu->nama_menu }}" class="w-20 h-20 object-cover rounded-xl border border-stone-800">
                                                    @else
                                                        <div class="w-20 h-20 bg-stone-900 text-stone-600 border border-stone-800 rounded-xl flex items-center justify-center text-[10px]">
                                                            No Image
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Details -->
                                                <div class="flex-grow">
                                                    <h5 class="font-bold text-white text-sm">{{ $menu->nama_menu }}</h5>
                                                    <p class="text-xs text-stone-500 mt-0.5 line-clamp-1">{{ $menu->deskripsi ?? '-' }}</p>
                                                    <p class="text-xs font-semibold text-stone-300 mt-2 font-mono" data-price="{{ intval($menu->harga) }}">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                                </div>

                                                <!-- Quantity selector spinner -->
                                                <div class="flex items-center bg-stone-900 border border-stone-800 rounded-xl p-1">
                                                    <button type="button" class="btn-qty-minus text-stone-400 hover:text-amber-500 w-8 h-8 flex items-center justify-center transition" data-menu-id="{{ $menu->id }}"><i class="bi bi-dash"></i></button>
                                                    <input type="number" name="qty[{{ $menu->id }}]" id="qty-{{ $menu->id }}" value="0" min="0" class="input-qty w-10 text-center bg-transparent border-0 focus:ring-0 text-sm font-bold text-white font-mono p-0" readonly>
                                                    <button type="button" class="btn-qty-plus text-stone-400 hover:text-amber-500 w-8 h-8 flex items-center justify-center transition" data-menu-id="{{ $menu->id }}"><i class="bi bi-plus"></i></button>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Floating Checkout Summary bar -->
                <div class="sticky bottom-6 z-40 bg-stone-900/95 border border-stone-800 rounded-3xl p-6 shadow-2xl flex flex-col sm:flex-row items-center justify-between gap-4 backdrop-blur-md">
                    <div>
                        <span class="text-xs text-stone-400 uppercase tracking-wider block">Estimasi Pembayaran</span>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-2xl font-bold text-amber-500 font-mono" id="totalPaymentDisplay">Rp 0</span>
                            <span class="text-xs text-stone-500 font-normal"> (Sudah Termasuk Meja)</span>
                        </div>
                    </div>
                    
                    <div class="w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-amber-600 hover:bg-amber-500 text-white font-bold py-3.5 px-8 rounded-2xl shadow-lg shadow-amber-900/25 transition">
                            <i class="bi bi-shield-check text-lg"></i>
                            <span>Konfirmasi & Lanjutkan Bayar</span>
                        </button>
                    </div>
                </div>
            @endif

        </form>
    @endif
</div>

<!-- Quantity & Total calculation script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qtyInputs = document.querySelectorAll('.input-qty');
        const totalPaymentDisplay = document.getElementById('totalPaymentDisplay');
        
        // Plus Quantity button click handler
        document.querySelectorAll('.btn-qty-plus').forEach(button => {
            button.addEventListener('click', function() {
                const menuId = this.getAttribute('data-menu-id');
                const input = document.getElementById(`qty-${menuId}`);
                let value = parseInt(input.value) || 0;
                input.value = value + 1;
                calculateTotal();
            });
        });

        // Minus Quantity button click handler
        document.querySelectorAll('.btn-qty-minus').forEach(button => {
            button.addEventListener('click', function() {
                const menuId = this.getAttribute('data-menu-id');
                const input = document.getElementById(`qty-${menuId}`);
                let value = parseInt(input.value) || 0;
                if (value > 0) {
                    input.value = value - 1;
                    calculateTotal();
                }
            });
        });

        // Calculate total function
        function calculateTotal() {
            let total = 0;
            
            qtyInputs.forEach(input => {
                const qty = parseInt(input.value) || 0;
                if (qty > 0) {
                    const priceElement = input.closest('.flex').previousElementSibling.querySelector('[data-price]');
                    const price = parseFloat(priceElement.getAttribute('data-price')) || 0;
                    total += (price * qty);
                }
            });

            // Format total rupiah
            const formattedTotal = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(total);

            totalPaymentDisplay.textContent = formattedTotal;
        }

        // Form submission validator
        const form = document.getElementById('reservationForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                let totalQty = 0;
                qtyInputs.forEach(input => {
                    totalQty += (parseInt(input.value) || 0);
                });

                if (totalQty === 0) {
                    e.preventDefault();
                    alert('Maaf, Anda wajib memesan minimal 1 menu makanan atau minuman untuk melakukan reservasi meja!');
                }
            });
        }
    });
</script>
@endsection
