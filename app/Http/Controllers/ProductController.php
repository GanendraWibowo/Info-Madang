<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ['makanan', 'minuman', 'snacks', 'PaHe']; // Sesuaikan dengan kategori yang ada
        return view('owner.product_edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'stock' => 'required|integer',
        ]);

        // Update data produk
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'stock' => $request->stock,
        ]);

        return redirect()->route('owner.products')->with('success', 'Produk berhasil diupdate.');
    }

    public function updateStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validasi stok baru
        $request->validate([
            'new_stock' => 'required|integer',
        ]);

        // Update stok
        $product->stock = $request->new_stock;
        $product->save();

        return redirect()->route('owner.products')->with('success', 'Stok produk berhasil diupdate.');
    }
}
