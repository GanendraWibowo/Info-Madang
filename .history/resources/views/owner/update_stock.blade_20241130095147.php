@extends ('layouts.app')

@section('content')
    <div class="main-content">
        <div class="container mt-5">
            <h2>Ubah Stok</h2>
            <form action="{{ route('owner.updateStock', $product->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Menambahkan metode PUT -->
                <input type="number" name="stock" value="{{ $product->stock }}">
                <button type="submit">Perbarui Stok</button>
            </form>
        </div>
    </div>
@endsection