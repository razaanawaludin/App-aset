<?php
$id = $_GET['id'] ?? '';
$btn = $_POST['Btn'] ?? '';
$idUser = $_SESSION['IdUser'] ?? '';

// Ambil data pegawai untuk dropdown
try { $semuaPegawai = selectData($koneksiku, 'pegawai'); } catch (Exception $e) { $semuaPegawai = []; }

// Ambil data aset untuk dropdown
try { $semuaAset = selectData($koneksiku, 'kelola_aset'); } catch (Exception $e) { $semuaAset = []; }

// Auto-bikin tabel jika belum ada (Safe fallback)
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

// Fungsi generate nomor BAST otomatis
function generateNoBast($koneksiku) {
    try {
        $stmt = $koneksiku->query("SELECT MAX(IdBast) as maxId FROM bast");
        $result = $stmt->fetch();
        $nextId = ($result['maxId'] ?? 0) + 1;
        $bulan = date('m');
        $tahun = date('Y');
        return 'BAST/' . str_pad($nextId, 4, '0', STR_PAD_LEFT) . '/' . $bulan . '/' . $tahun;
    } catch (Exception $e) {
        return 'BAST/0001/' . date('m') . '/' . date('Y');
    }
}

// ========== AKSI: Buat Dokumen BAST Baru ==========
if ($btn === 'Buat Dokumen') {
    $noBast = generateNoBast($koneksiku);
    $penyerah = $_POST['penyerah'] ?? '';
    $penerima = $_POST['penerima'] ?? '';
    $keterangan = $_POST['keterangan'] ?? '';

    if (!empty($penyerah) && !empty($penerima)) {
        try {
            $dataBaru = [
                'NoBast'       => $noBast,
                'IdPenyerah'   => $penyerah,
                'IdPenerima'   => $penerima,
                'Keterangan'   => $keterangan,
                'Status'       => 'menunggu',
                'ApproveSerah' => 0,
                'ApproveTerima'=> 0
            ];
            $simpan = insertData($koneksiku, 'bast', $dataBaru);
            if ($simpan) {
                $newId = $koneksiku->lastInsertId();
                $_SESSION['alert'] = "SimpanBerhasil";
                header("location:index.php?pg=$pg&fl=detail&ak=edit&id=$newId");
                exit();
            } else {
                $_SESSION['alert'] = "SimpanGagal";
            }
        } catch (Exception $e) {
            file_put_contents('bast_error_log.txt', date('Y-m-d H:i:s') . ' - Insert BAST Error: ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
            $_SESSION['alert'] = "SimpanGagal";
        }
    } else {
        file_put_contents('bast_error_log.txt', date('Y-m-d H:i:s') . ' - Insert BAST Error: Penyerah atau Penerima kosong.' . PHP_EOL, FILE_APPEND);
        $_SESSION['alert'] = "SimpanGagal";
    }
    header("location:index.php?pg=$pg&fl=detail&ak=tambah");
    exit();
}

// ========== AKSI: Update Header BAST ==========
if ($btn === 'Simpan' && $ak === 'edit' && !empty($id)) {
    $penyerah = $_POST['penyerah'] ?? '';
    $penerima = $_POST['penerima'] ?? '';
    $keterangan = $_POST['keterangan'] ?? '';

    if (!empty($penyerah) && !empty($penerima)) {
        try {
            $dataUpdate = [
                'IdPenyerah' => $penyerah,
                'IdPenerima' => $penerima,
                'Keterangan' => $keterangan
            ];
            $kondisi = ['IdBast' => $id];
            $simpan = updateData($koneksiku, 'bast', $dataUpdate, $kondisi);
            $_SESSION['alert'] = $simpan ? "SimpanBerhasil" : "SimpanGagal";
        } catch (Exception $e) {
            $_SESSION['alert'] = "SimpanGagal";
        }
    }
    header("location:index.php?pg=$pg&fl=detail&ak=edit&id=$id");
    exit();
}

// ========== AKSI: Approve Serah ==========
if ($ak === 'approve_serah' && !empty($id)) {
    try {
        // Verifikasi bahwa user yang login adalah penyerah
        $cekBast = selectData($koneksiku, 'bast', ['IdBast' => $id]);
        if (!empty($cekBast) && $cekBast[0]['IdPenyerah'] == $idUser) {
            $dataUpdate = ['ApproveSerah' => 1];
            $kondisi = ['IdBast' => $id];
            updateData($koneksiku, 'bast', $dataUpdate, $kondisi);

            // Cek apakah kedua pihak sudah approve
            $bastUpdated = selectData($koneksiku, 'bast', ['IdBast' => $id]);
            if (!empty($bastUpdated) && $bastUpdated[0]['ApproveSerah'] == 1 && $bastUpdated[0]['ApproveTerima'] == 1) {
                updateData($koneksiku, 'bast', ['Status' => 'selesai (approved)'], ['IdBast' => $id]);
            }
            $_SESSION['alert'] = "SimpanBerhasil";
        } else {
            $_SESSION['alert'] = "SimpanGagal";
        }
    } catch (Exception $e) {
        $_SESSION['alert'] = "SimpanGagal";
    }
    header("location:index.php?pg=$pg&fl=detail&ak=edit&id=$id");
    exit();
}

// ========== AKSI: Approve Terima ==========
if ($ak === 'approve_terima' && !empty($id)) {
    try {
        // Verifikasi bahwa user yang login adalah penerima
        $cekBast = selectData($koneksiku, 'bast', ['IdBast' => $id]);
        if (!empty($cekBast) && $cekBast[0]['IdPenerima'] == $idUser) {
            $dataUpdate = ['ApproveTerima' => 1];
            $kondisi = ['IdBast' => $id];
            updateData($koneksiku, 'bast', $dataUpdate, $kondisi);

            // Cek apakah kedua pihak sudah approve
            $bastUpdated = selectData($koneksiku, 'bast', ['IdBast' => $id]);
            if (!empty($bastUpdated) && $bastUpdated[0]['ApproveSerah'] == 1 && $bastUpdated[0]['ApproveTerima'] == 1) {
                updateData($koneksiku, 'bast', ['Status' => 'disetujui'], ['IdBast' => $id]);
            }
            $_SESSION['alert'] = "SimpanBerhasil";
        } else {
            $_SESSION['alert'] = "SimpanGagal";
        }
    } catch (Exception $e) {
        $_SESSION['alert'] = "SimpanGagal";
    }
    header("location:index.php?pg=$pg&fl=detail&ak=edit&id=$id");
    exit();
}

// ========== AKSI: Tambah Aset ke Detail ==========
if ($btn === 'Tambah' && !empty($id)) {
    $idAset = $_POST['id_aset'] ?? '';
    if (!empty($idAset)) {
        try {
            $stmt = $koneksiku->prepare("SELECT COUNT(*) as cnt FROM bast_detail WHERE IdBast = :idBast AND IdAset = :idAset");
            $stmt->execute(['idBast' => $id, 'idAset' => $idAset]);
            $cek = $stmt->fetch();

            if ($cek['cnt'] == 0) {
                $dataBaru = [
                    'IdBast' => $id,
                    'IdAset' => $idAset
                ];
                $simpan = insertData($koneksiku, 'bast_detail', $dataBaru);
                $_SESSION['alert'] = $simpan ? "SimpanBerhasil" : "SimpanGagal";
            } else {
                $_SESSION['alert'] = "SimpanGagal";
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
            $kondisi = ['IdBastDetail' => $idDetail];
            $hapus = deleteData($koneksiku, 'bast_detail', $kondisi);
            $_SESSION['alert'] = $hapus ? "HapusBerhasil" : "HapusGagal";
        } catch (Exception $e) {
            $_SESSION['alert'] = "HapusGagal";
        }
    }
    header("location:index.php?pg=$pg&fl=detail&ak=edit&id=$id");
    exit();
}

// ========== Ambil data untuk Edit ==========
$noBast_val = '';
$penyerah_val = '';
$penerima_val = '';
$keterangan_val = '';
$status_val = 'menunggu';
$approveSerah_val = 0;
$approveTerima_val = 0;
$detailAset = [];
$namaPenyerah = '';
$namaPenerima = '';
$tanggalDokumen = '';

if ($ak === 'edit' && !empty($id)) {
    try {
        $kondisi = ['IdBast' => $id];
        $hasil = selectData($koneksiku, 'bast', $kondisi);
        if (!empty($hasil)) {
            $data = $hasil[0];
            $noBast_val        = $data['NoBast'] ?? '';
            $penyerah_val      = $data['IdPenyerah'] ?? '';
            $penerima_val      = $data['IdPenerima'] ?? '';
            $keterangan_val    = $data['Keterangan'] ?? '';
            $status_val        = $data['Status'] ?? 'menunggu';
            $approveSerah_val  = $data['ApproveSerah'] ?? 0;
            $approveTerima_val = $data['ApproveTerima'] ?? 0;
            $tanggalDokumen    = $data['Create_at'] ?? '';

            // Ambil nama pegawai
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
            SELECT d.IdBastDetail, d.IdAset, a.KodeAset, a.NamaAset, a.Kategori, a.FotoAset
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

// Generate nomor otomatis untuk form tambah
$noBastOtomatis = generateNoBast($koneksiku);
?>
