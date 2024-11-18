<<<<<<< HEAD
<!-- resources/views/owner/product.blade.php -->

@extends('app') <!-- Adjust this based on your layout -->

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Add New Product</h2>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('owner.products.store') }}" method="POST" enctype="multipart/form-data" id="addProductForm">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" id="name" name="name" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" id="description" name="description" rows="3" required></textarea>
        </div>

        <div class="mb-4">
            <label for="price" class="block text-sm font-medium text-gray-700">Price (in Rupiah)</label>
            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" id="price" name="price" required placeholder="e.g. Rp10,000">
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
            <input type="file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" id="image" name="image" accept="image/*">
        </div>

        <div class="mb-4">
            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" id="category" name="category" required>
                <option value
=======
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
>>>>>>> 2bf3adc0b7147f7469e04e940c0d1c217118e189
