<?php
$id = $_GET['id'] ?? '';

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
        $dataUpdate = [
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

        $kondisi = ['IdPerbaruan' => $id];
        $simpan = updateData($koneksiku, 'perbaruan_aset', $dataUpdate, $kondisi);
        $_SESSION['alert'] = $simpan ? "SimpanBerhasil" : "SimpanGagal";
    } catch (Exception $e) {
        $_SESSION['alert'] = "SimpanGagal";
    }

    header("location:index.php?pg=$pg&fl=list");
    exit();
}

// Ambil data yang akan diedit
$id_aset_val = '';
$tanggal_mulai_val = '';
$tanggal_selesai_val = '';
$jenis_val = '';
$deskripsi_val = '';
$teknisi_val = '';
$biaya_val = '';
$status_val = 'proses';
$catatan_val = '';

if (!empty($id)) {
    $kondisi = ['IdPerbaruan' => $id];
    try {
        $hasil = selectData($koneksiku, 'perbaruan_aset', $kondisi);
        if (!empty($hasil)) {
            $data = $hasil[0];
            $id_aset_val         = $data['IdAset'] ?? '';
            $tanggal_mulai_val   = $data['TanggalMulai'] ?? '';
            $tanggal_selesai_val = $data['TanggalSelesai'] ?? '';
            $jenis_val           = $data['JenisPerbaruan'] ?? '';
            $deskripsi_val       = $data['Deskripsi'] ?? '';
            $teknisi_val         = $data['Teknisi'] ?? '';
            $biaya_val           = $data['Biaya'] ?? '';
            $status_val          = $data['Status'] ?? 'proses';
            $catatan_val         = $data['Catatan'] ?? '';
        }
    } catch (Exception $e) {}
}
?>
