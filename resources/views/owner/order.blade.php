@extends('layouts.app')

@section('content')
<div class="container">
   <h1 class="text-center mt-4 mb-4">Orders</h1>

   <div class="table-responsive">
       <table class="table table-bordered table-striped">
           <thead>
               <tr>
                   <th>Order ID</th>
                   <th>User</th>
                   <th>Table Number</th>
                   <th>Payment Status</th>
                   <th>Queue Number</th>
                   <th>Payment Method</th>
                   <th>Total Price</th>
                   <th>Created At</th>
                   <th>Order Status</th>
               </tr>
           </thead>
           <tbody>
               @foreach ($orders as $order)
                   <tr>
                       <td>{{ $order->id }}</td>
                       <td>{{ $order->user->name ?? 'N/A' }}</td>
                       <td>{{ $order->table_number }}</td>
                       <td>{{ $order->order_status }}</td>
                       <td>{{ $order->queue_number }}</td>
                       <td>{{ ucfirst($order->payment_method) }}</td>
                       <td>Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                       <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                       <td>
                           <form action="{{ route('orders.updateOrderStatus', $order->id) }}" method="POST">
                               @csrf
                               @method('PUT')
                               <div class="d-flex gap-2">
                                   <select name="status" class="form-select form-select-sm">
                                       <option value="sedang dibuat" {{ $order->status == 'sedang dibuat' ? 'selected' : '' }}>Sedang Dibuat</option>
                                       <option value="siap diambil" {{ $order->status == 'siap diambil' ? 'selected' : '' }}>Siap Diambil</option>
                                       <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                   </select>
                                   <button type="submit" class="btn btn-primary btn-sm">Update</button>
                               </div>
                           </form>
                       </td>
                   </tr>
               @endforeach
           </tbody>
       </table>
   </div>
</div>
@endsection
