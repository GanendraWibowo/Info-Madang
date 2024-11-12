<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // public function showDashboardd(Request $request)
    // {
    //     $category = $request->input('category');

    //     if ($category) {
    //         $products = Product::where('category', $category)->get();
    //     } else {
    //         $products = Product::all();
    //     }

    //     return view('login.dashboard', compact('products'));
    // }

    public function product(Request $request)
    {
        $category = $request->get('category');

        $products = Product::when($category, function ($query) use ($category) {
            return $query->where('category', $category);
        })->get();

        return view('pelanggan.catalog', compact('products'));
    }

    public function menu(Request $request, $category = null)
    {
        // List of categories to filter by
        $category = ['makanan', 'minuman', 'snack', 'PaHe'];

        // Get the search query
        $search = $request->input('search');

        // Query for products based on category and search
        $query = Product::query();

        // Filter by category if it's provided and valid
        if ($category && in_array($category, $category)) {
            $query->where('category', $category);
        }

        // Filter by search query
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Get products with pagination
        $products = $query->paginate(12);

        // Debug the variables
        dd(compact('products', 'category', 'search'));

        // Return the view and pass the variables
        return view('customer.catalog', compact('products', 'category', 'search'));
    }

    public function profilee()
    {
        return view('pelanggan.profile');
    }

    // Tambah produk ke keranjang
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // Check if the product is out of stock
        if ($product->stock <= 0) {
            return response()->json(['message' => 'Produk ini habis dan tidak dapat ditambahkan ke keranjang.'], 400);
        }

        $cart = session()->get('cart', []);

        // Check if the product exists in the cart and increment quantity if stock allows
        if (isset($cart[$productId])) {
            if ($cart[$productId]['quantity'] < $product->stock) {
                $cart[$productId]['quantity']++;
            } else {
                return response()->json(['message' => 'Stok tidak mencukupi untuk menambah produk ke keranjang.'], 400);
            }
        } else {
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price
            ];
        }

        session()->put('cart', $cart);
        return response()->json(['message' => 'Item berhasil ditambahkan ke keranjang!']);
    }


    // Checkout dan tampilkan total
    public function checkout()
    {
        $cart = session()->get('cart');
        $total = array_reduce($cart, fn($sum, $item) => $sum + ($item['price'] * $item['quantity']), 0);

        return view('customer.checkout', compact('cart', 'total'));
    }

    // Proses pembayaran
    public function processPayment(Request $request)
    {
        $cart = session()->get('cart');
        if (!$cart) {
            return redirect()->route('customer.menu')->with('error', 'Keranjang kosong!');
        }

        $order = new Order();
        $order->user_id = Auth::id();
        $order->total = $request->input('total');
        $order->queue_number = Order::max('queue_number') + 1; // Tambah nomor antrian
        $order->status = 'sedang dibuat';
        $order->save();

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity']
            ]);
        }

        session()->forget('cart');
        return redirect()->route('customer.order.status', $order->id)->with('success', 'Pesanan berhasil diproses!');
    }

    // Melihat status pesanan pelanggan
    public function orderStatus($orderId)
    {
        $order = Order::where('id', $orderId)->where('user_id', Auth::id())->firstOrFail();
        return view('customer.order_status', compact('order'));
    }

    // Melihat cart
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('pelanggan.addToCart', compact('cart'));
    }

    // Melihat riwayat pesanan pelanggan
    public function orderHistory()
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('pelanggan.order_history', compact('orders'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
