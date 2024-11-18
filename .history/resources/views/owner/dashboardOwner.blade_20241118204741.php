@extends('layouts.app')

@section('content')
@include('owner.navbarOwner')
<div class="container my-5" style="max-width: 600px;">
    <h1 class="mt-5 text-center">Dashboard</h1>
    
    <!-- Statistics Cards -->
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
                    <h5 class="card-title">Profit</h5>
                    <h3 class="card-text">Rp {{ number_format($profit, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-around mb-3">
        <a href="{{ route('owner.products') }}" class="btn btn-success">Tambah Produk</a>
        <a href="{{ route('owner.orders') }}" class="btn btn-primary">Pesanan</a>
        <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
    </div>

    <h2 class="mt-4">Katalog Produk</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="d-flex align-items-center mb-4">
        <form action="{{ route('dashboard.owner') }}" method="GET" class="w-100">
            <input class="form-control me-2" type="search" name="search" placeholder="Cari produk" value="{{ request('search') }}" style="margin-bottom: 10px">
            <button class="btn btn-outline-success" type="submit">Cari</button>
        </form>
    </div>

    <div class="row">
        @foreach($products as $product)
        <div class="col-6 mb-4">
            <div class="card">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                        <span class="text-muted">No image available</span>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="card-text">Stok: {{ $product->stock }}</p>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#editStockModal{{ $product->id }}">Edit Stok</button>
                    <a href="{{ route('owner.products.edit', ['id' => $product->id]) }}" class="btn btn-secondary">Edit Produk</a>
                </div>
            </div>
        </div>

        <!-- Edit Stock Modal -->
        <div class="modal fade" id="editStockModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="editStockModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editStockModalLabel{{ $product->id }}">Edit Stok</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('owner.updateStock', ['id' => $product->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="stock">Jumlah Stok:</label>
                                <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.add-to-cart').click(function() {
            var productId = $(this).data('id');
            $.post('{{ route('owner.products.store') }}', {
                    product_id: productId,
                    _token: '{{ csrf_token() }}'
                },
                function(response) {
                    alert(response.message);
                }, 'json');
        });
    });
</script>
@endsection
