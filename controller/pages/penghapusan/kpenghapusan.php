<?php
$id = $_GET['id'] ?? '';

// Pastikan tabel ada
try {
    $koneksiku->query("SELECT 1 FROM penghapusan_aset LIMIT 1");
} catch (Exception $e) {
    $sqlCreate = "CREATE TABLE IF NOT EXISTS penghapusan_aset (
        IdPenghapusan INT AUTO_INCREMENT PRIMARY KEY,
        NoPenghapusan VARCHAR(50) NOT NULL,
        IdPenanggungJawab INT DEFAULT NULL,
        AlasanPenghapusan VARCHAR(100) NOT NULL,
        Keterangan TEXT DEFAULT NULL,
        BeritaAcara TEXT DEFAULT NULL,
        Status VARCHAR(30) NOT NULL DEFAULT 'draft',
        Create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $koneksiku->exec($sqlCreate);
}

try {
    $koneksiku->query("SELECT 1 FROM penghapusan_detail LIMIT 1");
} catch (Exception $e) {
    $sqlCreate2 = "CREATE TABLE IF NOT EXISTS penghapusan_detail (
        IdDetail INT AUTO_INCREMENT PRIMARY KEY,
        IdPenghapusan INT NOT NULL,
        IdAset INT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $koneksiku->exec($sqlCreate2);
}

// Hapus dokumen penghapusan
if ($ak === 'hapus' && !empty($id)) {
    try {
        // Hapus detail dulu
        $stmtDel = $koneksiku->prepare("DELETE FROM penghapusan_detail WHERE IdPenghapusan = :id");
        $stmtDel->execute(['id' => $id]);
        // Hapus header
        $kondisi = ['IdPenghapusan' => $id];
        $hapus = deleteData($koneksiku, 'penghapusan_aset', $kondisi);
        $_SESSION['alert'] = $hapus ? "HapusBerhasil" : "HapusGagal";
    } catch (Exception $e) {
        $_SESSION['alert'] = "HapusGagal";
    }
    header("location:index.php?pg=$pg&fl=$fl");
    exit();
}

// Ambil semua data penghapusan dengan JOIN ke pegawai
try {
    $stmt = $koneksiku->query("
        SELECT ph.*, 
               p.Nama as NamaPenanggungJawab,
               (SELECT COUNT(*) FROM penghapusan_detail WHERE IdPenghapusan = ph.IdPenghapusan) as JumlahAset
        FROM penghapusan_aset ph
        LEFT JOIN pegawai p ON ph.IdPenanggungJawab = p.IdPegawai
        ORDER BY ph.Create_at DESC
    ");
    $semuaPenghapusan = $stmt->fetchAll();
} catch (Exception $e) {
    $semuaPenghapusan = [];
}

$jumlahPH = count($semuaPenghapusan);
?>
