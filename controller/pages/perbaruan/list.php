<?php
$id = $_GET['id'] ?? '';
$ak = $_GET['ak'] ?? '';

// Pastikan tabel ada
try {
    $koneksiku->query("SELECT 1 FROM perbaruan_aset LIMIT 1");
} catch (Exception $e) {
    // Auto-create tabel jika belum ada
    $sqlCreate = "CREATE TABLE IF NOT EXISTS perbaruan_aset (
        IdPerbaruan INT AUTO_INCREMENT PRIMARY KEY,
        IdAset INT NOT NULL,
        TanggalMulai DATE NOT NULL,
        TanggalSelesai DATE DEFAULT NULL,
        JenisPerbaruan VARCHAR(100) NOT NULL,
        Deskripsi TEXT DEFAULT NULL,
        Teknisi VARCHAR(150) DEFAULT NULL,
        Biaya DECIMAL(15,2) DEFAULT 0,
        Status VARCHAR(30) NOT NULL DEFAULT 'proses',
        Catatan TEXT DEFAULT NULL,
        TanggalDibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $koneksiku->exec($sqlCreate);
}

// Ambil semua data perbaruan + nama aset
try {
    $stmt = $koneksiku->query("
        SELECT p.*, k.KodeAset, k.NamaAset, k.FotoAset, k.Kategori
        FROM perbaruan_aset p
        LEFT JOIN kelola_aset k ON p.IdAset = k.IdAset
        ORDER BY p.TanggalDibuat DESC
    ");
    $semuaPerbaruan = $stmt->fetchAll();
} catch (Exception $e) {
    $semuaPerbaruan = [];
}
$jumlahPerbaruan = count($semuaPerbaruan);

// Hitung statistik
$totalProses = 0;
$totalSelesai = 0;
$totalBiaya = 0;
foreach ($semuaPerbaruan as $row) {
    if ($row['Status'] === 'proses') $totalProses++;
    if ($row['Status'] === 'selesai') $totalSelesai++;
    $totalBiaya += floatval($row['Biaya']);
}

// Hapus data
if ($ak === 'hapus' && !empty($id)) {
    $kondisi = ['IdPerbaruan' => $id];
    $hapus = deleteData($koneksiku, 'perbaruan_aset', $kondisi);
    if ($hapus) {
        $_SESSION['alert'] = "HapusBerhasil";
    } else {
        $_SESSION['alert'] = "HapusGagal";
    }
    header("location:index.php?pg=$pg&fl=$fl");
    exit();
}
?>
