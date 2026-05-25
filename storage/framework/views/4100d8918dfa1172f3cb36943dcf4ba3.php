<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #f1f5f9; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
    </style>
</head>
<body>
    <div class="text-center">
        <i class="bi bi-search text-warning" style="font-size:5rem"></i>
        <h1 class="display-4 fw-bold mt-3">404</h1>
        <p class="text-muted fs-5">Halaman yang Anda cari tidak ditemukan.</p>
        <a href="<?php echo e(url('/')); ?>" class="btn btn-primary mt-2">
            <i class="bi bi-house me-1"></i>Kembali ke Dashboard
        </a>
    </div>
</body>
</html>
<?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/errors/404.blade.php ENDPATH**/ ?>