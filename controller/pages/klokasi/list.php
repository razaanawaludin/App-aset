<?php
$id = $_GET['id'] ?? '';
$btn = $_POST['Btn'] ?? '';

// Fungsi generate kode otomatis untuk lokasi
function generateKodeLokasi($koneksiku) {
    try {
        $stmt = $koneksiku->query("SELECT MAX(IdLokasiAset) as maxId FROM lokasi_aset");
        $result = $stmt->fetch();
        $nextId = ($result['maxId'] ?? 0) + 1;
        return 'LOK' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
    } catch (Exception $e) {
        return 'LOK001';
    }
}

// Tambah atau Edit lokasi
if ($btn === 'Simpan') {
    $nama = $_POST['lokasi'] ?? '';

    if (!empty($nama)) {
        try {
            if ($ak === 'edit' && !empty($id)) {
                // Update lokasi
                $dataUpdate = [
                    'NamaLokasiAset' => $nama
                ];
                $kondisi = ['IdLokasiAset' => $id];
                $simpan = updateData($koneksiku, 'lokasi_aset', $dataUpdate, $kondisi);
            } else {
                // Tambah lokasi baru
                $kodeOtomatis = generateKodeLokasi($koneksiku);
                $dataBaru = [
                    'KodeLokasiAset'  => $kodeOtomatis,
                    'NamaLokasiAset'  => $nama
                ];
                $simpan = insertData($koneksiku, 'lokasi_aset', $dataBaru);
            }

            $_SESSION['alert'] = $simpan ? "SimpanBerhasil" : "SimpanGagal";
        } catch (Exception $e) {
            file_put_contents('debug_lokasi.txt', "INSERT/UPDATE ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
            $_SESSION['alert'] = "SimpanGagal";
        }
    } else {
        $_SESSION['alert'] = "SimpanGagal";
    }

    header("location:index.php?pg=$pg&fl=$fl");
    exit();
}

// Hapus lokasi
if ($ak === 'hapus' && !empty($id)) {
    try {
        $kondisi = ['IdLokasiAset' => $id];
        $hapus = deleteData($koneksiku, 'lokasi_aset', $kondisi);
        $_SESSION['alert'] = $hapus ? "HapusBerhasil" : "HapusGagal";
    } catch (Exception $e) {
        $_SESSION['alert'] = "HapusGagal";
    }
    header("location:index.php?pg=$pg&fl=$fl");
    exit();
}

// Ambil data
try { $semuaLokasi = selectData($koneksiku, 'lokasi_aset'); } catch (Exception $e) { $semuaLokasi = []; }

// Generate kode otomatis untuk form
$kodeLokasiOtomatis = generateKodeLokasi($koneksiku);

// Untuk edit: ambil data yang akan diedit
$edit_kode_val = '';
$edit_nama_val = '';

if ($ak === 'edit' && !empty($id)) {
    try {
        $kondisi = ['IdLokasiAset' => $id];
        $hasil = selectData($koneksiku, 'lokasi_aset', $kondisi);
        if (!empty($hasil)) {
            $edit_kode_val = $hasil[0]['KodeLokasiAset'] ?? '';
            $edit_nama_val = $hasil[0]['NamaLokasiAset'] ?? '';
        }
    } catch (Exception $e) {}
}
?>
