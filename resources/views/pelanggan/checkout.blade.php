<!-- resources/views/customer/checkout.blade.php -->
@extends('layouts.apel')

@section('content')
<div class="container">
    <h2 class="mt-4">Checkout</h2>

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
        <h4>Total: Rp. {{ number_format($total, 0, ',', '.') }}</h4>

        <form action="{{ route('customer.processPayment') }}" method="POST">
            @csrf
            <input type="hidden" name="total" value="{{ $total }}">
            <button type="submit" class="btn btn-success">Confirm and Pay</button>
        </form>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
