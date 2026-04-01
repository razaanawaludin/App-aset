<?php
$id = $_GET['id'] ?? '';

// Hapus serah terima
if ($ak === 'hapus' && !empty($id)) {
    try {
        // Hapus detail dulu
        $stmtDel = $koneksiku->prepare("DELETE FROM serah_terima_detail WHERE IdSerahTerima = :id");
        $stmtDel->execute(['id' => $id]);
        // Hapus header
        $kondisi = ['IdSerahTerima' => $id];
        $hapus = deleteData($koneksiku, 'serah_terima', $kondisi);
        $_SESSION['alert'] = $hapus ? "HapusBerhasil" : "HapusGagal";
    } catch (Exception $e) {
        $_SESSION['alert'] = "HapusGagal";
    }
    header("location:index.php?pg=$pg&fl=$fl");
    exit();
}

// Ambil semua data serah terima dengan JOIN ke pegawai
try {
    $stmt = $koneksiku->query("
        SELECT st.*, 
               p1.Nama as NamaPenyerah, 
               p2.Nama as NamaPenerima,
               (SELECT COUNT(*) FROM serah_terima_detail WHERE IdSerahTerima = st.IdSerahTerima) as JumlahAset
        FROM serah_terima st
        LEFT JOIN pegawai p1 ON st.IdPenyerah = p1.IdPegawai
        LEFT JOIN pegawai p2 ON st.IdPenerima = p2.IdPegawai
        ORDER BY st.Create_at DESC
    ");
    $semuaSerahTerima = $stmt->fetchAll();
} catch (Exception $e) {
    $semuaSerahTerima = [];
}

$jumlahST = count($semuaSerahTerima);
?>
