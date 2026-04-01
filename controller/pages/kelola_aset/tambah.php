<?php
$id = $_GET['id'] ?? '';

try { $semuaKategori = selectData($koneksiku, 'kategori_aset'); } catch (Exception $e) { $semuaKategori = []; }
try { $semuaLokasi = selectData($koneksiku, 'lokasi_aset'); } catch (Exception $e) { $semuaLokasi = []; }

// Auto-add kolom KondisiAset jika belum ada
try {
    $cols = $koneksiku->query("DESCRIBE kelola_aset")->fetchAll();
    $colNames = array_column($cols, 'Field');
    if (!in_array('KondisiAset', $colNames)) {
        $koneksiku->exec("ALTER TABLE kelola_aset ADD COLUMN KondisiAset VARCHAR(50) NOT NULL DEFAULT 'Baik' AFTER Lokasi");
    }
} catch (Exception $e) {}

// Fungsi generate kode otomatis untuk aset
function generateKodeAset($koneksiku) {
    try {
        $stmt = $koneksiku->query("SELECT MAX(IdAset) as maxId FROM kelola_aset");
        $result = $stmt->fetch();
        $nextId = ($result['maxId'] ?? 0) + 1;
        return 'AST' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
    } catch (Exception $e) {
        return 'AST001';
    }
}
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
    
    $kode_aset  = ($ak === 'edit') ? ($_POST['kode_aset'] ?? '') : generateKodeAset($koneksiku);
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

    switch ($ak) {
        case 'tambah':
            try {
                $dataBaru = [
                    'KodeAset'    => $kode_aset,
                    'NamaAset'    => $nama_aset,
                    'Kategori'    => $kategori,
                    'Lokasi'      => $lokasi,
                    'KondisiAset' => $kondisi,
                    'FotoAset'    => $namaFoto
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
$kondisi_val = 'Baik';
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
            $kondisi_val  = $data['KondisiAset'] ?? 'Baik';
            $foto_val     = $data['FotoAset'] ?? '';
        }
    } catch (Exception $e) {}
}

// Generate kode otomatis untuk form tambah
$kodeAsetOtomatis = generateKodeAset($koneksiku);
?>
