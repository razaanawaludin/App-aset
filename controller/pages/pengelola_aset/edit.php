<?php
$id = $_GET['id'] ?? '';
$btn = $_POST['Btn'] ?? '';

$role_edit = '';
$nama_pegawai = '';
$username_pegawai = '';

// Fetch existing data for the selected pegawai
if (!empty($id)) {
    $kondisi = ['IdPegawai' => $id];
    $hasil = selectData($koneksiku, 'pegawai', $kondisi);
    if (!empty($hasil)) {
        $role_edit = $hasil[0]['Role'];
        $nama_pegawai = $hasil[0]['Nama'];
        $username_pegawai = $hasil[0]['Username'];
    } else {
        header("location:index.php?pg=$pg&fl=pengelola");
        exit();
    }
} else {
    header("location:index.php?pg=$pg&fl=pengelola");
    exit();
}

// Handle form submission
if ($btn === 'Simpan Perubahan') {
    $role = $_POST['role'] ?? '';

    if (!empty($role)) {
        $kondisi = ['IdPegawai' => $id];
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

    header("location:index.php?pg=$pg&fl=pengelola");
    exit();
}
?>
