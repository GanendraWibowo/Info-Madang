<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Dashboard untuk Owner
    public function ownerDashboard()
    {
        // Ambil data antrian pesanan, riwayat pembelian, dan pendapatan dari database
        $ordersQueue = []; // Ganti dengan model untuk mengambil data antrian
        $purchaseHistory = []; // Ganti dengan model untuk mengambil data riwayat pembelian
        $revenue = 0; // Ganti dengan logika untuk menghitung pendapatan
        $products = Product::all();
        $orders = Order::with('user')->get();
        return view('owner.dashboardOwner', compact('products', 'orders'));
    }

    // Dashboard untuk Pelanggan
    public function customerDashboard()
    {
        $products = Product::all();
        return view('dashboard', compact('products'));
    }

    // Menampilkan halaman checkout
    public function checkout(Request $request)
    {
        // Logika checkout
        return view('checkout');
    }

    // Proses pemesanan
    public function placeOrder(Request $request)
    {
        // Logika untuk memproses pemesanan
    }
}
