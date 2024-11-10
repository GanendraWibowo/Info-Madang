<!-- resources/views/customer/cart.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mt-4">Cart</h2>

    @if(!empty($cart))
        <div class="row">
            @foreach($cart as $productId => $item)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item['name'] }}</h5>
                            <p class="card-text">Price: Rp. {{ number_format($item['price'], 0, ',', '.') }}</p>
                            <p class="card-text">Quantity: {{ $item['quantity'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <a href="{{ route('customer.checkout') }}" class="btn btn-primary">Proceed to Checkout</a>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
