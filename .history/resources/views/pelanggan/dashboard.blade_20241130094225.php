@extends('layouts.apel')

@section('content')
<div class="container">
    <div class="card-body mt-1 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="card-title">Selamat Datang {{ Auth::user()->name }}!</h3>
        </div>

        <!-- Cart -->
        <div class="position-relative">
            <a href="{{ route('customer.cart') }}" class="text-decoration-none">
                <img src="{{ asset('img/pngegg.png') }}" class="cart-icon" alt="Cart" style="width: 2rem; height: 2rem;">
                <span id="cart-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    0
                </span>
            </a>
        </div>
    </div>

    <!-- Product Cards -->
    <div class="row mt-2">
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
        </div>
        @endif
        @foreach ($products as $product)
            <!-- Adjusted column class for 2-column layout on mobile -->
            <div class="col-6 col-sm-12 col-md-6 col-lg-4">
                <div class="card mb-4">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="card-text">{{$product->description}}</p>
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

                // Update cart badge
                var cartCount = response.cartCount;  // Assuming your response returns the updated cart count
                $('#cart-badge').text(response.cartCount).addClass('d-block');

                if (cartCount > 0) {
                    $('#cart-badge').addClass('d-block'); // Show the badge if cart has items
                } else {
                    $('#cart-badge').removeClass('d-block'); // Hide the badge if cart is empty
                }
            }, 'json');
        });
    });
</script>
@endsection
