<?php
// Controller edit menggunakan logika yang sama dengan tambah
$id = $_GET['id'] ?? '';

try { $semuaKategori = selectData($koneksiku, 'kategori_aset'); } catch (Exception $e) { $semuaKategori = []; }
try { $semuaLokasi = selectData($koneksiku, 'lokasi_aset'); } catch (Exception $e) { $semuaLokasi = []; }

$btn = $_POST['btn'] ?? '';

if ($btn === 'Simpan') {
    $kode_aset  = $_POST['kode_aset'] ?? '';
    $nama_aset  = $_POST['nama_aset'] ?? '';
    $kategori   = $_POST['kategori'] ?? '';
    $lokasi     = $_POST['lokasi'] ?? '';
    $kondisi    = $_POST['kondisi'] ?? 'Baik';

    $namaFoto = '';
    if (isset($_FILES['foto_aset']) && $_FILES['foto_aset']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'assets/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $ext = pathinfo($_FILES['foto_aset']['name'], PATHINFO_EXTENSION);
        $namaFoto = 'aset_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['foto_aset']['tmp_name'], $uploadDir . $namaFoto);
    }

    $dataUpdate = [
        'KodeAset'    => $kode_aset,
        'NamaAset'    => $nama_aset,
        'Kategori'    => $kategori,
        'Lokasi'      => $lokasi,
        'KondisiAset' => $kondisi
    ];
    if (!empty($namaFoto)) {
        $dataUpdate['FotoAset'] = $namaFoto;
    }

    $kondisi = ['IdAset' => $id];
    $simpan = updateData($koneksiku, 'kelola_aset', $dataUpdate, $kondisi);
    if ($simpan) {
        $_SESSION['alert'] = "SimpanBerhasil";
    } else {
        $_SESSION['alert'] = "SimpanGagal";
    }

    header("location:index.php?pg=$pg&fl=kelola");
    exit();
}

// Ambil data yang akan diedit
$kode_val = '';
$nama_val = '';
$kategori_val = '';
$lokasi_val = '';
$kondisi_val = 'Baik';
$foto_val = '';

if (!empty($id)) {
    $kondisi = ['IdAset' => $id];
    try {
        $hasil = selectData($koneksiku, 'kelola_aset', $kondisi);
        if (!empty($hasil)) {
            $data = $hasil[0];
            $kode_val     = $data['KodeAset'];
            $nama_val     = $data['NamaAset'];
            $kategori_val = $data['Kategori'];
            $lokasi_val   = $data['Lokasi'];
            $kondisi_val  = $data['KondisiAset'] ?? 'Baik';
            $foto_val     = $data['FotoAset'];
        }
    } catch (Exception $e) {}
}
?>
