<?php
$id = $_GET['id'] ?? '';

try { $semuaKategori = selectData($koneksiku, 'kategori_aset'); } catch (Exception $e) { $semuaKategori = []; }
try { $semuaLokasi = selectData($koneksiku, 'lokasi_aset'); } catch (Exception $e) { $semuaLokasi = []; }

// Debug: cek struktur tabel
try {
    $stmt = $koneksiku->query("DESCRIBE kelola_aset");
    $cols = $stmt->fetchAll();
    $colNames = array_column($cols, 'Field');
    file_put_contents('debug_kelola.txt', "Kolom tabel: " . implode(', ', $colNames) . "\n", FILE_APPEND);
} catch (Exception $e) {
    file_put_contents('debug_kelola.txt', "Tabel kelola_aset tidak ada: " . $e->getMessage() . "\n", FILE_APPEND);
}

$btn = $_POST['btn'] ?? '';

if ($btn === 'Simpan') {
    file_put_contents('debug_kelola.txt', date('H:i:s') . " POST: " . print_r($_POST, true) . "\n", FILE_APPEND);
    
    $kode_aset  = $_POST['kode_aset'] ?? '';
    $nama_aset  = $_POST['nama_aset'] ?? '';
    $kategori   = $_POST['kategori'] ?? '';
    $lokasi     = $_POST['lokasi'] ?? '';

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

    switch ($ak) {
        case 'tambah':
            try {
                $dataBaru = [
                    'KodeAset'  => $kode_aset,
                    'NamaAset'  => $nama_aset,
                    'Kategori'  => $kategori,
                    'Lokasi'    => $lokasi,
                    'FotoAset'  => $namaFoto
                ];
                file_put_contents('debug_kelola.txt', "Insert data: " . print_r($dataBaru, true) . "\n", FILE_APPEND);

                $simpan = insertData($koneksiku, 'kelola_aset', $dataBaru);
                $_SESSION['alert'] = $simpan ? "SimpanBerhasil" : "SimpanGagal";
            } catch (Exception $e) {
                file_put_contents('debug_kelola.txt', "INSERT ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
                $_SESSION['alert'] = "SimpanGagal";
            }

            header("location:index.php?pg=$pg&fl=kelola");
            exit();
            break;

        case 'edit':
            try {
                $dataUpdate = [
                    'KodeAset'  => $kode_aset,
                    'NamaAset'  => $nama_aset,
                    'Kategori'  => $kategori,
                    'Lokasi'    => $lokasi
                ];
                if (!empty($namaFoto)) {
                    $dataUpdate['FotoAset'] = $namaFoto;
                }

                $kondisi = ['IdAset' => $id];
                $simpan = updateData($koneksiku, 'kelola_aset', $dataUpdate, $kondisi);
                $_SESSION['alert'] = $simpan ? "SimpanBerhasil" : "SimpanGagal";
            } catch (Exception $e) {
                file_put_contents('debug_kelola.txt', "UPDATE ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
                $_SESSION['alert'] = "SimpanGagal";
            }

            header("location:index.php?pg=$pg&fl=kelola");
            exit();
            break;
    }
}

// Untuk edit: ambil data yang akan diedit
$kode_val = '';
$nama_val = '';
$kategori_val = '';
$lokasi_val = '';
$foto_val = '';

if ($ak === 'edit' && !empty($id)) {
    $kondisi = ['IdAset' => $id];
    try {
        $hasil = selectData($koneksiku, 'kelola_aset', $kondisi);
        if (!empty($hasil)) {
            $data = $hasil[0];
            $kode_val     = $data['KodeAset'] ?? '';
            $nama_val     = $data['NamaAset'] ?? '';
            $kategori_val = $data['Kategori'] ?? '';
            $lokasi_val   = $data['Lokasi'] ?? '';
            $foto_val     = $data['FotoAset'] ?? '';
        }
    } catch (Exception $e) {}
}
?>
