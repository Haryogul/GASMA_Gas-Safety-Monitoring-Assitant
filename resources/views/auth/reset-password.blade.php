<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GASMA - Atur Ulang Kata Sandi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; display: flex; align-items: center; min-height: 100vh; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .btn-primary { background-color: #1e88e5; border: none; padding: 12px; border-radius: 8px; }
        .btn-primary:hover { background-color: #1565c0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card p-4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-dark">GASMA</h3>
                        <p class="text-muted small">Atur Ulang Kata Sandi Akun Anda</p>
                    </div>

                    <form action="{{ route('password.update.post') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Alamat Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email terdaftar" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Kata Sandi Baru</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 5 karakter" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi baru" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold">SIMPAN PERUBAHAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>