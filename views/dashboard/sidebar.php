 <?php

    $activeberanda = "";
    $ac = [];
     if($pg=="")
    {
        $activeberanda="active";
    }
    else
    {
        $ac[$pg] ??= ""; // Initialize safely
        $ac[$pg] = "active";
    }


?>
 <aside id="sidebar">
    <div class="sidebar-header">
        <div class="brand-logo"><i data-lucide="command"></i></div>
        <span class="brand-text">AseTru</span>
    </div>

    <div class="d-flex flex-column flex-grow-1 overflow-auto custom-scrollbar">
        <a href="index.php" class="nav-link-custom <?=$activeberanda?>"><i data-lucide="house"></i>Beranda</a>
        
        <?php
            $userRole = $_SESSION['Role'] ?? '';
            
            if ($userRole === 'admin instansi') {
                include('menu/adm_instansi.php');
            } elseif ($userRole === 'pengelola aset') {
                include('menu/adm_aset.php');
            } elseif ($userRole === 'staf') {
                include('menu/staf_aset.php');
            } elseif ($userRole === 'teknisi') {
                include('menu/teknisi.php');
            } else {
                // Tampilkan semua menu sebagai fallback jika Role tidak dikenali di mode Latihan ini
                include('menu/adm_instansi.php');
                include('menu/adm_aset.php');
                include('menu/staf_aset.php');
                include('menu/teknisi.php');
            }
        ?>

        <!-- Menu Umum untuk Semua Role -->
        <hr class="my-2 border-secondary opacity-25">
        <a href="?pg=scanner&&fl=scan" class="nav-link-custom <?= $ac['scanner'] ?? '' ?>"><i data-lucide="scan"></i> Scan QR Aset</a>
    </div>
</aside>