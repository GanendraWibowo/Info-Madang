@extends('layouts.app')

@section('content')
    @include('owner.navbarOwner')    
    <div class="container my-5">
        <h1 class="mt-5">Dashboard</h1>
        <a href="{{ route('owner.products') }}" class="btn btn-success mb-3">Tambah Produk Baru</a>
        <a href="{{ route('owner.orders') }}" class="btn btn-primary mb-3">Pesanan</a>
        <a href="{{ route('logout') }}" class="btn btn-danger mb-3">Logout</a>

        <h2 class="mt-4">Katalog Produk</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}@extends('layouts.app')
            </div>
        @endif

        <div class="d-flex align-items-center mb-4">
            <div class="dropdown me-2">
                    Pilih Kategori
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('owner.products') }}">Semua Kategori</a></li>
                    @php
                        $categories = \App\Models\Product::distinct()->pluck('category');
                    @endphp
                    @foreach ($categories as $category)
                        <li><a class="dropdown-item" href="{{ route('owner.products', ['category' => $category]) }}">{{ $category }}</a></li>
                    @endforeach
                </ul>
            </div>

            <form action="{{ route('owner.products') }}" method="GET" class="d-flex">
                <input type="hidden" name="category" value="{{ request('category') }}">
                <input class="form-control me-2" type="search" name="search" placeholder="Cari produk" value="{{ request('search') }}">
                <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>
        </div>

        <div class="row">
        @foreach($products as $product)
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card mb-4">
                    <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="card-text">Stok: {{ $product->stock }}</p>
                        <button class="btn btn-primary add-to-cart" data-id="{{ $product->id }}">+</button>

                        <!-- Edit Stock Form -->
                        <form action="{{ route('owner.updateStock', ['id' => $product->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-warning">Edit Stok</button>
                        </form>

                        <!-- Edit Product Form -->
                        <form action="{{ route('owner.updateProduct', ['id' => $product->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-secondary">Edit Produk</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.add-to-cart').click(function () {
                var productId = $(this).data('id');
                $.post('{{ route('owner.products') }}', { product_id: productId, _token: '{{ csrf_token() }}' }, function (response) {
                    alert(response.message);
                }, 'json');
            });
        });
    </script>
@endsection
</body>
</html>
