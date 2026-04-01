<?php
$id = $_GET['id'] ?? '';
$idUser = $_SESSION['IdUser'] ?? '';

// Hapus BAST
if ($ak === 'hapus' && !empty($id)) {
    try {
        $stmtDel = $koneksiku->prepare("DELETE FROM bast_detail WHERE IdBast = :id");
        $stmtDel->execute(['id' => $id]);
        $kondisi = ['IdBast' => $id];
        $hapus = deleteData($koneksiku, 'bast', $kondisi);
        $_SESSION['alert'] = $hapus ? "HapusBerhasil" : "HapusGagal";
    } catch (Exception $e) {
        $_SESSION['alert'] = "HapusGagal";
    }
    header("location:index.php?pg=$pg&fl=$fl");
    exit();
}

// Ambil semua data BAST
try {
    $stmt = $koneksiku->query("
        SELECT b.*, 
               p1.Nama as NamaPenyerah, 
               p2.Nama as NamaPenerima,
               (SELECT COUNT(*) FROM bast_detail WHERE IdBast = b.IdBast) as JumlahAset
        FROM bast b
        LEFT JOIN pegawai p1 ON b.IdPenyerah = p1.IdPegawai
        LEFT JOIN pegawai p2 ON b.IdPenerima = p2.IdPegawai
        ORDER BY b.Create_at DESC
    ");
    $semuaBast = $stmt->fetchAll();
} catch (Exception $e) {
    $semuaBast = [];
}

$jumlahBast = count($semuaBast);
?>
