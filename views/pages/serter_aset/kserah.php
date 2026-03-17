<?php
    PageHeader(
        "Serah Terima Aset",
        "Pencatatan proses mutasi dan dokumentasi perpindahan tangan aset",
       buttonhref("?pg=$pg&fl=detail&ak=tambah","Tambah","primary","circle-plus","")
    );

    $BtnAksi = AksiDropdown(
        [
            ["", "?pg=$pg&fl=detail&ak=edit&id=xxxx", "pencil", "Edit"],
            ["print", "#", "printer", "Cetak", "", "cetakDariFile('nosabaraha','surat')"],
            ["hr"],
            ["hapus", "#", "trash-2", "Hapus", "danger", "konfirmasiHapus('?pg=serter_aset&fl=kserah&aksi=hapus&id=XXXXX')"]
        ]
    );

    PageContentTabel(
        <<<th
            <th class="ps-4 py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Waktu</th>
            <th class="ps-4 py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">No. Surat</th>
            <th class="py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Penerima</th>
            <th class="pe-4 py-3 text-end text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Aksi</th>
        th,
        <<<tr
            <tr class="group-hover-shadow">
                <td class="ps-4 py-3 small">09-02-2026 08:00:21</td>

                <td class="ps-4 py-3 small">xxxxx</td>

                <td class="py-3 small">xxxx</td>

                <td class="pe-4 py-3 text-end">
                    $BtnAksi
                </td>
            </tr>
        tr,
        <<<ket
            <span class="text-muted small">Showing <strong>1-10</strong> of <strong>25</strong> users</span>
        ket,
        <<<num
            <li class="page-item disabled"><a class="page-link border-0 rounded-2 text-secondary" href="#"><i data-lucide="chevron-left" style="width: 14px;"></i></a></li>
            <li class="page-item active"><a class="page-link border-0 rounded-2 shadow-sm" href="#" style="background-color: #4338ca; color: white;">1</a></li>
            <li class="page-item"><a class="page-link border-0 rounded-2 text-secondary hover-bg-light" href="#">2</a></li>
            <li class="page-item"><a class="page-link border-0 rounded-2 text-secondary" href="#"><i data-lucide="chevron-right" style="width: 14px;"></i></a></li>
        num
    );

    dialogPrint();

    modalHapus()
?>