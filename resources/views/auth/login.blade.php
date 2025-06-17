<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Wedding Nest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #f8f9fa;
            --accent-color: #3498db;
            --text-color: #2c3e50;
            --bg-color: #f5f6fa;
            --card-bg: #ffffff;
            --border-color: #e9ecef;
        }
        html, body {
            height: 100dvh;
            margin: 0;
            padding: 0;
        }
        body {
            background: linear-gradient(135deg, var(--bg-color) 0%, #e3f2fd 100%);
            color: var(--text-color);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            border-radius: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
            max-width: 400px;
        }
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.15);
        }
        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
            transform: translateY(-2px);
        }
        .form-control {
            padding: 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
            transform: translateY(-1px);
        }
        .input-group-text {
            border-radius: 8px;
            padding: 12px;
        }
        .logo-container {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .logo-container img {
            width: 80px;
            height: 80px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .logo-container:hover img {
            transform: scale(1.05);
        }
        .form-check-input:checked {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        .alert {
            border-radius: 8px;
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container-fluid p-4">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="login-card animate__animated animate__fadeIn">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="logo-container">
                                <img src="https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?w=80&h=80&fit=crop" alt="Logo" class="animate__animated animate__bounceIn">
                            </div>
                            <h2 class="text-primary mb-2 animate__animated animate__fadeInDown">Welcome Back</h2>
                            <p class="text-muted animate__animated animate__fadeInUp">Please sign in to your account</p>
                        </div>
                        
                        @if(session('error'))
                            <div class="alert alert-danger animate__animated animate__shakeX">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST" class="animate__animated animate__fadeIn">
                            @csrf
                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="email" class="form-control @error('login') is-invalid @enderror" 
                                        id="login" name="login" 
                                        placeholder="Email or Username" 
                                        value="{{ old('login') }}"
                                        required>
                                </div>
                                @error('login')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                        id="password" name="password" 
                                        placeholder="Password" 
                                        required>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                    <label class="form-check-label" for="remember_me">Remember me</label>
                                </div>
                                <a href="#" class="text-decoration-none">Forgot password?</a>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Sign in
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
