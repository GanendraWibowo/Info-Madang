<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Product::query();

            if ($request->has('category') && $request->category) {
                $query->where('category', $request->category);
            }

            if ($request->has('search') && $request->search) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            $products = $query->paginate(10);

            return view('dashboard', compact('products'));
        } catch (\Exception $e) {
            Log::error('Error in ProductController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat produk.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category' => 'required|in:makanan,minuman,snacks,PaHe',
                'stock' => 'required|integer|min:0',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imageName = $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('img'), $imageName);
                $imagePath = 'img/' . $imageName;
            }

            Product::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'image' => $imagePath,
                'category' => $request->input('category'),
                'stock' => $request->input('stock'),
            ]);

            return redirect()->route('dashboard.owner')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            Log::error('Error in ProductController@store: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menambah produk.')
                ->withInput();
        }
    }


    public function updateProduct(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'category' => 'required|in:makanan,minuman,snacks,PaHe',
                'stock' => 'required|integer|min:0',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'category' => $request->category,
                'stock' => $request->stock,
            ]);

            return redirect()->route('dashboard.owner')->with('success', 'Produk berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error('Error in ProductController@updateProduct: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate produk.');
        }
    }

    public function updateStock(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                'stock' => 'required|integer|min:0',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $product->stock = $request->input('stock');
            $product->save();

            return redirect()->route('dashboard.owner')->with('success', 'Stock updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error in ProductController@updateStock: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate stok.');
        }
    }
}
