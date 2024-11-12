@extends('layouts.apel')

@section('content')
<div class="container">
    <h1 class="mt-5">Product Catalog</h1>

    @if (Route::currentRouteName() === 'login.dashboard')
        <!-- Category Filter Form -->
        <div class="form-row align-items-center mb-4">
            <div class="col-auto">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Pilih Kategori
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('login.dashboard') }}">Semua Kategori</a></li>
                        @php
                            $categories = \App\Models\Product::distinct()->pluck('category');
                        @endphp
                        @foreach ($categories as $category)
                            <li><a class="dropdown-item" href="{{ route('login.dashboard', ['category' => $category]) }}">{{ $category }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Uncomment if search is needed --}}
            {{-- <div class="col">
                <form action="{{ route('login.dashboard') }}" method="GET" class="form-inline">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari produk" value="{{ request('search') }}">
                    <button class="btn btn-outline-success" type="submit">Cari</button>
                </form>
            </div> --}}
        </div>
    @endif

    <!-- Product Cards -->
    <div class="row">
        @foreach ($products as $product)
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card mb-4">
                    <img src="{{ asset('assets/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Price: Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="card-text">Stock: {{ $product->stock }}</p>
                        <button class="btn btn-primary add-to-cart" data-id="{{ $product->id }}">+</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $('.add-to-cart').click(function () {
            var productId = $(this).data('id');
            var stock = $(this).closest('.card-body').find('.card-text:contains("Stock")').text().split(": ")[1];

            // Check if stock is 0
            if (parseInt(stock) === 0) {
                alert('Produk ini habis dan tidak dapat ditambahkan ke keranjang.');
                return;
            }

            $.post("{{ route('customer.addToCart', ':productId') }}".replace(':productId', productId), {
                _token: '{{ csrf_token() }}'
            }, function (response) {
                alert(response.message);
            }, 'json');
        });
    });
</script>
@endsection
