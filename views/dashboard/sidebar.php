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
        <span class="brand-text">MenSet</span>
    </div>

    <div class="d-flex flex-column flex-grow-1 overflow-auto custom-scrollbar">
        <a href="index.php" class="nav-link-custom <?=$activeberanda?>"><i data-lucide="house"></i>Beranda</a>
        <?php include('menu/adm_instansi.php') ?>
        <?php include('menu/adm_aset.php') ?>
        <?php include('menu/staf_aset.php') ?>
        <?php include('menu/teknisi.php') ?>

    </div>
</aside>