@extends ('layouts.app')

@section('content')
    <div class="main-content">
        <div class="container mt-5">
            <h2>Edit Stock</h2>
            <form action="{{ route('owner.updateStock', $product->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Menambahkan metode PUT -->
                <input type="number" name="stock" value="{{ $product->stock }}">
                <button type="submit">Update Stock</button>
            </form>
        </div>
    </div>
@endsection