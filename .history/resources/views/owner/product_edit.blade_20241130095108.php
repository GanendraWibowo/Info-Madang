@extends('layouts.app')


@section('content')
<div class="main-content">
   <div class="container mt-5">
       <h2>Ubah Produk</h2>


       <form action="{{ route('owner.PerbaruiProduct', $product->id) }}" method="POST">
           @csrf
           @method('PUT')


           <div class="form-group">
               <label for="name">Nama Produk</label>
               <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
           </div>


           <div class="form-group">
               <label for="price">Harga</label>
               <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required>
           </div>


           <div class="form-group">
               <label for="category">Kategori</label>
               <select class="form-control" id="category" name="category" required>
                   @foreach ($categories as $category)
                       <option value="{{ $category }}" {{ $product->category == $category ? 'selected' : '' }}>
                           {{ ucfirst($category) }}
                       </option>
                   @endforeach
               </select>
           </div>


           <div class="form-group">
               <label for="stock">Stok</label>
               <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
           </div>


           <button type="submit" class="btn btn-primary">Perbarui Produk</button>
       </form>
   </div>
</div>
@endsection
