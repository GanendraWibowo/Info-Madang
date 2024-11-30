@extends('layouts.apel')

@section('content')
<div class="container">
    <h2 class="mt-1 text-center">Informasi Profil</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Selamat Datang!</h2>
                    <p class="card-text">{{ Auth::user()->name }}!</p>
                    <hr>
                    <h5 class="card-subtitle mb-2 text-muted">Informasi Akun</h5>
                    <p>Nama Pengguna: {{ Auth::user()->name }}</p>
                    <p>Role: {{ Auth::user()->role }}</p>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection