<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Admin Login </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- fav icon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">



    <!-- Inline TESDA Theme Styling -->
   <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

body {
    background: linear-gradient(135deg, #007bff, #0056b3);
    font-family: 'Poppins', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    margin: 0;
}

.login-container {
    background: linear-gradient(135deg, #007bff, #0056b3);
    font-family: 'Poppins', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    margin: 0;
    padding: 20px;
}

.login-box {
    background: #fff;
    color: #333;
    padding: 3rem 2rem;
    border-radius: 20px;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 420px;
    transition: all 0.3s ease;
}

.login-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.tesda-logo {
    width: 70px;
    margin-bottom: 1rem;
    border-radius: 50%;
    box-shadow: 0 2px 10px rgba(0, 86, 179, 0.3);
}

.login-box h2 {
    font-weight: 600;
    color: #0056b3;
    margin-bottom: 2rem;
}

.form-label {
    font-weight: 500;
    color: #333;
}

.form-control {
    border-radius: 12px;
    border: 1px solid #ced4da;
    padding: 0.75rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn-tesda {
    background: linear-gradient(to right, #0056b3, #007bff);
    color: #fff;
    border: none;
    padding: 0.75rem;
    border-radius: 12px;
    font-weight: 500;
    font-size: 1rem;
    transition: background 0.3s ease;
}

.btn-tesda:hover {
    background: linear-gradient(to right, #004a99, #006be1);
    color: #fff;
}

.alert-danger {
    background-color: #fdecea;
    color: #d93025;
    border-radius: 10px;
    font-size: 0.9rem;
    padding: 0.75rem;
    margin-top: 1rem;
    border: none;
}

@media (max-width: 576px) { 
    .login-box {
        padding: 2rem 1.5rem;
    }
}
</style>

</head>
<body>
    <div class="login-box text-center">
        <img src="{{ asset('img/logo.png') }}" alt="TESDA Logo" class="tesda-logo">
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

            <div class="mb-3 text-start">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-tesda w-100 mt-3">Login</button>
        </form>
    </div>
</body>
</html>
