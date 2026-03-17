<?php
$id = $_GET['id'] ?? '';

try { $semuaAset = selectData($koneksiku, 'kelola_aset'); } catch (Exception $e) { $semuaAset = []; }
$jumlahAset = count($semuaAset);
try { $semuaKategori = selectData($koneksiku, 'kategori_aset'); } catch (Exception $e) { $semuaKategori = []; }
try { $semuaLokasi = selectData($koneksiku, 'lokasi_aset'); } catch (Exception $e) { $semuaLokasi = []; }

// Hapus aset
if ($ak === 'hapus' && !empty($id)) {
    $kondisi = ['IdAset' => $id];

    // Ambil data foto untuk dihapus
    $dataAset = selectData($koneksiku, 'kelola_aset', $kondisi);
    if (!empty($dataAset) && !empty($dataAset[0]['FotoAset'])) {
        $fotoPath = 'assets/uploads/' . $dataAset[0]['FotoAset'];
        if (file_exists($fotoPath)) {
            unlink($fotoPath);
        }
    }

    $hapus = deleteData($koneksiku, 'kelola_aset', $kondisi);
    if ($hapus) {
        $_SESSION['alert'] = "HapusBerhasil";
    } else {
        $_SESSION['alert'] = "HapusGagal";
    }
    header("location:index.php?pg=$pg&fl=$fl");
    exit();
}
?>
