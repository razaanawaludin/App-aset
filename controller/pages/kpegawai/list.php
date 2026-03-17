<?php

$semuaUser = selectData($koneksiku, 'pegawai');

 //Aksi
    $id = $_GET['id'] ?? '';
    if($ak !== ""){
        $tabel = 'pegawai';
        $kondisi = ['IdPegawai' => $id];
        $QData = selectData($koneksiku, $tabel, $kondisi);
        $data = $QData[0];

        switch($ak){
            case "aktif":
                $dataUpdate = [
                    'StatusAktif' => 1
                ];

                $simpan=updateData($koneksiku, $tabel, $dataUpdate, $kondisi);

                if($simpan){
                    $_SESSION['alert'] = "AktifBerhasil";
                    header("location:index.php?pg=$pg&fl=$fl");
                    exit();
                }

                break;

            case "noaktif":
                $dataUpdate = [
                    'StatusAktif' => 0,
                    'Sandi' => ""
                ];

                $simpan=updateData($koneksiku, $tabel, $dataUpdate, $kondisi);

                if($simpan){
                    $_SESSION['alert'] = "NonAktifBerhasil";
                    header("location:index.php?pg=$pg&fl=$fl");
                    exit();
                }

                break;

            case "hapus":
                
                $hasil = deleteData($koneksiku, 'pegawai', $kondisi);

                if ($hasil) {
                    $_SESSION['alert'] = "HapusBerhasil";
                    header("location:index.php?pg=$pg&fl=$fl");
                    exit();
                } else {
                    $_SESSION['alert'] = "HapusGagal";
                    header("location:index.php?pg=$pg&fl=$fl");
                    exit();
                }

                break;
        }
    }
    
?>