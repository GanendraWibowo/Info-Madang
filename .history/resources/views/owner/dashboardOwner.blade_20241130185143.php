@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="mt-5">Halaman Utama</h1>
        
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Pendapatan</h5>
                        <h3 class="card-text">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Pesanan</h5>
                        <h3 class="card-text">{{ $totalOrders }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Pengeluaran</h5>
                        <h3 class="card-text">Rp {{ number_format($totalOutcome, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Keuntungan</h5>
                        <h3 class="card-text">Rp {{ number_format($profit, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <a href="{{ route('owner.products') }}" class="btn btn-success me-2">Tambah Produk Baru</a>
            <a href="{{ route('owner.orders') }}" class="btn btn-primary me-2">Pesanan</a>
            <a href="{{ route('owner.expenses.index') }}" class="btn btn-info me-2">Kelola Pengeluaran</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>

        <h2 class="mt-4 mb-3">Katalog Produk</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex align-items-center mb-4">
            <div class="dropdown me-2">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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
        </div>

        <div class="row">
            @foreach($products as $product)
                <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        @if($product->image)
                            @if(Str::startsWith($product->image, 'http'))
                                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @endif
                        @else
                            <img src="{{ asset('images/default-product.jpg') }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{$product->description}}</p>
                            <p class="card-text">Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="card-text">Stok: {{ $product->stock }}</p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('owner.updateStock', ['id' => $product->id]) }}" class="btn btn-warning">Ubah Stok</a>
                                <a href="{{ route('owner.updateProduct', ['id' => $product->id]) }}" class="btn btn-secondary">Ubah Produk</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.add-to-cart').click(function () {
                var productId = $(this).data('id');
                $.post('{{ route('owner.products') }}', { 
                    product_id: productId, 
                    _token: '{{ csrf_token() }}' 
                }, function (response) {
                    alert(response.message);
                }, 'json');
            });
        });
    </script>
@endsection
