<?php
$id = $_GET['id'] ?? '';
$btn = $_POST['Btn'] ?? '';

// Fungsi generate kode otomatis untuk kategori
function generateKodeKategori($koneksiku) {
    try {
        $stmt = $koneksiku->query("SELECT MAX(IdKategoriAset) as maxId FROM kategori_aset");
        $result = $stmt->fetch();
        $nextId = ($result['maxId'] ?? 0) + 1;
        return 'KAT' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
    } catch (Exception $e) {
        return 'KAT001';
    }
}

// Tambah atau Edit kategori
if ($btn === 'Simpan') {
    $nama = $_POST['nama'] ?? '';

    if (!empty($nama)) {
        try {
            if ($ak === 'edit' && !empty($id)) {
                // Update kategori
                $dataUpdate = [
                    'NamaKategori' => $nama
                ];
                $kondisi = ['IdKategoriAset' => $id];
                $simpan = updateData($koneksiku, 'kategori_aset', $dataUpdate, $kondisi);
            } else {
                // Tambah kategori baru
                $kodeOtomatis = generateKodeKategori($koneksiku);
                $dataBaru = [
                    'KodeKategori' => $kodeOtomatis,
                    'NamaKategori' => $nama
                ];
                $simpan = insertData($koneksiku, 'kategori_aset', $dataBaru);
            }

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
        $kondisi = ['IdKategoriAset' => $id];
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

// Generate kode otomatis untuk form
$kodeKategoriOtomatis = generateKodeKategori($koneksiku);

// Untuk edit: ambil data yang akan diedit
$edit_kode_val = '';
$edit_nama_val = '';

if ($ak === 'edit' && !empty($id)) {
    try {
        $kondisi = ['IdKategoriAset' => $id];
        $hasil = selectData($koneksiku, 'kategori_aset', $kondisi);
        if (!empty($hasil)) {
            $edit_kode_val = $hasil[0]['KodeKategori'] ?? '';
            $edit_nama_val = $hasil[0]['NamaKategori'] ?? '';
        }
    } catch (Exception $e) {}
}
?>
