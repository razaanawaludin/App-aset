<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penghapusan Aset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title text-danger mb-0">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Penghapusan Aset
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-warning mb-4">
                        <strong>Perhatian!</strong> Tindakan ini tidak dapat dibatalkan. Pastikan Anda telah memeriksa detail aset sebelum melanjutkan.
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Detail Aset:</h6>
                        <table class="table table-sm table-bordered">
                            <tr class="table-secondary">
                                <th width="30%">ID Aset</th>
                                <td>#AST-2024-0012</td>
                            </tr>
                            <tr>
                                <th>Nama Aset</th>
                                <td>MacBook Pro M3 14" (Silver)</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>Elektronik / Laptop</td>
                            </tr>
                            <tr>
                                <th>Nilai Buku</th>
                                <td>Rp 28.500.000</td>
                            </tr>
                        </table>
                    </div>

                    <form>
                        <div class="mb-3">
                            <label for="alasan" class="form-label fw-bold">Alasan Penghapusan</label>
                            <select class="form-select" id="alasan" required>
                                <option value="" selected disabled>Pilih alasan...</option>
                                <option value="rusak">Rusak Berat / Tidak Bisa Dipakai</option>
                                <option value="hilang">Kehilangan / Pencurian</option>
                                <option value="dijual">Penjualan Aset</option>
                                <option value="hibah">Hibah / Donasi</option>
                                <option value="kadaluarsa">Masa Pakai Habis (Depresiasi Penuh)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="catatan" class="form-label fw-bold">Catatan Tambahan (Opsional)</label>
                            <textarea class="form-control" id="catatan" rows="3" placeholder="Contoh: Berita acara kerusakan nomor 123..."></textarea>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="confirmCheck" required>
                            <label class="form-check-label" for="confirmCheck">
                                Saya sadar bahwa data aset ini akan dihapus secara permanen dari sistem.
                            </label>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="?pg=penghapusan&&fl=kpenghapusan" class="btn btn-outline-secondary px-4">Batal</a>
                            <a href="?pg=penghapusan&&fl=" class="btn btn-danger shadow-sm">
                <i class="bi bi-trash3 me-2"></i>Hapus Aset Sekarang</a> 
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