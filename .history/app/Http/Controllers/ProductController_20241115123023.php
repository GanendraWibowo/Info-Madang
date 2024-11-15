<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
            'category' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public'); // Store in public/products
        }

        // Create the product
        Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' => $imagePath,
            'category' => $request->input('category'),
        ]);

        // Redirect to the owner dashboard
        return redirect()->route('owner.dashboard')->with('success', 'Product added successfully!');
    }
    
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $category = ['makanan', 'minuman', 'snacks', 'PaHe']; // Sesuaikan dengan kategori yang ada
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
