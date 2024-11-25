<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function showDashboard(Request $request)
    {
         $category = $request->input('category');

         if ($category) {
             $products = Product::where('category', $category)->get();
         } else {
                     $products = Product::all();
        }

        return view('pelanggan.dashboard', compact('products'));
    }

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
        // Get the product
        $product = \App\Models\Product::findOrFail($productId);

        // Get current cart from session
        $cart = session()->get('cart', []);

        // Check if the product already exists in the cart
        if (isset($cart[$productId])) {
            // Increment the quantity
            $cart[$productId]['quantity']++;
        } else {
            // Add product to cart with quantity 1
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ];
        }

        // Save the updated cart in the session
        session()->put('cart', $cart);

        // Return updated cart count
        $cartCount = count($cart);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'cartCount' => $cartCount,
        ]);
    }


    // Checkout dan tampilkan total
    public function checkout()
    {
        $cart = session()->get('cart', []); // Provide a default empty array if cart is null
        $total_bayar = array_reduce($cart, fn($sum, $item) => $sum + ($item['price'] * $item['quantity']), 0);

        return view('pelanggan.checkout', compact('cart', 'total_bayar'));
    }
    
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);

        if ($request->action === 'decrease' && isset($cart[$request->product_id])) {
            // Kurangi kuantitas produk
            $cart[$request->product_id]['quantity']--;

            // Hapus produk dari keranjang jika kuantitasnya 0
            if ($cart[$request->product_id]['quantity'] <= 0) {
                unset($cart[$request->product_id]);
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('customer.checkout')->with('success', 'Cart updated successfully.');
    }



    // Proses pembayaran
    public function processPayment(Request $request)
    {
        $cart = session()->get('cart');
        if (!$cart) {
            return redirect()->route('customer.cart')->with('error', 'Keranjang kosong!');
        }

        // Hitung total pembayaran
        $total_bayar = array_reduce($cart, fn($sum, $item) => $sum + ($item['price'] * $item['quantity']), 0);

        // Buat order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_bayar' => $total_bayar,
            'queue_number' => Order::max('queue_number') + 1,
            'status' => 'sedang dibuat',
            'table_number' => $request->input('table_number') ?? 'default_value',
            'payment_method' => $request->input('payment_method'), // Add this line to pass the selected payment method
        ]);

        // Proses setiap item di keranjang
        foreach ($cart as $productId => $item) {
            // Simpan item ke OrderItem
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity']
            ]);

            // Kurangi stok produk
            $product = Product::find($productId);
            if ($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        // Kosongkan keranjang setelah pembayaran
        session()->forget('cart');

        return redirect()->route('customer.order.status', $order->id)->with('success', 'Pesanan berhasil diproses!');
    }


    // Melihat status pesanan pelanggan
    public function orderStatus($orderId)
    {
        $order = Order::where('id', $orderId)->where('user_id', Auth::id())->firstOrFail();
        return view('pelanggan.order_status', compact('order'));
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
