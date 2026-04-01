<?php
$id = $_GET['id'] ?? '';

// Ambil data BAST untuk cetak
$bastData = [];
$detailAset = [];
$namaPenyerah = '';
$namaPenerima = '';

if (!empty($id)) {
    try {
        $kondisi = ['IdBast' => $id];
        $hasil = selectData($koneksiku, 'bast', $kondisi);
        if (!empty($hasil)) {
            $bastData = $hasil[0];

            // Ambil nama pegawai
            $stmtP = $koneksiku->prepare("SELECT Nama, Username FROM pegawai WHERE IdPegawai = :id");
            $stmtP->execute(['id' => $bastData['IdPenyerah']]);
            $pRow = $stmtP->fetch();
            $namaPenyerah = $pRow['Nama'] ?? '';

            $stmtP->execute(['id' => $bastData['IdPenerima']]);
            $pRow = $stmtP->fetch();
            $namaPenerima = $pRow['Nama'] ?? '';
        }
    } catch (Exception $e) {}

    // Ambil detail aset
    try {
        $stmt = $koneksiku->prepare("
            SELECT d.IdBastDetail, d.IdAset, a.KodeAset, a.NamaAset, a.Kategori, a.KondisiAset
            FROM bast_detail d
            LEFT JOIN kelola_aset a ON d.IdAset = a.IdAset
            WHERE d.IdBast = :id
        ");
        $stmt->execute(['id' => $id]);
        $detailAset = $stmt->fetchAll();
    } catch (Exception $e) {
        $detailAset = [];
    }
}
?>
