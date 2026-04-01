<?php
    $idUser = $_SESSION['IdUser'] ?? '';

    PageHeader(
        "BAST",
        "Berita Acara Serah Terima - Kelola dokumen dan approval",
       buttonhref("?pg=$pg&fl=detail&ak=tambah","Buat BAST","primary","circle-plus","")
    );

    $tr = "";
    foreach ($semuaBast as $row) {
        $idBast = $row['IdBast'];
        $tanggal = date('d-m-Y H:i', strtotime($row['Create_at']));
        $noBast = htmlspecialchars($row['NoBast']);
        $penyerah = htmlspecialchars($row['NamaPenyerah'] ?? '-');
        $penerima = htmlspecialchars($row['NamaPenerima'] ?? '-');
        $jumlahAset = $row['JumlahAset'] ?? 0;
        $status = $row['Status'] ?? 'menunggu';
        $approveSerah = $row['ApproveSerah'] ?? 0;
        $approveTerima = $row['ApproveTerima'] ?? 0;

        // Badge status
        if ($status === 'selesai (approved)') {
            $badgeStatus = '<span class="badge rounded-pill px-3 py-2" style="background-color: #d1fae5; color: #065f46; font-size: 0.75rem;">
                <i data-lucide="check-circle" style="width: 12px; margin-bottom: 1px;" class="me-1"></i> Selesai (Approved)
            </span>';
        } else {
            $badgeStatus = '<span class="badge rounded-pill px-3 py-2" style="background-color: #fef3c7; color: #92400e; font-size: 0.75rem;">
                <i data-lucide="clock" style="width: 12px; margin-bottom: 1px;" class="me-1"></i> Menunggu
            </span>';
        }

        // Badge approval detail
        $approveSerahBadge = $approveSerah 
            ? '<span class="badge bg-success bg-opacity-10 text-success" style="font-size: 0.65rem; border-radius: 6px;">Approved</span>'
            : '<span class="badge bg-secondary bg-opacity-10 text-secondary" style="font-size: 0.65rem; border-radius: 6px;">Pending</span>';
        $approveTerimaBadge = $approveTerima 
            ? '<span class="badge bg-success bg-opacity-10 text-success" style="font-size: 0.65rem; border-radius: 6px;">Approved</span>'
            : '<span class="badge bg-secondary bg-opacity-10 text-secondary" style="font-size: 0.65rem; border-radius: 6px;">Pending</span>';

        // Aksi
        $aksiItems = [];
        $aksiItems[] = ["","?pg=$pg&fl=detail&ak=edit&id=$idBast", "eye", "Detail"];
        if ($status === 'selesai (approved)') {
            $aksiItems[] = ["","?pg=$pg&fl=cetak&id=$idBast", "printer", "Cetak"];
        }
        $aksiItems[] = ["hr"];
        $aksiItems[] = ["hapus", "#", "trash-2", "Hapus", "danger", "konfirmasiHapus('?pg=$pg&fl=$fl&ak=hapus&id=$idBast')"];
        $Aksi = AksiDropdown($aksiItems);

        $tr .= <<<row
            <tr class="group-hover-shadow">
                <td class="ps-4 py-3 small text-muted">$tanggal</td>
                <td class="py-3">
                    <span class="fw-bold text-dark small">$noBast</span>
                </td>
                <td class="py-3">
                    <div class="small">
                        <div class="d-flex align-items-center gap-1 mb-1">
                            <span class="text-muted" style="font-size: 0.7rem; min-width: 55px;">Penyerah:</span>
                            <span class="fw-bold text-dark">$penyerah</span>
                            $approveSerahBadge
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <span class="text-muted" style="font-size: 0.7rem; min-width: 55px;">Penerima:</span>
                            <span class="fw-bold text-dark">$penerima</span>
                            $approveTerimaBadge
                        </div>
                    </div>
                </td>
                <td class="py-3 text-center">
                    <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2 py-1" style="border-radius: 6px; font-size: 0.75rem;">$jumlahAset aset</span>
                </td>
                <td class="py-3 text-center">$badgeStatus</td>
                <td class="pe-4 py-3 text-end">$Aksi</td>
            </tr>
row;
    }

    if (empty($tr)) {
        $tr = '<tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data BAST.</td></tr>';
    }

    PageContentTabel(
    <<<th
        <th class="ps-4 py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Tanggal</th>
        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">No. BAST</th>
        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Penyerah / Penerima</th>
        <th class="py-3 text-center text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Aset</th>
        <th class="py-3 text-center text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Status</th>
        <th class="pe-4 py-3 text-end text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Aksi</th>
    th,
    $tr,
    <<<knum
        <span class="text-muted small">Total <strong>{$jumlahBast}</strong> BAST</span>
    knum,
    ""
    );

    modalHapus();
?>
