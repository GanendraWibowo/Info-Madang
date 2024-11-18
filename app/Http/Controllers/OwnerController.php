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


    // Menampilkan dashboard owner
    public function showDashboard()
    {
        // Mengambil kategori unik dari produk
        $category = Product::distinct()->pluck('category');


        // Mengambil semua produk
        $products = Product::all();


        // Menghitung total pendapatan
        $totalIncome = Order::sum('price'); // Ganti 'price' dengan field yang sesuai di model Order


        // Menghitung total pesanan
        $totalOrders = Order::count();


        // Menghitung total outcomes (biaya tetap atau variabel)
        // Misalnya, Anda bisa menambahkan metode untuk menghitung pengeluaran
        $totalOutcome = $this->calculateTotalOutcomes(); // Ganti dengan metode yang sesuai


        // Menghitung keuntungan
        $profit = $totalIncome - $totalOutcome;


        // Mengirimkan kategori, produk, dan statistik ke view
        return view('dashboardOwner', compact('category', 'products', 'totalIncome', 'totalOrders', 'totalOutcome', 'profit'));
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
        // Hitung pendapatan hanya dari pesanan dengan status 'selesai'
        $revenue = Order::where('status', 'selesai')->sum('total_bayar');

        // Hitung jumlah pesanan dengan status 'selesai'
        $orderCount = Order::where('status', 'selesai')->count();

        // Fetch transactions (orders) dengan status 'selesai'
        $transactions = Order::with('user', 'orderItems.product') // Relationships assumed: 'user' and 'orderItems.product'
            ->where('status', 'selesai') // Hanya ambil pesanan dengan status 'selesai'
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]) // Filter by this week's transactions
            ->get();

        // Pass the data to the view
        return view('owner.report', compact('revenue', 'orderCount', 'transactions'));
    }



    // Menghitung total pengeluaran (contoh)
    private function calculateTotalOutcomes()
    {
        // Logika untuk menghitung total pengeluaran
        // Misalnya, jika Anda memiliki tabel pengeluaran
        // return Expense::sum('amount'); // Ganti dengan model dan field yang sesuai
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
        \Log::info('Order ID: ' . $orderId);
        \Log::info('Order Status: ' . $request->status);

        $order = Order::findOrFail($orderId);

        // Validate the input
        $request->validate([
            'status' => 'required|in:sedang dibuat,siap diambil,selesai',
        ]);

        // Update the order status
        $order->update([
            'status' => $request->status,
        ]);

        // Log the updated status
        \Log::info('Updated Status: ' . $order->status);

        return redirect()->route('owner.orders')->with('success', 'Order status updated successfully!');
    }

    public function profileOwner()
    {
        return view('owner.profileOwner');
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
