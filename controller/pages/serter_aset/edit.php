<?php
$id = $_GET['id'] ?? '';
$btn = $_POST['Btn'] ?? '';

// Ambil data pegawai untuk dropdown
try { $semuaPegawai = selectData($koneksiku, 'pegawai'); } catch (Exception $e) { $semuaPegawai = []; }

// Ambil data aset untuk dropdown
try { $semuaAset = selectData($koneksiku, 'kelola_aset'); } catch (Exception $e) { $semuaAset = []; }

// ========== AKSI: Update Header ==========
if ($btn === 'Simpan' && !empty($id)) {
    $penyerah = $_POST['penyerah'] ?? '';
    $penerima = $_POST['penerima'] ?? '';
    $keterangan = $_POST['keterangan'] ?? '';
    $beritaAcara = $_POST['berita_acara'] ?? '';

    if (!empty($penyerah) && !empty($penerima)) {
        try {
            $dataUpdate = [
                'IdPenyerah'  => $penyerah,
                'IdPenerima'  => $penerima,
                'Keterangan'  => $keterangan,
                'BeritaAcara' => $beritaAcara
            ];
            $kondisi = ['IdSerahTerima' => $id];
            $simpan = updateData($koneksiku, 'serah_terima', $dataUpdate, $kondisi);
            $_SESSION['alert'] = $simpan ? "SimpanBerhasil" : "SimpanGagal";
        } catch (Exception $e) {
            $_SESSION['alert'] = "SimpanGagal";
        }
    }
    header("location:index.php?pg=$pg&fl=edit&id=$id");
    exit();
}

// ========== AKSI: Selesai (ubah status) ==========
if ($btn === 'Selesai' && !empty($id)) {
    try {
        $dataUpdate = ['Status' => 'selesai'];
        $kondisi = ['IdSerahTerima' => $id];
        $simpan = updateData($koneksiku, 'serah_terima', $dataUpdate, $kondisi);
        $_SESSION['alert'] = $simpan ? "SimpanBerhasil" : "SimpanGagal";
    } catch (Exception $e) {
        $_SESSION['alert'] = "SimpanGagal";
    }
    header("location:index.php?pg=$pg&fl=kserah");
    exit();
}

// ========== AKSI: Tambah Aset ke Detail ==========
if ($btn === 'Tambah' && !empty($id)) {
    $idAset = $_POST['id_aset'] ?? '';
    if (!empty($idAset)) {
        try {
            // Cek apakah aset sudah ada di detail
            $stmt = $koneksiku->prepare("SELECT COUNT(*) as cnt FROM serah_terima_detail WHERE IdSerahTerima = :idST AND IdAset = :idAset");
            $stmt->execute(['idST' => $id, 'idAset' => $idAset]);
            $cek = $stmt->fetch();

            if ($cek['cnt'] == 0) {
                $dataBaru = [
                    'IdSerahTerima' => $id,
                    'IdAset'        => $idAset
                ];
                $simpan = insertData($koneksiku, 'serah_terima_detail', $dataBaru);
                $_SESSION['alert'] = $simpan ? "SimpanBerhasil" : "SimpanGagal";
            } else {
                $_SESSION['alert'] = "SimpanGagal";
            }
        } catch (Exception $e) {
            $_SESSION['alert'] = "SimpanGagal";
        }
    }
    header("location:index.php?pg=$pg&fl=edit&id=$id");
    exit();
}

// ========== AKSI: Hapus Aset dari Detail ==========
if (isset($_GET['aksi']) && $_GET['aksi'] === 'hapusbarang' && !empty($id)) {
    $idDetail = $_GET['idDetail'] ?? '';
    if (!empty($idDetail)) {
        try {
            $kondisi = ['IdDetail' => $idDetail];
            $hapus = deleteData($koneksiku, 'serah_terima_detail', $kondisi);
            $_SESSION['alert'] = $hapus ? "HapusBerhasil" : "HapusGagal";
        } catch (Exception $e) {
            $_SESSION['alert'] = "HapusGagal";
        }
    }
    header("location:index.php?pg=$pg&fl=edit&id=$id");
    exit();
}

// ========== AKSI: Hapus seluruh serah terima (batal) ==========
if (isset($_GET['aksi']) && $_GET['aksi'] === 'hapus' && !empty($id)) {
    try {
        $stmtDel = $koneksiku->prepare("DELETE FROM serah_terima_detail WHERE IdSerahTerima = :id");
        $stmtDel->execute(['id' => $id]);
        $kondisi = ['IdSerahTerima' => $id];
        $hapus = deleteData($koneksiku, 'serah_terima', $kondisi);
        $_SESSION['alert'] = $hapus ? "HapusBerhasil" : "HapusGagal";
    } catch (Exception $e) {
        $_SESSION['alert'] = "HapusGagal";
    }
    header("location:index.php?pg=$pg&fl=kserah");
    exit();
}

// ========== Ambil data untuk Edit ==========
$noSurat_val = '';
$penyerah_val = '';
$penerima_val = '';
$keterangan_val = '';
$beritaAcara_val = '';
$status_val = 'draft';
$detailAset = [];
$namaPenyerah = '';
$namaPenerima = '';
$tanggalDokumen = '';

if (!empty($id)) {
    try {
        $kondisi = ['IdSerahTerima' => $id];
        $hasil = selectData($koneksiku, 'serah_terima', $kondisi);
        if (!empty($hasil)) {
            $data = $hasil[0];
            $noSurat_val     = $data['NoSerahTerima'] ?? '';
            $penyerah_val    = $data['IdPenyerah'] ?? '';
            $penerima_val    = $data['IdPenerima'] ?? '';
            $keterangan_val  = $data['Keterangan'] ?? '';
            $beritaAcara_val = $data['BeritaAcara'] ?? '';
            $status_val      = $data['Status'] ?? 'draft';
            $tanggalDokumen  = $data['Create_at'] ?? '';

            // Ambil nama pegawai untuk cetak
            try {
                $stmtP = $koneksiku->prepare("SELECT Nama FROM pegawai WHERE IdPegawai = :id");
                $stmtP->execute(['id' => $penyerah_val]);
                $pRow = $stmtP->fetch();
                $namaPenyerah = $pRow['Nama'] ?? '';

                $stmtP->execute(['id' => $penerima_val]);
                $pRow = $stmtP->fetch();
                $namaPenerima = $pRow['Nama'] ?? '';
            } catch (Exception $e) {}
        }
    } catch (Exception $e) {}

    // Ambil detail aset
    try {
        $stmt = $koneksiku->prepare("
            SELECT d.IdDetail, d.IdAset, a.KodeAset, a.NamaAset, a.Kategori, a.FotoAset
            FROM serah_terima_detail d
            LEFT JOIN kelola_aset a ON d.IdAset = a.IdAset
            WHERE d.IdSerahTerima = :id
        ");
        $stmt->execute(['id' => $id]);
        $detailAset = $stmt->fetchAll();
    } catch (Exception $e) {
        $detailAset = [];
    }
}
?>
