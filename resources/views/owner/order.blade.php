@extends('layouts.app')

@section('content')
<div class="container mx-auto">
   <h1 class="text-2xl font-bold">Orders</h1>

   <table class="min-w-full mt-4 bg-white border border-gray-300">
       <thead>
           <tr>
               <th class="border px-4 py-2">Order ID</th>
               <th class="border px-4 py-2">User</th>
               <th class="border px-4 py-2">Table Number</th>
               <th class="border px-4 py-2">Payment Status</th>
               <th class="border px-4 py-2">Queue Number</th>
               <th class="border px-4 py-2">Payment Method</th>
               <th class="border px-4 py-2">Created At</th>
               <th class="border px-4 py-2">Order Status</th>
           </tr>
       </thead>
       <tbody>
           @foreach ($orders as $order)
               <tr>
                   <td class="border px-4 py-2">{{ $order->id }}</td>
                   <td class="border px-4 py-2">{{ $order->user->name ?? 'N/A' }}</td>
                   <td class="border px-4 py-2">{{ $order->table_number }}</td>
                   <td class="border px-4 py-2">{{ $order->order_status }}</td>
                   <td class="border px-4 py-2">{{ $order->queue_number }}</td>
                   <td class="border px-4 py-2">{{ ucfirst($order->payment_method) }}</td>
                   <td class="border px-4 py-2">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                   <td class="border px-4 py-2">
                       <form action="{{ route('orders.updateOrderStatus', $order->id) }}" method="POST">
                           @csrf
                           @method('PUT')
                           <select name="status" class="border px-2 py-1">
                               <option value="sedang dibuat" {{ $order->status == 'sedang dibuat' ? 'selected' : '' }}>Sedang Dibuat</option>
                               <option value="siap diambil" {{ $order->status == 'siap diambil' ? 'selected' : '' }}>Siap Diambil</option>
                               <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                           </select>
                           <button type="submit" class="bg-blue-500 text-black px-2 py-1 mt-1">Update</button>
                       </form>
                   </td>
                   </td>
               </tr>
           @endforeach
       </tbody>
   </table>
</div>
@endsection
