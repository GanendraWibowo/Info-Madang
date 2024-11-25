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
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
            'category' => 'required|in:makanan,minuman,snacks,PaHe',
            'stock' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle image upload
        $uniqueName = null;
        if ($request->hasFile('image')) {
            // Ambil nama asli file yang diunggah
            $originalName = $request->file('image')->getClientOriginalName();

            // Tambahkan timestamp untuk memastikan nama unik
            $uniqueName = time() . '_' . $originalName;

            // Simpan file di folder public/img
            $request->file('image')->move(public_path('img'), $uniqueName);
        }
        // Resize gambar
        $image = Image::make($request->file('image'))->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio(); // Menjaga rasio gambar
            $constraint->upsize();     // Mencegah pembesaran gambar kecil
        });

        // Simpan data produk ke database
        $product = new Product(); // Model Anda
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category = $request->input('category');
        $product->stock = $request->input('stock');
        $product->image = $uniqueName; // Simpan nama file jika ada
        $product->save();

        return redirect()->route('dashboard.owner')->with('success', 'Product created successfully.');
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
