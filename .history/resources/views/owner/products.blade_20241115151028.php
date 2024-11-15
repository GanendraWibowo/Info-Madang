@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Add New Product</h2>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-lg shadow-md mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('owner.products.store') }}" method="POST" enctype="multipart/form-data" id="addProductForm" class="bg-white shadow-lg rounded-lg p-8 transition-transform transform hover:scale-105">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12z"></path></svg>
                Product Name
            </label>
            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:ring-blue-500 transition duration-200 ease-in-out" id="name" name="name" required placeholder="Enter product name">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M3 3h14a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V5a2 2 0 012-2zm0 2v10h14V5H3z"></path></svg>
                Description
            </label>
            <textarea class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:ring-blue-500 transition duration-200 ease-in-out" id="description" name="description" rows="4" required placeholder="Enter product description"></textarea>
        </div>

        <div class="mb-4">
            <label for="price" class="block text-sm font-medium text-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12z"></path></svg>
                Price (in Rupiah)
            </label>
            <input type="text" class="mt-1 block w -full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:ring-blue-500 transition duration-200 ease-in-out" id="price" name="price" required placeholder="e.g. Rp10,000">
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M3 3h14a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V5a2 2 0 012-2zm0 2v10h14V5H3z"></path></svg>
                Product Image
            </label>
            <input type="file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:ring-blue-500 transition duration-200 ease-in-out" id="image" name="image" accept="image/*">
        </div>

        <div class="mb-4">
            <label for="category" class="block text-sm font-medium text-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12z"></path></svg>
                Category
            </label>
            <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:ring-blue-500 transition duration-200 ease-in-out" id="category" name="category" required>
                <option value="" disabled selected>Select a category</option>
                <option value="makanan">Makanan</option>
                <option value="minuman">Minuman</option>
                <option value="snacks">Snacks</option>
                <option value="PaHe">PaHe</option>
            </select>
        </div>

        <div class="mb-4">
            <button type="submit" class="w-full bg-blue-500 text-white font-semibold py-2 rounded-md hover:bg-blue-600 transition duration-200">
                Add Product
            </button>
        </div>
    </form>
</div>
@endsection