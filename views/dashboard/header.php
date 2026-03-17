<?php
$idUser = $_SESSION['IdUser'] ?? '';
$headeruser = ['Nama' => 'User'];

if ($idUser) {
    $headerkondisi = ['IdPegawai' => $idUser];
    $qheaderuser = selectData($koneksiku, 'pegawai', $headerkondisi);
    if (!empty($qheaderuser)) {
        $headeruser = $qheaderuser[0];
    }
}
?>
 
 <header class="d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-light border d-lg-none" id="mobileToggle">
            <i data-lucide="menu"></i>
        </button>
        <div class="d-none d-md-block">
            <div class="text-muted small fw-bold">Pages / Overview</div>
            <div class="fw-bold text-dark">Dashboard</div>
        </div>
    </div>

    <div class="d-flex align-items-center gap-4">
        
        <div class="dropdown">
            <div class="d-flex align-items-center gap-3 cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                <div class="text-end d-none d-sm-block">
                    <p class="mb-0 fw-bold small"><?= $headeruser['Nama'] ?></p>
                    <!-- <p class="mb-0 text-muted" style="font-size: 0.7rem;">Super Admin</p> -->
                </div>
                <img src="https://ui-avatars.com/api/?name=<?= $headeruser['Nama'] ?>&background=random&color=fff" width="40" height="40" class="rounded-circle border border-2 border-white shadow-sm">
            </div>

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-premium mt-2">
                <li><a class="dropdown-item dropdown-item-premium text-danger" href="?pg=logout"><i data-lucide="log-out" size="16"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</header>