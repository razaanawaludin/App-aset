<?php
$id = $_GET['id'] ?? '';
$btn = $_POST['Btn'] ?? '';

// Tambah kategori
if ($btn === 'Simpan') {
    $kode = $_POST['kode'] ?? '';
    $nama = $_POST['nama'] ?? '';

    if (!empty($kode) && !empty($nama)) {
        try {
            $dataBaru = [
                'KodeKategori' => $kode,
                'NamaKategori' => $nama
            ];

            $simpan = insertData($koneksiku, 'kategori_aset', $dataBaru);

            if ($simpan) {
                $_SESSION['alert'] = "SimpanBerhasil";
            } else {
                $_SESSION['alert'] = "SimpanGagal";
            }
        } catch (Exception $e) {
            $_SESSION['alert'] = "SimpanGagal";
        }
    } else {
        $_SESSION['alert'] = "SimpanGagal";
    }

    header("location:index.php?pg=$pg&fl=$fl");
    exit();
}

// Hapus kategori
if ($ak === 'hapus' && !empty($id)) {
    try {
        $kondisi = ['IdKategori' => $id];
        $hapus = deleteData($koneksiku, 'kategori_aset', $kondisi);
        $_SESSION['alert'] = $hapus ? "HapusBerhasil" : "HapusGagal";
    } catch (Exception $e) {
        $_SESSION['alert'] = "HapusGagal";
    }
    header("location:index.php?pg=$pg&fl=$fl");
    exit();
}

// Ambil data
try { $semuaKategori = selectData($koneksiku, 'kategori_aset'); } catch (Exception $e) { $semuaKategori = []; }
?>
