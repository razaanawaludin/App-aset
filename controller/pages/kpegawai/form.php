<?php
    $id=$_GET['id'] ?? '';
    $username=$_POST['username'] ?? '';
    $nama=$_POST['nama'] ?? '';
    $gender=$_POST['gender'] ?? '';
    $pwd=$_POST['password'] ?? '';

    $btn = $_POST["btn"] ?? '';

    if($btn === "Simpan"){
        switch($ak){
            case "tambah":
                $dataBaru = [
                    'Username' => $username,
                    'Nama'     => $nama,
                    'Gender'  => $gender,
                    'Sandi'   => password_hash($pwd, PASSWORD_DEFAULT)
                ];
                
                $simpan = insertData($koneksiku, 'pegawai', $dataBaru);
                if($simpan){
                    $_SESSION['alert'] = "SimpanBerhasil";
                }else{
                    $_SESSION['alert'] = "SimpanGagal";
                }
                
                header("location:index.php?pg=$pg&fl=$fl&ak=$ak&id=$id");
                exit();

            break;
            case "edit":
                $dataUpdate = [
                    'Username' => $username,
                    'Nama'     => $nama,
                    'Gender'  => $gender
                ];
                if (!empty($pwd)) {
                    $dataUpdate['Sandi'] = password_hash($pwd, PASSWORD_DEFAULT);
                }

                $kondisi = ['IdPegawai' => $id];

                $simpan=updateData($koneksiku, 'pegawai', $dataUpdate, $kondisi);

                if($simpan){
                    $_SESSION['alert'] = "SimpanBerhasil";
                }else{
                    $_SESSION['alert'] = "SimpanGagal";
                }
                
                header("location:index.php?pg=$pg&fl=$fl&ak=$ak&id=$id");
                exit();
            break;
        }
    }

    $username_val = "";
    $nama_val = "";
    $gender_val = "L";

    switch($ak){
        case "edit":
                $kondisi = ['IdPegawai' => $id];
                $hasil = selectData($koneksiku, 'pegawai', $kondisi);
                if (!empty($hasil)) {
                    $data = $hasil[0];
                    $username_val = $data['Username'];
                    $nama_val = $data['Nama'];
                    $gender_val = $data['Gender'];
                }
            break;
    }
   

    $CGenderL = "";
    $CGenderP = "";
    switch($gender_val){
        case "L":
            $CGenderL = "checked";
            break;
        case "P":
            $CGenderP = "checked";
            break;
        default :
            $CGenderL = "checked";
            break;
    }


?> 