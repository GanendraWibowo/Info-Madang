<!-- resources/views/customer/order_history.blade.php -->
@extends('layouts.apel')

@section('content')
<div class="container">
    <h2 class="mt-4">Order History</h2>

    @if($orders->isNotEmpty())
        @foreach($orders as $order)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Order #{{ $order->id }} - {{ $order->created_at->format('d-m-Y') }}</h5>
                    <p>Status: {{ $order->status }}</p>
                    <p>Total: Rp. {{ number_format($order->total, 0, ',', '.') }}</p>
                    <a href="{{ route('customer.order.status', $order->id) }}" class="btn btn-info">View Details</a>
                </div>
            </div>
        @endforeach
    @else
        <p>No orders found.</p>
    @endif
</div>
@endsection
