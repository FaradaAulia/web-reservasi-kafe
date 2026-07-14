<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    $destination = Auth::user()->role === 'admin'
        ? route('admin.dashboard', absolute: false)
        : route('customer.home', absolute: false);

    $this->redirect($destination);
};

?>

<div class="space-y-6">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-white tracking-wide">Selamat Datang Kembali</h2>
        <p class="text-stone-400 text-sm mt-2">Silakan masuk ke akun Anda untuk melanjutkan reservasi.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit.prevent="login" class="space-y-5">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-stone-400 mb-2">{{ __('Email') }}</label>
            <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username" 
                class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-stone-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-sm transition placeholder:text-stone-600" placeholder="nama@email.com">
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-stone-400 mb-2">{{ __('Password') }}</label>
            <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password" 
                class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-stone-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-sm transition placeholder:text-stone-600" placeholder="••••••••">
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-2">
            <label for="remember" class="inline-flex items-center cursor-pointer group">
                <input wire:model="form.remember" id="remember" type="checkbox" name="remember" 
                    class="rounded bg-stone-950 border-stone-700 text-amber-500 shadow-sm focus:ring-amber-500/50 cursor-pointer">
                <span class="ms-2 text-sm text-stone-400 group-hover:text-stone-300 transition">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-amber-500 hover:text-amber-400 font-medium transition" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-amber-600 hover:bg-amber-500 text-stone-950 font-bold py-3.5 px-4 rounded-xl text-sm transition shadow-lg shadow-amber-900/20">
                <i class="bi bi-box-arrow-in-right"></i> {{ __('Masuk') }}
            </button>
        </div>
        
        @if (Route::has('register'))
            <p class="text-center text-sm text-stone-400 mt-6">
                Belum punya akun? 
                <a class="text-amber-500 hover:text-amber-400 font-semibold transition" href="{{ route('register') }}" wire:navigate>
                    {{ __('Daftar sekarang') }}
                </a>
            </p>
        @endif
    </form>
</div>
