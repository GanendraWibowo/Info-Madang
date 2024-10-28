<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('login.css') }}">
    <title>Login / Sign Up</title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Form Sign In -->
                <form action="{{ route('account.authenticate')}}" method="POST" class="sign-in-form">
                <img src="{{ asset('img/INFO_MADANG.png') }}" class="image-title" alt="Logo">                    
                <h2 class="title">Login</h2>
                    @csrf
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Masukkan username" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Masukkan password" required />
                    </div>
                    <button type="submit" class="btn solid">Login</button>
                    <p class="social-text">Belum punya akun? <span id="showSignUp" class="text-teal-600 cursor-pointer">Sign Up</span></p>
                </form>

                <!-- Form Sign Up -->
                <form action="" method="POST" class="sign-up-form">
                    <h2 class="title">Sign Up</h2>
                    @csrf
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Masukkan username" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Masukkan email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Masukkan password" required />
                    </div>
                    <button type="submit" class="btn">Sign Up</button>
                    <p class="social-text">Sudah punya akun? <span id="showSignIn" class="text-teal-600 cursor-pointer">Login</span></p>
                </form>
            </div>
        </div>        
    </div>

    <script>
        const container = document.querySelector(".container");
        const showSignUp = document.getElementById("showSignUp");
        const showSignIn = document.getElementById("showSignIn");

        showSignUp.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
        });

        showSignIn.addEventListener("click", () => {
            container.classList.remove("sign-up-mode");
        });
    </script>
</body>

</html>
