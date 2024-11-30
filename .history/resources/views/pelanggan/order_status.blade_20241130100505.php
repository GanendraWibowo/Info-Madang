<!-- resources/views/customer/order_status.blade.php -->
@extends('layouts.apel')

@section('content')
<div class="container">
    < class="mt-4 text-center">Status Pesanan</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center" style="font-weight: bold;">Pesanan Nomor #{{ $order->queue_number }}</h5>
            <p>Status: {{ $order->order_status }}</p>
            <p>Status Pembayaran: {{ $order->status }}</p>
            <p>Total: Rp. {{ number_format($order->total_bayar, 0, ',', '.') }}</p>

            <h5>Produk</h5>
            <ul>
                @foreach($order->orderItems as $item)
                    <li>{{ $item->product->name }} - Kuantitas: {{ $item->quantity }} - Harga: Rp. {{ number_format($item->product->price, 0, ',', '.') }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
