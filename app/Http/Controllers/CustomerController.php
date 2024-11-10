<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // Menampilkan menu dengan pilihan kategori
    public function menu($category = null)
    {
        $categories = ['makanan', 'minuman', 'snacks', 'PaHe'];
        $products = $category ? Product::where('category', $category)->get() : Product::all();

        return view('customer.menu', compact('products', 'categories'));
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
}
