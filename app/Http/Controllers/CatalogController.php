<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category');
        $search = $request->input('search');

        $query = Product::query();

        if ($category) {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        $products = $query->get();

        $categories = ["makanan & minuman", "kebutuhan rumah tangga", "aksessoris", "persabunan"];

        return view('catalog.index', compact('products', 'categories', 'category', 'search'));
    }

    public function addToCart(Request $request)
    {
        // Add your add-to-cart logic here
        return response()->json(['message' => 'Product added to cart!']);
    }
}
