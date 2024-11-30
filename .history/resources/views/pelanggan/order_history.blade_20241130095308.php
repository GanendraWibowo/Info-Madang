<!-- resources/views/customer/order_history.blade.php -->
@extends('layouts.apel')

@section('content')
<div class="container">
    <h2 class="mt-1 text-center">Riwayat Pemesanan</h2>

    @if($orders->isNotEmpty())
        @foreach($orders as $order)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title text-center" style="font-weight: bold;">Pesanan nomor #{{ $order->queue_number }} </h5>
                    <h6>{{ $order->created_at->format('d-m-Y') }}</h6>
                    <p>Status: {{ $order->status }}</p>
                    <p>Total: Rp. {{ number_format($order->total_bayar, 0, ',', '.') }}</p>
                    <a href="{{ route('customer.order.status', $order->id) }}" class="btn btn-info">View Details</a>
                </div>
            </div>
        @endforeach
    @else
        <p>Belum ada transaksi</p>
    @endif
</div>

@endsection
