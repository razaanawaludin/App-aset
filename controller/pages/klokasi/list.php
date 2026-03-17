<?php
$id = $_GET['id'] ?? '';
$btn = $_POST['Btn'] ?? '';

// Tambah lokasi
if ($btn === 'Simpan') {
    $kode = $_POST['kode'] ?? '';
    $nama = $_POST['lokasi'] ?? '';

    if (!empty($kode) && !empty($nama)) {
        try {
            $dataBaru = [
                'KodeLokasi'  => $kode,
                'NamaLokasi'  => $nama
            ];

            $simpan = insertData($koneksiku, 'lokasi_aset', $dataBaru);
            $_SESSION['alert'] = $simpan ? "SimpanBerhasil" : "SimpanGagal";
        } catch (Exception $e) {
            // Jika kolom tidak cocok, coba dengan struktur berbeda
            file_put_contents('debug_lokasi.txt', "INSERT ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
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
        $kondisi = ['IdLokasi' => $id];
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
?>
