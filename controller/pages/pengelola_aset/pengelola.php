<?php
$id = $_GET['id'] ?? '';
$semuaPegawai = selectData($koneksiku, 'pegawai');

$btn = $_POST['Btn'] ?? '';

if ($btn === 'Simpan') {
    $idPegawai = $_POST['pegawai'] ?? '';
    $role = $_POST['role'] ?? '';

    if (!empty($idPegawai) && !empty($role)) {
        $kondisi = ['IdPegawai' => $idPegawai];
        $dataUpdate = ['Role' => $role];

        $simpan = updateData($koneksiku, 'pegawai', $dataUpdate, $kondisi);

        if ($simpan) {
            $_SESSION['alert'] = "SimpanBerhasil";
        } else {
            $_SESSION['alert'] = "SimpanGagal";
        }
    } else {
        $_SESSION['alert'] = "SimpanGagal";
    }

    header("location:index.php?pg=$pg&fl=$fl");
    exit();
}

// hapus Role action
if ($ak === 'hapus' && !empty($id)) {
    $kondisi = ['IdPegawai' => $id];
    $dataUpdate = ['Role' => 'Tidak Ada Role'];
    
    $hapus = updateData($koneksiku, 'pegawai', $dataUpdate, $kondisi);
    if ($hapus) {
        $_SESSION['alert'] = "HapusBerhasil";
    } else {
        $_SESSION['alert'] = "HapusGagal";
    }
    header("location:index.php?pg=$pg&fl=$fl");
    exit();
}
?>
