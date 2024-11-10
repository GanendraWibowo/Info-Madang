@extends ('app')
@section('content')
    <div class="main-content">
        <div class="container mt-5">
            <h2>Edit Stock</h2>
            <form action="update_stock.php" method="POST">
                <input type="hidden" name="id" value="<?= $product['id']; ?>">
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="<?= $product['stock']; ?>"
                        required>
                </div>
                <button type="submit" class="btn btn-primary">Update Stock</button>
            </form>
        </div>
    </div>
@endsection