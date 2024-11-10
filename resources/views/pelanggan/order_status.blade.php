<!-- resources/views/customer/order_status.blade.php -->
@extends('layouts.apel')

@section('content')
<div class="container">
    <h2 class="mt-4">Order Status</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Order #{{ $order->id }}</h5>
            <p>Status: {{ $order->status }}</p>
            <p>Total: Rp. {{ number_format($order->total, 0, ',', '.') }}</p>

            <h5>Items</h5>
            <ul>
                @foreach($order->orderItems as $item)
                    <li>{{ $item->product->name }} - Quantity: {{ $item->quantity }} - Price: Rp. {{ number_format($item->product->price, 0, ',', '.') }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
