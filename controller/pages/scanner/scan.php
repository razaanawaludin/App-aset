<?php
$kode = $_GET['kode'] ?? '';

// Jika ada parameter kode dari hasil scan, proses pencarian aset
if (!empty($kode)) {
    try {
        $stmt = $koneksiku->prepare("SELECT IdAset FROM kelola_aset WHERE KodeAset = :kode LIMIT 1");
        $stmt->execute(['kode' => $kode]);
        $aset = $stmt->fetch();

        if ($aset) {
            $idAset = $aset['IdAset'];
            header("location:index.php?pg=kaset&fl=edit&id=$idAset");
            exit();
        } else {
            $_SESSION['alert'] = "HapusGagal"; // Kita pinjam alert merah, atau idealnya alert custom "Data tidak ditemukan"
            $errorMsg = "Aset dengan kode '$kode' tidak ditemukan.";
        }
    } catch (Exception $e) {
        $errorMsg = "Terjadi kesalahan saat mencari aset.";
    }
}
?>
