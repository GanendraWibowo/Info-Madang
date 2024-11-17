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
            'category' => 'required|in:makanan,minuman,snacks,PaHe', // Updated validation
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
        return redirect()->route('dashboard.owner')->with('success', 'Product added successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ['makanan', 'minuman', 'snacks', 'PaHe']; // Updated categories
        return view('owner.product_edit', compact('product', 'categories'));
    }
    
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate data
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|in:makanan,minuman,snacks,PaHe', // Updated validation
            'stock' => 'required|integer',
        ]);

        // Update product data
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'stock' => $request->stock,
        ]);

        return redirect()->route('dashboard.owner')->with('success', 'Produk berhasil diupdate.');
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0', // Validate the stock input
        ]);

        $product = Product::findOrFail($id);
        $product->stock = $request->stock; // Update the stock
        $product->save();

        return redirect()->back()->with('success', 'Stock berhasil diupdate.');
    }
}
