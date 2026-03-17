<?php 
        //untuk logout
        if($pg=='logout'){
            session_destroy();
            header('Location:index.php');
        } 
    
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Core | Premium Enterprise Dashboard</title>                           
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <?php include('dashboard/sidebar.php') ?>

    <div class="main-content">
        
        <?php include('dashboard/header.php') ?>

        <div class="p-4 p-lg-5">
           
        <?php
        if ($pg == '' && $fl == '') {
             include('pages/beranda.php');
        }
        elseif ($pg != '' && $fl != '') {
            include('pages/'.$pg.'/'.$fl.'.php');
        }
        ?>
        

        </div> 
    </div> 
    <script src="assets/js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($_SESSION['alert'])): ?>
        <script>
            <?php
            $alertType = 'info';
            $alertTitle = 'Info';
            $alertText = '';
            
            switch ($_SESSION['alert']) {
                case "SimpanBerhasil":
                    $alertType = 'success'; $alertTitle = 'Berhasil!'; $alertText = 'Data berhasil disimpan.'; break;
                case "SimpanGagal":
                    $debugMsg = $_SESSION['alert_debug'] ?? '';
                    $alertType = 'error'; $alertTitle = 'Gagal!'; $alertText = 'Data gagal disimpan.' . ($debugMsg ? ' Error: ' . $debugMsg : ''); 
                    unset($_SESSION['alert_debug']);
                    break;
                case "HapusBerhasil":
                    $alertType = 'success'; $alertTitle = 'Berhasil!'; $alertText = 'Data berhasil dihapus.'; break;
                case "HapusGagal":
                    $alertType = 'error'; $alertTitle = 'Gagal!'; $alertText = 'Data gagal dihapus.'; break;
                case "AktifBerhasil":
                    $alertType = 'success'; $alertTitle = 'Berhasil!'; $alertText = 'Status berhasil diaktifkan.'; break;
                case "NonAktifBerhasil":
                    $alertType = 'success'; $alertTitle = 'Berhasil!'; $alertText = 'Status berhasil dinonaktifkan.'; break;
            }
            ?>
            Swal.fire({
                icon: '<?= $alertType ?>',
                title: '<?= $alertTitle ?>',
                text: '<?= $alertText ?>',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
</body>
</html>