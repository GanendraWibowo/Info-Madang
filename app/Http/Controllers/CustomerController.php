<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function menu(Request $request, $category = null)
    {
        // List of categories to filter by
        $categories = ['makanan', 'minuman', 'snack', 'PaHe'];

        // Get the search query
        $search = $request->input('search');

        // Query for products based on category and search
        $query = Product::query();

        // Filter by category if it's provided and valid
        if ($category && in_array($category, $categories)) {
            $query->where('category', $category);
        }

        // Filter by search query
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Get products with pagination
        $products = $query->paginate(12);

        // Debug the variables
        dd(compact('products', 'categories', 'search'));

        // Return the view and pass the variables
        return view('customer.catalog', compact('products', 'categories', 'search'));
    }




    // Tambah produk ke keranjang
    public function addToCart(Request $request, $productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $product = Product::find($productId);
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('customer.menu')->with('success', 'Item berhasil ditambahkan ke keranjang!');
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
        return view('customer.cart', compact('cart'));
    }

    // Melihat riwayat pesanan pelanggan
    public function orderHistory()
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('customer.order_history', compact('orders'));
    }
}
