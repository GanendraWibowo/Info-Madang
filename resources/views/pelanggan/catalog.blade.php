<!-- resources/views/customer/catalog.blade.php -->
@extends('layouts.apel')

@section('content')
<div class="container">
    <h2 class="mt-4">Product Catalog</h2>

    <!-- Category Filter -->
    <div class="mb-3">
        <form action="{{ route('customer.menu') }}" method="GET">
            <label for="category" class="form-label">Filter by Category</label>
            <select name="category" id="category" class="form-select" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <option value="makanan" {{ request('category') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                <option value="minuman" {{ request('category') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                <option value="snacks" {{ request('category') == 'snacks' ? 'selected' : '' }}>Snacks</option>
                <option value="PaHe" {{ request('category') == 'PaHe' ? 'selected' : '' }}>PaHe</option>
            </select>
        </form>
    </div>

    <!-- Product List -->
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                        <form action="{{ route('customer.addToCart', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination (if needed) -->
    {{ $products->links() }}
</div>
@endsection
