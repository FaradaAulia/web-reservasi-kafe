@extends('admin.layouts.app')

@section('content')

<h2>Dashboard Admin</h2>

<div class="row">

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                Total Menu
                <h3>{{ $totalMenu }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                Total Meja
                <h3>{{ $totalMeja }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                Total Reservasi
                <h3>{{ $totalReservasi }}</h3>
            </div>
        </div>
    </div>

</div>

@endsection