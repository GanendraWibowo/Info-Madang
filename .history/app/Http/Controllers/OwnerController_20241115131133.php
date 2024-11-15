<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OwnerController extends Controller
{
    // Menampilkan halaman owner_product
    public function products()
    {
        $products = Product::all();
        return view('owner.products', compact('products'));
    }
    // Di dalam OwnerController.php
    public function showDashboard()
    {
        // Mengambil kategori unik dari produk
        $category = Product::distinct()->pluck('category');
        // Mengambil semua produk
        $products = Product::all();

        // Mengirimkan kategori dan produk ke view
        return view('dashboardOwner', compact('category', 'products'));
    }



    // Menampilkan halaman owner_order
    public function order()
    {
        $orders = Order::with('user')->get(); // Pastikan relasi user sudah disiapkan di model Order
        return view('owner.order', compact('orders'));
    }

    // Menampilkan halaman owner_report
    public function report()
    {
        $revenue = Order::sum('total'); // Hitung pendapatan
        $orderCount = Order::count(); // Hitung jumlah pesanan
        return view('owner.report', compact('revenue', 'orderCount'));
    }
    

    // Menampilkan antrian pesanan untuk owner
    public function orderQueue()
    {
        $orders = Order::with(['user', 'orderItems.product'])
            ->whereIn('status', ['sedang dibuat', 'siap diantar']) // Tampilkan hanya yang belum selesai
            ->orderBy('queue_number', 'asc')
            ->get();

        return view('owner.orders_queue', compact('orders'));
    }

    // Mengupdate status pesanan pelanggan
    public function updateOrderStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = $request->input('status');
        $order->save();

        // Logika untuk notifikasi real-time (misal menggunakan Laravel Echo atau Pusher)

        return redirect()->route('owner.orders.queue')->with('success', 'Status pesanan diperbarui!');
    }

    public function profile()
    {
        return view('owner.profile');
    }

    // Update password pengguna
    public function updatePassword(Request $request)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // Pastikan password minimal 8 karakter dan terkonfirmasi
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Periksa apakah password lama cocok
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->with('error', 'Password lama tidak cocok!');
        }

        // Update password
        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }

    // Logout pengguna
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
