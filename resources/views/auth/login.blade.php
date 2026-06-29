<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMKOP PKK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { border-radius: 16px; width: 100%; max-width: 400px; }
    </style>
</head>
<body>
    <div class="card login-card border-0 shadow-sm p-4 bg-white">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary mb-1">🌸 SIMKOP PKK</h3>
            <small class="text-muted">Kelurahan Cijoho - Silakan Masuk</small>
        </div>

        @if($errors->any())
            <div class="alert alert-danger border-0 small py-2" style="border-radius: 8px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Alamat Email</label>
                <input type="email" name="email" class="form-control shadow-none" placeholder="admin@gmail.com" value="{{ old('email') }}" required>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold text-muted">Password</label>
                <input type="password" name="password" class="form-control shadow-none" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm" style="border-radius: 8px;">Masuk Sistem</button>
        </form>
    </div>
</body>
</html>