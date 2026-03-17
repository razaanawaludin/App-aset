<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengelola Aset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: bold; }
        .card-stats { border-left: 5px solid #0d6efd; }
    </style>
</head>
<body>

<div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4">Penghapusan Aset</h2>
            <a href="?pg=penghapusan&&fl=tambah" class="btn btn-danger shadow-sm">Tambah penghapusan</a>     
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">ID</th>
                                <th>Nama user</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal Perolehan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td class="ps-3">#ASR-001</td>
                                <td>Budi Santoso</td>
                                <td>Furnitur</td>
                                <td><span class="badge bg-success">Aktif</span></td>
                                <td>12 Jan 2024</td>
                                <td class="text-center">
                                    <a href="?pg=penghapusan&&fl=" class="btn btn-primary shadow-sm"><i class="bi bi-pencil small"></i></a>
                                    <a href="?pg=penghapusan&&fl=hapus" class="btn btn-danger shadow-sm"><i class="bi bi-trash small"></i></a> 
                                </td>
                            </tr> -->
                            <tr>
                                <td class="ps-3">#ASR-191</td>
                                <td>Razzaror</td>
                                <td>Elektronik</td>
                                <td><span class="badge bg-warning text-dark">Maintenance</span></td>
                                <td>05 Feb 2024</td>
                                <td class="text-center">
                                    <a href="?pg=penghapusan&&fl=edit" class="btn btn-primary shadow-sm"><i class="bi bi-pencil small"></i></a>
                                    <a href="?pg=penghapusan&&fl=hapus" class="btn btn-danger shadow-sm"><i class="bi bi-trash small"></i></a> 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>