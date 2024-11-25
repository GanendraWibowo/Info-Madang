@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="text-center">
        <h1>404</h1>
        <h2>Halaman Tidak Ditemukan</h2>
        <p>Maaf, halaman yang Anda cari tidak dapat ditemukan.</p>
        <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
    </div>
</div>
@endsection
