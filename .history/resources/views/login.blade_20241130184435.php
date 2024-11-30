<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Masuk / Daftar</title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Form Sign In -->
                <form action="{{ route('account.authenticate') }}" method="POST" class="sign-in-form">
                    <img src="{{ asset('img/INFO_MADANG.png') }}" class="image-title" alt="Logo">
                    <h2 class="title">Masuk</h2>
                    @csrf
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="email" placeholder="Masukkan email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Masukkan password" required />
                    </div>
                    @if ($errors->has('login_error'))
                        <div class="alert alert-danger">
                            <p>{{ $errors->first('login_error') }}</p>
                        </div>
                    @endif
                    <button type="submit" class="btn solid">Login</button>
                    <p class="social-text">Belum punya akun? <span id="showSignUp" class="text-teal-600 cursor-pointer">Daftar!</span></p>
                </form>

                <!-- Form Sign Up -->
                <form action="{{ route('account.processRegister') }}" method="POST" class="sign-up-form">
                    <img src="{{ asset('img/INFO_MADANG.png') }}" class="image-title" alt="Logo">
                    <h2 class="title">Daftar</h2>
                    @csrf
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" value="{{ old('name') }}" name="name" placeholder="Masukkan nama" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" value="{{ old('email') }}" name="email" placeholder="Masukkan email" required />
                    </div>
                    {{-- <div class="input-field">
                        <i class="fas fa-user-tag"></i>
                        <select name="role" id="role" class="role-dropdown" required>
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="owner">Owner Restoran</option>
                            <option value="pelanggan">Pelanggan</option>
                        </select>
                    </div> --}}
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" placeholder="Masukkan password" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi password" required />
                    </div>
                    @if ($errors->has('name'))
                        <div class="alert alert-danger">
                            <p>{{ $errors->first('name') }}</p>
                        </div>
                    @endif
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            <p>{{ $errors->first('email') }}</p>
                        </div>
                    @endif
                    @if ($errors->has('password'))
                        <div class="alert alert-danger">
                            <p>{{ $errors->first('password') }}</p>
                        </div>
                    @endif
                    @if ($errors->has('confirmed_password'))
                        <div class="alert alert-danger">
                            <p>{{ $errors->first('confirmed_password') }}</p>
                        </div>
                    @endif
                    @if (session('sukses'))
                        <div class="alert alert-success">
                            <p>{{ session('sukses') }}</p>
                        </div>
                    @endif
                    <button type="submit" class="btn">Register</button>
                    <p class="social-text">Sudah punya akun? <span id="showSignIn" class="text-teal-600 cursor-pointer">Masuk</span></p>
                </form>
            </div>
        </div>
    </div>

    <script>
        const container = document.querySelector(".container");
        const showSignUp = document.getElementById("showSignUp");
        const showSignIn = document.getElementById("showSignIn");
        const roleDropdown = document.getElementById("role");

        showSignUp.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
        });

        showSignIn.addEventListener("click", () => {
            container.classList.remove("sign-up-mode");
        });

        roleDropdown.addEventListener("change", () => {
            roleDropdown.style.transition = "all 0.3s ease";
            roleDropdown.style.transform = "scale(1.05)";
            setTimeout(() => {
                roleDropdown.style.transform = "scale(1)";
            }, 300);
        });

    </script>
</body>

</html>