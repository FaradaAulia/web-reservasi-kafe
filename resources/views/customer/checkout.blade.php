<!DOCTYPE html>
<html>
<head>

<title>Checkout</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>
<body>

<div class="container mt-4">

<h2>Checkout Reservasi</h2>

<hr>

<h4>Detail Pesanan</h4>

<table class="table">

<tr>
    <th>Menu</th>
    <th>Qty</th>
    <th>Subtotal</th>
</tr>

@foreach($reservasi->pesanan->detailPesanan as $item)

<tr>

<td>
{{ $item->menu->nama_menu }}
</td>

<td>
{{ $item->qty }}
</td>

<td>
Rp {{ number_format($item->subtotal) }}
</td>

</tr>

@endforeach

</table>

<div class="alert alert-success">

Total Bayar :

<b>
Rp {{ number_format($reservasi->total_harga) }}
</b>

</div>

<form
action="{{ route('customer.checkout.bayar', $reservasi->id) }}"
method="POST"
enctype="multipart/form-data">

@csrf

<div class="mb-3">

<label>Metode Pembayaran</label>

<select
name="metode"
class="form-control">

<option value="Transfer Bank">
Transfer Bank
</option>

<option value="QRIS">
QRIS
</option>

<option value="E-Wallet">
E-Wallet
</option>

</select>

</div>

<div class="mb-3">

<label>Upload Bukti Bayar</label>

<input
type="file"
name="bukti_bayar"
class="form-control">

</div>

<button
class="btn btn-success">

Kirim Pembayaran

</button>

</form>

</div>
<hr>

<h4>QRIS Cafe</h4>

<img
src="{{ asset('qris/qris-cafe.jpg') }}"
width="300">
</body>
</html>