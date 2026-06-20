@extends('admin.layouts.app')

@section('content')

<h2>Scan Reservasi</h2>

<form method="POST" action="{{ route('admin.scan.check') }}">

    @csrf

    <input
        type="text"
        name="kode"
        class="form-control">

    <button
        class="btn btn-primary mt-2">

        Cari

    </button>

</form>

@if(isset($reservasi))

<hr>

Nama :
{{ $reservasi->user->name }}

<br>

Status :
{{ $reservasi->status }}

@endif

@endsection