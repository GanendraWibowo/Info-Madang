
@extends('app')

@section('content')
<div class="main-content">
    <div class="container mt-5">
        <h2>Laporan Penjualan Mingguan</h2>

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
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->product->name }}</td>
                            <td>{{ $transaction->payment_method }}</td>
                            <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada transaksi dalam satu minggu terakhir.</p>
        @endif
    </div>
</div>
@endsection
