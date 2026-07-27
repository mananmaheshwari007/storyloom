<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin Login | Storyloom CMS</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #182233;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      color: #333;
    }
    .login-card {
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
      width: 100%;
      max-width: 440px;
      padding: 40px;
    }
    .brand-title {
      font-family: 'Cormorant Garamond', Georgia, serif;
      font-weight: 700;
      font-size: 28px;
      color: #1c222b;
      margin-bottom: 4px;
    }
    .btn-primary {
      background-color: #b55b29;
      border-color: #b55b29;
      padding: 12px;
      font-weight: 600;
      letter-spacing: 0.05em;
    }
    .btn-primary:hover {
      background-color: #96471d;
      border-color: #96471d;
    }
    .form-control:focus {
      border-color: #b55b29;
      box-shadow: 0 0 0 0.25rem rgba(181, 91, 41, 0.25);
    }
  </style>
</head>
<body>

  <div class="login-card">
    <div class="text-center mb-4">
      <img src="{{ asset('assets/img/logo-emblem.png') }}" alt="Storyloom Emblem" width="48" height="47" class="mb-2">
      <h1 class="brand-title">Storyloom CMS</h1>
      <p class="text-muted small">Enter your credentials to access the admin panel</p>
    </div>

    @if (session('status'))
      <div class="alert alert-success small mb-3">
        {{ session('status') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger small mb-3">
        <ul class="mb-0 ps-3">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div class="mb-3">
        <label for="email" class="form-label fw-medium text-secondary small">Email Address</label>
        <div class="input-group">
          <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', 'admin@storyloom.in') }}" required autofocus placeholder="admin@storyloom.in">
        </div>
      </div>

      <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <label for="password" class="form-label fw-medium text-secondary small mb-0">Password</label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-decoration-none small text-muted">Forgot?</a>
          @endif
        </div>
        <div class="input-group">
          <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
          <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="••••••••">
        </div>
      </div>

      <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label text-muted small" for="remember">Remember me on this device</label>
      </div>

      <button type="submit" class="btn btn-primary w-100 rounded-2 text-uppercase">Log In to Dashboard</button>
    </form>

    <div class="mt-4 pt-3 border-top text-center">
      <a href="{{ route('home') }}" class="text-muted small text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i> Back to Main Website
      </a>
    </div>
  </div>

</body>
</html>
