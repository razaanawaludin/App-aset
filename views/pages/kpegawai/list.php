<?php 
    
    PageHeader(
        "Pegawai",
        "Pengelolaan data induk dan informasi profil pegawai",
       buttonhref("?pg=$pg&fl=form&ak=tambah","Tambah","primary","circle-plus","")
    );

    $tr = "";
    foreach ($semuaUser as $row) {
        $Aksi = AksiDropdown(
            [
                ["","?pg=$pg&fl=form&hal=$hal&ak=edit&id={$row['IdPegawai']}", "pencil", "Edit"],
                // $AksiReset,
                // $AksiAktif,
                // ["hr"],
                ["hapus","#", "trash-2", "Hapus", "danger","konfirmasiHapus('?pg=$pg&fl=$fl&hal=$hal&ak=hapus&id={$row['IdPegawai']}')"]
            ]
        );

        $roleText = !empty($row['Role']) ? $row['Role'] : 'Tidak Ada Role';

        $tr.=<<<tr
            <tr class="group-hover-shadow">
                <td class="ps-4 py-3">
                    <div class="d-flex align-items-center">
                        <div class="position-relative me-3">
                            <img src="https://ui-avatars.com/api/?name={$row['Nama']}&background=random&color=fff" class="rounded-circle shadow-sm" style="width: 42px; height: 42px; font-size: 0.9rem;">
                            <span class="position-absolute bottom-0 start-100 translate-middle p-1 bg-success border border-white rounded-circle"></span>
                        </div>
                        <div>
                            <span class="text-muted small">{$row['Username']}</span>
                            <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;">{$row['Nama']}</h6>
                        </div>
                    </div>
                </td>
                <td class="py-3 small">{$roleText}</td>
                <td class="pe-4 py-3 text-end">
                    $Aksi
                </td>
            </tr>
        tr;
    }

    

    PageContentTabel(
    <<<th
        <th class="ps-4 py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Pegawai</th>
        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Role</th>
        <th class="pe-4 py-3 text-end text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Aksi</th>
    th,
    <<<Tr
        $tr
    Tr,
    <<<knum
        <span class="text-muted small">Showing <strong>1-10</strong> of <strong>25</strong> users</span>
    knum,
    <<<num
        <li class="page-item disabled"><a class="page-link border-0" href="#">Prev</a></li>
        <li class="page-item active"><a class="page-link border-0 bg-primary shadow-sm" href="#">1</a></li>
        <li class="page-item"><a class="page-link border-0 text-secondary" href="#">2</a></li>
        <li class="page-item"><a class="page-link border-0" href="#">Next</a></li>
    num
    );

    modalHapus();

?>