<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class OwnerController extends Controller
{
    // Menampilkan halaman owner_product
    public function products(Request $request)
    {
        $query = Product::query();
        
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }
        
        $products = $query->get();
        return view('owner.products', compact('products'));
    }

    // Menampilkan dashboard owner
    public function showDashboard(Request $request)
    {
        // Mengambil kategori unik dari produk
        $categories = Product::distinct()->pluck('category');

        // Query dasar untuk produk
        $query = Product::query();
        
        // Filter berdasarkan kategori jika ada
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Mengambil produk yang sudah difilter
        $products = $query->get()->map(function($product) {
            if ($product->image) {
                if (!filter_var($product->image, FILTER_VALIDATE_URL)) {
                    $product->image = Storage::disk('public')->url($product->image);
                }
            }
            return $product;
        });

        // Menghitung total pendapatan
        $totalIncome = Order::sum('total_bayar');

        // Menghitung total pesanan
        $totalOrders = Order::count();

        // Menghitung total outcomes dari tabel expenses
        $totalOutcome = $this->calculateTotalOutcomes();

        // Menghitung keuntungan
        $profit = $totalIncome - $totalOutcome;

        // Mengirimkan kategori, produk, dan statistik ke view
        return view('owner.dashboardOwner', compact('categories', 'products', 'totalIncome', 'totalOrders', 'totalOutcome', 'profit'));
    }

    // Rest of the controller methods remain the same...
    public function order()
    {
        $orders = Order::with('user')->get();
        return view('owner.order', compact('orders'));
    }

    public function report()
    {
        $revenue = Order::where('status', 'selesai')->sum('total_bayar');
        $orderCount = Order::where('status', 'selesai')->count();
        $transactions = Order::with('user', 'orderItems.product')
            ->where('status', 'selesai')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->get();
        return view('owner.report', compact('revenue', 'orderCount', 'transactions'));
    }

    private function calculateTotalOutcomes()
    {
        // Calculate total expenses from the expenses table
        return Expense::sum('amount');
    }

    public function orderQueue()
    {
        $orders = Order::with(['user', 'orderItems.product'])
            ->whereIn('status', ['sedang dibuat', 'siap diantar'])
            ->orderBy('queue_number', 'asc')
            ->get();
        return view('owner.orders_queue', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $orderId)
    {
        \Log::info('Order ID: ' . $orderId);
        \Log::info('Order Status: ' . $request->status);

        $order = Order::findOrFail($orderId);
        $request->validate([
            'status' => 'required|in:sedang dibuat,siap diambil,selesai',
        ]);
        $order->update([
            'status' => $request->status,
        ]);
        \Log::info('Updated Status: ' . $order->status);
        return redirect()->route('owner.orders')->with('success', 'Order status updated successfully!');
    }

    public function profileOwner()
    {
        return view('owner.profileOwner');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->with('error', 'Password lama tidak cocok!');
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }

    public function ownerLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
