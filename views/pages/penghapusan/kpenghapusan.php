<?php
    PageHeader(
        "Penghapusan Aset",
        "Kelola dokumen penghapusan dan berita acara penghapusan aset",
       buttonhref("?pg=$pg&fl=tambah","Buat Dokumen","danger","file-x",""  )
    );

    $tr = "";
    $no = 1;
    foreach ($semuaPenghapusan as $row) {
        $noDokumen   = htmlspecialchars($row['NoPenghapusan'] ?? '-');
        $namaPJ      = htmlspecialchars($row['NamaPenanggungJawab'] ?? '-');
        $alasan      = htmlspecialchars($row['AlasanPenghapusan'] ?? '-');
        $jumlahAset  = $row['JumlahAset'] ?? 0;
        $tglDibuat   = !empty($row['Create_at']) ? date('d M Y', strtotime($row['Create_at'])) : '-';
        $status      = $row['Status'] ?? 'draft';

        // Badge status
        $badgeStatus = ($status === 'selesai')
            ? '<span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2" style="border-radius: 8px; font-size: 0.7rem;"><i data-lucide="check-circle" style="width: 12px; margin-bottom: 1px;" class="me-1"></i>Selesai</span>'
            : '<span class="badge bg-warning bg-opacity-10 text-warning fw-bold px-3 py-2" style="border-radius: 8px; font-size: 0.7rem;"><i data-lucide="clock" style="width: 12px; margin-bottom: 1px;" class="me-1"></i>Draft</span>';

        // Badge alasan
        $alasanColor = 'secondary';
        $alasanIcon = 'alert-circle';
        switch (strtolower($alasan)) {
            case 'rusak berat':    $alasanColor = 'danger';  $alasanIcon = 'hammer'; break;
            case 'hilang':         $alasanColor = 'dark';    $alasanIcon = 'search'; break;
            case 'dijual':         $alasanColor = 'info';    $alasanIcon = 'tag'; break;
            case 'hibah':          $alasanColor = 'primary'; $alasanIcon = 'gift'; break;
            case 'kadaluarsa':     $alasanColor = 'warning'; $alasanIcon = 'timer'; break;
        }
        $badgeAlasan = "<span class=\"badge bg-{$alasanColor} bg-opacity-10 text-{$alasanColor} fw-bold px-2 py-1\" style=\"border-radius: 6px; font-size: 0.7rem;\"><i data-lucide=\"{$alasanIcon}\" style=\"width: 11px; margin-bottom: 1px;\" class=\"me-1\"></i>{$alasan}</span>";

        $Aksi = AksiDropdown(
            [
                ["","?pg=$pg&fl=edit&id={$row['IdPenghapusan']}", "pencil", "Edit / Detail"],
                ["hr"],
                ["hapus","#", "trash-2", "Hapus", "danger","konfirmasiHapus('?pg=$pg&fl=$fl&ak=hapus&id={$row['IdPenghapusan']}')"]
            ]
        );

        $tr .= <<<row
            <tr class="group-hover-shadow">
                <td class="ps-4 py-3 text-center text-muted small">$no</td>
                <td class="py-3">
                    <div>
                        <span class="text-muted" style="font-size: 0.7rem;">DOKUMEN</span>
                        <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.85rem;">$noDokumen</h6>
                    </div>
                </td>
                <td class="py-3">$badgeAlasan</td>
                <td class="py-3 small text-muted">$namaPJ</td>
                <td class="py-3 text-center">
                    <span class="badge bg-light text-dark border fw-bold px-2 py-1" style="font-size: 0.75rem;">$jumlahAset aset</span>
                </td>
                <td class="py-3 small text-muted">$tglDibuat</td>
                <td class="py-3 text-center">$badgeStatus</td>
                <td class="pe-4 py-3 text-end">
                    $Aksi
                </td>
            </tr>
row;
        $no++;
    }

    if (empty($tr)) {
        $tr = '<tr><td colspan="8" class="text-center py-5 text-muted"><div class="py-3"><i data-lucide="inbox" style="width: 40px; height: 40px; opacity: 0.3;" class="mb-2 d-block mx-auto"></i><span class="d-block">Belum ada dokumen penghapusan.</span><span class="d-block small mt-1">Klik tombol "Buat Dokumen" untuk memulai.</span></div></td></tr>';
    }

    PageContentTabel(
    <<<th
        <th class="ps-4 py-3 text-center text-uppercase text-secondary" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; width: 50px;">No</th>
        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Nomor Dokumen</th>
        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Alasan</th>
        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Penanggung Jawab</th>
        <th class="py-3 text-center text-uppercase text-secondary" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Jumlah</th>
        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Tanggal</th>
        <th class="py-3 text-center text-uppercase text-secondary" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Status</th>
        <th class="pe-4 py-3 text-end text-uppercase text-secondary" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Aksi</th>
    th,
    $tr,
    <<<knum
        <span class="text-muted small">Total <strong>{$jumlahPH}</strong> dokumen penghapusan</span>
    knum,
    ""
    );

    modalHapus();
?>