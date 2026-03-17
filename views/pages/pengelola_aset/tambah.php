<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Aset - Manajemen Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">Tambah Aset Baru</h2>
                <a href="?pg=pengelola_aset&&fl=pengelola" class="btn btn-primary me-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>    
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <form action="#" method="POST">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="namaAset" class="form-label fw-bold">Nama User</label>
                                <input type="text" class="form-control" id="namaAset" placeholder="Masukan Nama User" required>
                            </div>

                            <div class="col-md-6">
                                <label for="kategori" class="form-label fw-bold">Kategori</label>
                                <select class="form-select" id="kategori" required>
                                    <option value="" selected disabled>Pilih Kategori...</option>
                                    <option value="elektronik">Elektronik</option>
                                    <option value="furnitur">Furnitur</option>
                                    <option value="kendaraan">Kendaraan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="UserId" class="form-label fw-bold">User ID</label>
                                <input type="text" class="form-control" id="kodeAset" placeholder="ASR-000">
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal" class="form-label fw-bold">Tanggal Pembelian</label>
                                <input type="date" class="form-control" id="tanggal" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold d-block">Status Aset</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="aktif" value="aktif" checked>
                                    <label class="form-check-label" for="aktif">Aktif/Tersedia</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="rusak" value="rusak">
                                    <label class="form-check-label" for="rusak">Rusak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="dipinjam" value="dipinjam">
                                    <label class="form-check-label" for="dipinjam">Sedang Dipinjam</label>
                                </div>
                            </div>
                            <hr class="my-4">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="reset" class="btn btn-light me-2">Reset</button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-save me-2"></i> Simpan Aset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>