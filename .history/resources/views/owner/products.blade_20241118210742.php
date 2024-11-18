@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
   <h2 style="font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 20px; color: #333;">Add New Product</h2>

   @if ($errors->any())
       <div style="background-color: #f56565; color: #fff; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
           <ul style="list-style-type: none; padding: 0;">
               @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
               @endforeach
           </ul>
       </div>
   @endif

   <form action="{{ route('owner.product.store') }}" method="POST" enctype="multipart/form-data" id="addProductForm" style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
       @csrf
       <div style="margin-bottom: 15px;">
           <label for="name" style="font-size: 14px; font-weight: bold; display: flex; align-items: center; color: #555;">
               Product Name
           </label>
           <input type="text" id="name" name="name" required placeholder="Enter product name" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;">
       </div>

       <div style="margin-bottom: 15px;">
           <label for="description" style="font-size: 14px; font-weight: bold; display: flex; align-items: center; color: #555;">
               Description
           </label>
           <textarea id="description" name="description" rows="4" required placeholder="Enter product description" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;"></textarea>
       </div>

       <div style="margin-bottom: 15px;">
           <label for="price" style="font-size: 14px; font-weight: bold; display: flex; align-items: center; color: #555;">
               Price (in Rupiah)
           </label>
           <input type="text" id="price" name="price" required placeholder="e.g. Rp10,000" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;">
       </div>

       <div style="margin-bottom: 15px;">
           <label for="image" style="font-size: 14px; font-weight: bold; display: flex; align-items: center; color: #555;">
               Product Image
           </label>
           <input type="file" id="image" name="image" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;">
       </div>

       <div style="margin-bottom: 15px;">
           <label for="category" style="font-size: 14px; font-weight: bold; display: flex; align-items: center; color: #555;">
               Category
           </label>
           <select id="category" name="category" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;">
               <option value="" disabled selected>Select a category</option>
               <option value="makanan">Makanan</option>
               <option value="minuman">Minuman</option>
               <option value="snacks">Snacks</option>
               <option value="PaHe">PaHe</option>
           </select>
       </div>

       <div style="margin-bottom: 15px;">
           <label for="stock" style="font-size: 14px; font-weight: bold; display: flex; align-items: center; color: #555;">
               Stock
           </label>
           <input type="number" id="stock" name="stock" required placeholder="Enter stock quantity" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;">
       </div>

       <div style="margin-bottom: 15px;">
           <button type="submit" style="width: 100%; background-color: #3182ce; color: #fff; padding: 10px; font-weight: bold; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.2s;">
               Add Product
           </button>
       </div>
   </form>
</div>
@endsection
