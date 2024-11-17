@extends('layouts.apel')

@section('content')
<div class="container ">
    <h2 class="mt-1 text-center">Checkout</h2>

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
        <h4>Total: Rp. {{ number_format($total_bayar, 0, ',', '.') }}</h4>

        <!-- Add Table Number Input -->
        <form action="{{ route('customer.processPayment') }}" method="POST">
            @csrf
            <input type="hidden" name="total" value="{{ $total_bayar }}">
            
            <!-- Table Number Input -->
            <div class="form-group mt-2">
                <label for="table_number">Table Number</label>
                <input type="text" name="table_number" id="table_number" class="form-control" required>
            </div>

            <!-- Payment Method Options -->
            <div class="form-group mt-2">
                <label for="payment_method">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="cash">Cash</option>
                    <option value="digital_wallet">Digital Wallet</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success mt-3">Confirm and Pay</button>
        </form>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
