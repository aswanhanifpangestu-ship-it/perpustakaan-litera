<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #f1f5f9; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
    </style>
</head>
<body>
    <div class="text-center">
        <i class="bi bi-shield-x text-danger" style="font-size:5rem"></i>
        <h1 class="display-4 fw-bold mt-3">403</h1>
        <p class="text-muted fs-5">Anda tidak memiliki akses ke halaman ini.</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-2">
            <i class="bi bi-house me-1"></i>Kembali ke Dashboard
        </a>
    </div>
</body>
</html>
