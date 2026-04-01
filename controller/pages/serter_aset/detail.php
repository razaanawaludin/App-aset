<?php
$id = $_GET['id'] ?? '';
$btn = $_POST['Btn'] ?? '';

// Ambil data pegawai untuk dropdown
try { $semuaPegawai = selectData($koneksiku, 'pegawai'); } catch (Exception $e) { $semuaPegawai = []; }

// Ambil data aset untuk dropdown
try { $semuaAset = selectData($koneksiku, 'kelola_aset'); } catch (Exception $e) { $semuaAset = []; }

// Auto-bikin tabel BAST sekalian agar tidak error saat generate otomatis
try {
    $koneksiku->exec("
        CREATE TABLE IF NOT EXISTS bast (
            IdBast INT AUTO_INCREMENT PRIMARY KEY,
            NoBast VARCHAR(50) NOT NULL,
            IdPenyerah INT NOT NULL,
            IdPenerima INT NOT NULL,
            Keterangan TEXT,
            Status ENUM('menunggu','selesai (approved)') NOT NULL DEFAULT 'menunggu',
            ApproveSerah TINYINT(1) NOT NULL DEFAULT 0,
            ApproveTerima TINYINT(1) NOT NULL DEFAULT 0,
            Create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS bast_detail (
            IdBastDetail INT AUTO_INCREMENT PRIMARY KEY,
            IdBast INT NOT NULL,
            IdAset INT NOT NULL,
            FOREIGN KEY (IdBast) REFERENCES bast(IdBast) ON DELETE CASCADE
        );
    ");
} catch (Exception $e) {}

// Fungsi generate nomor surat otomatis
function generateNoSerahTerima($koneksiku) {
    try {
        $stmt = $koneksiku->query("SELECT MAX(IdSerahTerima) as maxId FROM serah_terima");
        $result = $stmt->fetch();
        $nextId = ($result['maxId'] ?? 0) + 1;
        $bulan = date('m');
        $tahun = date('Y');
        return 'ST/' . str_pad($nextId, 4, '0', STR_PAD_LEFT) . '/' . $bulan . '/' . $tahun;
    } catch (Exception $e) {
        return 'ST/0001/' . date('m') . '/' . date('Y');
    }
}

// ========== AKSI: Buat Baru / Simpan Header ==========
if ($btn === 'Buat Dokumen') {
    $noSurat = generateNoSerahTerima($koneksiku);
    $penyerah = $_POST['penyerah'] ?? '';
    $penerima = $_POST['penerima'] ?? '';
    $keterangan = $_POST['keterangan'] ?? '';
    $beritaAcara = $_POST['berita_acara'] ?? '';

    if (!empty($penyerah) && !empty($penerima)) {
        try {
            $dataBaru = [
                'NoSerahTerima' => $noSurat,
                'IdPenyerah'    => $penyerah,
                'IdPenerima'    => $penerima,
                'Keterangan'    => $keterangan,
                'BeritaAcara'   => $beritaAcara,
                'Status'        => 'draft'
            ];
            $simpan = insertData($koneksiku, 'serah_terima', $dataBaru);
            if ($simpan) {
                // Ambil ID yang baru dibuat
                $newId = $koneksiku->lastInsertId();
                $_SESSION['alert'] = "SimpanBerhasil";
                header("location:index.php?pg=$pg&fl=detail&ak=edit&id=$newId");
                exit();
            } else {
                $_SESSION['alert'] = "SimpanGagal";
            }
        } catch (Exception $e) {
            $_SESSION['alert'] = "SimpanGagal";
        }
    } else {
        $_SESSION['alert'] = "SimpanGagal";
    }
    header("location:index.php?pg=$pg&fl=detail&ak=tambah");
    exit();
}

// ========== AKSI: Update Header ==========
if ($btn === 'Simpan' && $ak === 'edit' && !empty($id)) {
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
    header("location:index.php?pg=$pg&fl=detail&ak=edit&id=$id");
    exit();
}

// ========== AKSI: Selesai (ubah status) ==========
if ($btn === 'Selesai' && !empty($id)) {
    try {
        $dataUpdate = ['Status' => 'selesai'];
        $kondisi = ['IdSerahTerima' => $id];
        $simpan = updateData($koneksiku, 'serah_terima', $dataUpdate, $kondisi);
        
        if ($simpan) {
            // === AUTO-GENERATE BAST ===
            $stResult = selectData($koneksiku, 'serah_terima', ['IdSerahTerima' => $id]);
            if (!empty($stResult)) {
                $stData = $stResult[0];
                
                // Generate NoBast
                $stmtBast = $koneksiku->query("SELECT MAX(IdBast) as maxId FROM bast");
                $resultBast = $stmtBast->fetch();
                $nextBastId = ($resultBast['maxId'] ?? 0) + 1;
                $noBast = 'BAST/' . str_pad($nextBastId, 4, '0', STR_PAD_LEFT) . '/' . date('m') . '/' . date('Y');
                
                // Insert header BAST
                $bastBaru = [
                    'NoBast'       => $noBast,
                    'IdPenyerah'   => $stData['IdPenyerah'],
                    'IdPenerima'   => $stData['IdPenerima'],
                    'Keterangan'   => "Auto-generated dari Serah Terima No: " . $stData['NoSerahTerima'] . " - " . $stData['Keterangan'],
                    'Status'       => 'menunggu',
                    'ApproveSerah' => 0,
                    'ApproveTerima'=> 0
                ];
                $insertBast = insertData($koneksiku, 'bast', $bastBaru);
                
                if ($insertBast) {
                    $newBastId = $koneksiku->lastInsertId();
                    
                    // Copy detail aset
                    $stDetails = selectData($koneksiku, 'serah_terima_detail', ['IdSerahTerima' => $id]);
                    foreach ($stDetails as $d) {
                        insertData($koneksiku, 'bast_detail', [
                            'IdBast' => $newBastId,
                            'IdAset' => $d['IdAset']
                        ]);
                    }
                }
            }
        }
        
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
                $_SESSION['alert'] = "SimpanGagal"; // Aset sudah ada
            }
        } catch (Exception $e) {
            $_SESSION['alert'] = "SimpanGagal";
        }
    }
    header("location:index.php?pg=$pg&fl=detail&ak=edit&id=$id");
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
    header("location:index.php?pg=$pg&fl=detail&ak=edit&id=$id");
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

if ($ak === 'edit' && !empty($id)) {
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

// Generate nomor surat otomatis untuk form tambah
$noSuratOtomatis = generateNoSerahTerima($koneksiku);
?>
