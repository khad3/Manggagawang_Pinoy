<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> Admin Login </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- fav icon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />

    <link rel="stylesheet" href="{{ asset('css/applicant/admin/login.css') }}">


</head>

<body>
    <div class="login-box text-center">
        <img src="{{ asset('img/logo2.png') }}" alt="TESDA Logo" class="tesda-logo">
        <h2>Super Admin Login</h2>

        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <form method="POST" action="{{ route('admin.login.store') }}">
            @csrf

            <div class="mb-3 text-start">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" required autofocus>
            </div>

            <div class="mb-3 text-start position-relative">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required
                    style="padding-right: 4rem;">
                <button type="button" id="togglePassword"
                    style="position: absolute; top: 50%; right: 0.5rem; transform: translateY(-50%); border: none; background: none; color: #007bff; cursor: pointer; font-weight: 500;">
                    Show
                </button>
            </div>

            <button type="submit" class="btn btn-tesda w-100 mt-3">Login</button>
        </form>

        <script>
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', () => {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    togglePassword.textContent = 'Hide';
                } else {
                    passwordInput.type = 'password';
                    togglePassword.textContent = 'Show';
                }
            });
        </script>

    </div>
</body>

</html>
