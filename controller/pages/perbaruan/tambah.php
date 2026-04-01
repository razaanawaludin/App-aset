<?php
// Ambil data aset untuk dropdown
try { $semuaAset = selectData($koneksiku, 'kelola_aset'); } catch (Exception $e) { $semuaAset = []; }

$btn = $_POST['Btn'] ?? '';

if ($btn === 'Simpan') {
    $id_aset        = $_POST['id_aset'] ?? '';
    $tanggal_mulai  = $_POST['tanggal_mulai'] ?? '';
    $tanggal_selesai = $_POST['tanggal_selesai'] ?? null;
    $jenis          = $_POST['jenis_perbaruan'] ?? '';
    $deskripsi      = $_POST['deskripsi'] ?? '';
    $teknisi        = $_POST['teknisi'] ?? '';
    $biaya          = $_POST['biaya'] ?? 0;
    $status         = $_POST['status'] ?? 'proses';
    $catatan        = $_POST['catatan'] ?? '';

    try {
        $dataBaru = [
            'IdAset'         => $id_aset,
            'TanggalMulai'   => $tanggal_mulai,
            'TanggalSelesai' => !empty($tanggal_selesai) ? $tanggal_selesai : null,
            'JenisPerbaruan' => $jenis,
            'Deskripsi'      => $deskripsi,
            'Teknisi'        => $teknisi,
            'Biaya'          => $biaya,
            'Status'         => $status,
            'Catatan'        => $catatan
        ];

        $simpan = insertData($koneksiku, 'perbaruan_aset', $dataBaru);
        $_SESSION['alert'] = $simpan ? "SimpanBerhasil" : "SimpanGagal";
    } catch (Exception $e) {
        $_SESSION['alert'] = "SimpanGagal";
    }

    header("location:index.php?pg=$pg&fl=list");
    exit();
}
?>
