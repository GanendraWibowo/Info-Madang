@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Selamat Datang!</h2>
                    <p class="card-text">Selamat datang, {{ Auth::user()->username }}!</p>
                    <hr>
                    <h5 class="card-subtitle mb-2 text-muted">Informasi Akun</h5>
                    <p>Nama Pengguna: {{ Auth::user()->username }}</p>
                    <p>Role: {{ Auth::user()->role }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Ganti Password</h2>
                    <form action="{{ route('owner.updatePassword') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="current_password">Password Lama:</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Password Baru:</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Ganti Password</button>
                    </form>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
