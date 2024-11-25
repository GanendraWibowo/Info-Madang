@extends ('layouts.app')

@section('content')
<div class="main-content">
    <div class="container mt-5">
        <h2>Laporan Penjualan Mingguan</h2>

        <p>Total Pendapatan: {{ number_format($totalIncome, 2) }}</p>
        <p>Total Pesanan: {{ $orderCount }}</p>

        @if($transactions->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Nama Produk</th>
                        <th>Metode Pembayaran</th>
                        <th>Tanggal Pembelian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        @foreach($transaction->orderItems as $item)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $item->product->name }}</td> <!-- Assuming 'product' relationship is defined in OrderItem -->
                                <td>{{ ucfirst($transaction->payment_method) }}</td>
                                <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada transaksi minggu ini.</p>
        @endif
    </div>
</div>
@endsection
