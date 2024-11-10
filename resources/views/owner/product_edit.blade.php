@extends ('app')

@section('content')
<div class="main-content">
    <div class="container mt-5">
        <h2>Edit Produk</h2>

        <form action="{{ route('product.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Produk</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
            </div>

            <div class="form-group">
                <label for="price">Harga</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
            </div>

            <div class="form-group">
                <label for="category">Kategori</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="makanan" {{ $product->category == 'makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="minuman" {{ $product->category == 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="snacks" {{ $product->category == 'snacks' ? 'selected' : '' }}>Snacks</option>
                    <option value="pahe" {{ $product->category == 'pahe' ? 'selected' : '' }}>PaHe</option>
                </select>
            </div>

            <div class="form-group">
                <label for="stock">Stok</label>
                <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Produk</button>
        </form>
    </div>
</div>
@endsection
