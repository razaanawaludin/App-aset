<?php

    // echo password_hash('1234', PASSWORD_DEFAULT);
    //$2y$10$b4ImlfzP1zEibaoy8P5gNulF1kIhrAGDJ970an16lLaiqf0L9rDZu
    $user=$_POST['user']?? '';
    $pwd=$_POST['pwd'] ?? '';
    $tombol=$_POST['tombol'] ?? '';

    if($tombol)
    {
        
        $quser = selectData($koneksiku, 'pegawai', ['Username' => $user]);

        if(!empty($quser))
        {
            if(password_verify($pwd,$quser[0]['Sandi']))
            {
                $_SESSION['status']='OKE';
                $_SESSION['IdUser'] = $quser[0]['IdPegawai'];
                $_SESSION['Role'] = strtolower($quser[0]['Role']);
                header('Location:index.php'); 
            }
            else
            {
                $_SESSION['alert_login'] = "Maaf password anda salah";
            }
            
        }
        else
        {
            $_SESSION['alert_login'] = "Maaf username tidak terdaftar atau password salah";
        }

        
    }
    
        // $user=$_POST['user']?? '';
        // $pwd=$_POST['pwd'] ?? '';
        // $tombol=$_POST['tombol'] ?? '';
    
        // if($tombol){
        //     $_SESSION['status']='OKE';
        //     header('Location:index.php'); 
        //     $quser = selectData($koneksiku, 'pegawai', ['Username' => $user]);
    
        //     if (!empty($quser)) 
        //     {
        //         $userData = $quser[0];
    
        //         if (password_verify($pwd, $userData['Sandi'])) 
        //         {
        //             $_SESSION['status']='OKE';
        //             header('Location:index.php'); 
        //             exit;
        //         } 
        //         else 
        //         {
        //             $error_message = "Password yang Anda masukkan salah.";
        //         }
        //     } 
        //     else 
        //     {
        //         $error_message = "Username tidak terdaftar.";
        //     }
    
           
        // }
    ?>