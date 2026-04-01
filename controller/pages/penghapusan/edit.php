<?php
$id = $_GET['id'] ?? '';
$btn = $_POST['Btn'] ?? '';

// Ambil data pegawai untuk dropdown
try { $semuaPegawai = selectData($koneksiku, 'pegawai'); } catch (Exception $e) { $semuaPegawai = []; }

// Ambil data aset untuk dropdown
try { $semuaAset = selectData($koneksiku, 'kelola_aset'); } catch (Exception $e) { $semuaAset = []; }

// ========== AKSI: Update Header ==========
if ($btn === 'Simpan' && !empty($id)) {
    $penanggungJawab = $_POST['penanggung_jawab'] ?? '';
    $alasan          = $_POST['alasan'] ?? '';
    $keterangan      = $_POST['keterangan'] ?? '';
    $beritaAcara     = $_POST['berita_acara'] ?? '';

    try {
        $dataUpdate = [
            'IdPenanggungJawab' => !empty($penanggungJawab) ? $penanggungJawab : null,
            'AlasanPenghapusan' => $alasan,
            'Keterangan'        => $keterangan,
            'BeritaAcara'       => $beritaAcara
        ];
        $kondisi = ['IdPenghapusan' => $id];
        $simpan = updateData($koneksiku, 'penghapusan_aset', $dataUpdate, $kondisi);
        $_SESSION['alert'] = $simpan ? "SimpanBerhasil" : "SimpanGagal";
    } catch (Exception $e) {
        $_SESSION['alert'] = "SimpanGagal";
    }
    header("location:index.php?pg=$pg&fl=edit&id=$id");
    exit();
}

// ========== AKSI: Selesai (ubah status) ==========
if ($btn === 'Selesai' && !empty($id)) {
    try {
        $dataUpdate = ['Status' => 'selesai'];
        $kondisi = ['IdPenghapusan' => $id];
        $simpan = updateData($koneksiku, 'penghapusan_aset', $dataUpdate, $kondisi);
        $_SESSION['alert'] = $simpan ? "SimpanBerhasil" : "SimpanGagal";
    } catch (Exception $e) {
        $_SESSION['alert'] = "SimpanGagal";
    }
    header("location:index.php?pg=$pg&fl=kpenghapusan");
    exit();
}

// ========== AKSI: Tambah Aset ke Detail ==========
if ($btn === 'Tambah' && !empty($id)) {
    $idAset = $_POST['id_aset'] ?? '';
    if (!empty($idAset)) {
        try {
            // Cek apakah aset sudah ada di detail
            $stmt = $koneksiku->prepare("SELECT COUNT(*) as cnt FROM penghapusan_detail WHERE IdPenghapusan = :idPH AND IdAset = :idAset");
            $stmt->execute(['idPH' => $id, 'idAset' => $idAset]);
            $cek = $stmt->fetch();

            if ($cek['cnt'] == 0) {
                $dataBaru = [
                    'IdPenghapusan' => $id,
                    'IdAset'        => $idAset
                ];
                $simpan = insertData($koneksiku, 'penghapusan_detail', $dataBaru);
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
            $hapus = deleteData($koneksiku, 'penghapusan_detail', $kondisi);
            $_SESSION['alert'] = $hapus ? "HapusBerhasil" : "HapusGagal";
        } catch (Exception $e) {
            $_SESSION['alert'] = "HapusGagal";
        }
    }
    header("location:index.php?pg=$pg&fl=edit&id=$id");
    exit();
}

// ========== AKSI: Hapus seluruh dokumen (batal) ==========
if (isset($_GET['aksi']) && $_GET['aksi'] === 'hapus' && !empty($id)) {
    try {
        $stmtDel = $koneksiku->prepare("DELETE FROM penghapusan_detail WHERE IdPenghapusan = :id");
        $stmtDel->execute(['id' => $id]);
        $kondisi = ['IdPenghapusan' => $id];
        $hapus = deleteData($koneksiku, 'penghapusan_aset', $kondisi);
        $_SESSION['alert'] = $hapus ? "HapusBerhasil" : "HapusGagal";
    } catch (Exception $e) {
        $_SESSION['alert'] = "HapusGagal";
    }
    header("location:index.php?pg=$pg&fl=kpenghapusan");
    exit();
}

// ========== Ambil data untuk Edit ==========
$noPenghapusan_val = '';
$penanggungJawab_val = '';
$alasan_val = '';
$keterangan_val = '';
$beritaAcara_val = '';
$status_val = 'draft';
$detailAset = [];
$namaPenanggungJawab = '';
$tanggalDokumen = '';

if (!empty($id)) {
    try {
        $kondisi = ['IdPenghapusan' => $id];
        $hasil = selectData($koneksiku, 'penghapusan_aset', $kondisi);
        if (!empty($hasil)) {
            $data = $hasil[0];
            $noPenghapusan_val   = $data['NoPenghapusan'] ?? '';
            $penanggungJawab_val = $data['IdPenanggungJawab'] ?? '';
            $alasan_val          = $data['AlasanPenghapusan'] ?? '';
            $keterangan_val      = $data['Keterangan'] ?? '';
            $beritaAcara_val     = $data['BeritaAcara'] ?? '';
            $status_val          = $data['Status'] ?? 'draft';
            $tanggalDokumen      = $data['Create_at'] ?? '';

            // Ambil nama penanggung jawab untuk cetak
            if (!empty($penanggungJawab_val)) {
                try {
                    $stmtP = $koneksiku->prepare("SELECT Nama FROM pegawai WHERE IdPegawai = :id");
                    $stmtP->execute(['id' => $penanggungJawab_val]);
                    $pRow = $stmtP->fetch();
                    $namaPenanggungJawab = $pRow['Nama'] ?? '';
                } catch (Exception $e) {}
            }
        }
    } catch (Exception $e) {}

    // Ambil detail aset
    try {
        $stmt = $koneksiku->prepare("
            SELECT d.IdDetail, d.IdAset, a.KodeAset, a.NamaAset, a.Kategori, a.FotoAset
            FROM penghapusan_detail d
            LEFT JOIN kelola_aset a ON d.IdAset = a.IdAset
            WHERE d.IdPenghapusan = :id
        ");
        $stmt->execute(['id' => $id]);
        $detailAset = $stmt->fetchAll();
    } catch (Exception $e) {
        $detailAset = [];
    }
}
?>
