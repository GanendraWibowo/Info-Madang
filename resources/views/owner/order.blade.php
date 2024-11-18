@extends('layouts.app')

@section('content')
<div class="container mx-auto">
   <h1 class="mt-1 text-center">Orders</h1>

   <!-- Wrapper untuk tabel agar mendukung scroll horizontal -->
   <div class="overflow-x-auto">
       <table class="min-w-full bg-white border border-gray-300">
           <thead>
               <tr>
                   <th class="border px-4 py-2 text-sm">Order ID</th>
                   <th class="border px-4 py-2 text-sm">User</th>
                   <th class="border px-4 py-2 text-sm">Table Number</th>
                   <th class="border px-4 py-2 text-sm">Payment Status</th>
                   <th class="border px-4 py-2 text-sm">Queue Number</th>
                   <th class="border px-4 py-2 text-sm">Payment Method</th>
                   <th class="border px-4 py-2 text-sm">Created At</th>
                   <th class="border px-4 py-2 text-sm">Order Status</th>
               </tr>
           </thead>
           <tbody>
               @foreach ($orders as $order)
                   <tr>
                       <td class="border px-4 py-2 text-sm whitespace-nowrap">{{ $order->id }}</td>
                       <td class="border px-4 py-2 text-sm whitespace-nowrap">{{ $order->user->name ?? 'N/A' }}</td>
                       <td class="border px-4 py-2 text-sm whitespace-nowrap">{{ $order->table_number }}</td>
                       <td class="border px-4 py-2 text-sm whitespace-nowrap">{{ $order->order_status }}</td>
                       <td class="border px-4 py-2 text-sm whitespace-nowrap">{{ $order->queue_number }}</td>
                       <td class="border px-4 py-2 text-sm whitespace-nowrap">{{ ucfirst($order->payment_method) }}</td>
                       <td class="border px-4 py-2 text-sm whitespace-nowrap">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                       <td class="border px-4 py-2 text-sm whitespace-nowrap">
                           <form action="{{ route('orders.updateOrderStatus', $order->id) }}" method="POST">
                               @csrf
                               @method('PUT')
                               <select name="status" class="border px-2 py-1 text-sm">
                                   <option value="sedang dibuat" {{ $order->status == 'sedang dibuat' ? 'selected' : '' }}>Sedang Dibuat</option>
                                   <option value="siap diambil" {{ $order->status == 'siap diambil' ? 'selected' : '' }}>Siap Diambil</option>
                                   <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                               </select>
                               <button type="submit" class="bg-blue-500 text-white px-2 py-1 mt-1">Update</button>
                           </form>
                       </td>
                   </tr>
               @endforeach
           </tbody>
       </table>
   </div>
</div>
@endsection
