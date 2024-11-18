<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OwnerController extends Controller
{
    // Menampilkan dashboard owner dengan semua produk
    public function showDashboard(Request $request)
    {
        $query = Product::query();

        // Search by product name if provided
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Get the products with pagination
        $products = $query->paginate(10); // Adjust the number of items per page as needed

        // Calculate total income, total orders, total outcomes, and profit
        $totalIncome = Order::sum('total'); // Adjust this field as necessary
        $totalOrders = Order::count();
        $totalOutcome = $this->calculateTotalOutcomes(); // Adjust this method as necessary
        $profit = $totalIncome - $totalOutcome;

        // Pass the paginated products and statistics to the view
        return view('owner.dashboard', compact('products', 'totalIncome', 'totalOrders', 'totalOutcome', 'profit'));
    }

    // Menampilkan halaman untuk menambah produk
    public function products()
    {
        // Get all categories for the dropdown
        $categories = Category::all(); // Fetch all categories from the categories table

        return view('owner.products', compact('categories'));
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id', // Ensure category exists
        ]);

        // Handle file upload
        $imagePath = $request->file('image')->store('images/products', 'public');

        // Create the product
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'category_id' => $request->category_id, // Use category_id instead of category
        ]);

        return redirect()->route('owner.dashboard')->with('success', 'Product added successfully!');
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

    // Menghitung total pengeluaran (contoh)
    private function calculateTotalOutcomes()
    {
        // Logika untuk menghitung total pengeluaran
        return 500000; // Contoh nilai tetap, ganti dengan logika yang sesuai
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
