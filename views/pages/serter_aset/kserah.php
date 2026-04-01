<?php
    PageHeader(
        "Serah Terima Aset",
        "Pencatatan proses mutasi dan dokumentasi perpindahan tangan aset",
       buttonhref("?pg=$pg&fl=detail&ak=tambah","Tambah","primary","circle-plus","")
    );

    $tr = "";
    foreach ($semuaSerahTerima as $row) {
        $idST = $row['IdSerahTerima'];
        $tanggal = date('d-m-Y H:i', strtotime($row['Create_at']));
        $noSurat = htmlspecialchars($row['NoSerahTerima']);
        $penyerah = htmlspecialchars($row['NamaPenyerah'] ?? '-');
        $penerima = htmlspecialchars($row['NamaPenerima'] ?? '-');
        $jumlahAset = $row['JumlahAset'] ?? 0;
        $status = $row['Status'] ?? 'draft';

        $badgeStatus = ($status === 'selesai')
            ? '<span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2" style="border-radius: 8px; font-size: 0.75rem;"><i data-lucide="check-circle" style="width: 12px; margin-bottom: 1px;" class="me-1"></i> Selesai</span>'
            : '<span class="badge bg-warning bg-opacity-10 text-warning fw-bold px-3 py-2" style="border-radius: 8px; font-size: 0.75rem;"><i data-lucide="clock" style="width: 12px; margin-bottom: 1px;" class="me-1"></i> Draft</span>';

        // Aksi berdasarkan status
        $aksiItems = [];
        if ($status === 'draft') {
            $aksiItems[] = ["", "?pg=$pg&fl=detail&ak=edit&id=$idST", "pencil", "Edit"];
        } else {
            $aksiItems[] = ["", "?pg=$pg&fl=detail&ak=edit&id=$idST", "eye", "Lihat Detail"];
        }
        $aksiItems[] = ["", "?pg=$pg&fl=detail&ak=edit&id=$idST", "printer", "Cetak"];
        $aksiItems[] = ["hr"];
        $aksiItems[] = ["hapus", "#", "trash-2", "Hapus", "danger", "konfirmasiHapus('?pg=$pg&fl=$fl&ak=hapus&id=$idST')"];

        $Aksi = AksiDropdown($aksiItems);

        // Tombol edit langsung (visible)
        $editLink = "?pg=$pg&fl=detail&ak=edit&id=$idST";
        $editLabel = ($status === 'draft') ? 'Edit' : 'Lihat';
        $editIcon = ($status === 'draft') ? 'pencil' : 'eye';
        $editColor = ($status === 'draft') ? 'primary' : 'secondary';

        $tr .= <<<row
            <tr class="group-hover-shadow">
                <td class="ps-4 py-3 small text-muted">$tanggal</td>
                <td class="ps-4 py-3">
                    <span class="fw-bold text-dark small">$noSurat</span>
                </td>
                <td class="py-3">
                    <div class="small">
                        <div class="text-muted" style="font-size: 0.7rem;">Penyerah:</div>
                        <div class="fw-bold text-dark">$penyerah</div>
                        <div class="text-muted mt-1" style="font-size: 0.7rem;">Penerima:</div>
                        <div class="fw-bold text-dark">$penerima</div>
                    </div>
                </td>
                <td class="py-3 text-center">
                    <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2 py-1" style="border-radius: 6px; font-size: 0.75rem;">$jumlahAset aset</span>
                </td>
                <td class="py-3 text-center">$badgeStatus</td>
                <td class="pe-4 py-3 text-end">
                    <div class="d-flex gap-1 justify-content-end align-items-center">
    
                        $Aksi
                    </div>
                </td>
            </tr>
row;
    }

    if (empty($tr)) {
        $tr = '<tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data serah terima aset.</td></tr>';
    }

    PageContentTabel(
    <<<th
        <th class="ps-4 py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Waktu</th>
        <th class="ps-4 py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">No. Surat</th>
        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Penyerah / Penerima</th>
        <th class="py-3 text-center text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Aset</th>
        <th class="py-3 text-center text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Status</th>
        <th class="pe-4 py-3 text-end text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Aksi</th>
    th,
    $tr,
    <<<knum
        <span class="text-muted small">Total <strong>{$jumlahST}</strong> serah terima</span>
    knum,
    ""
    );

    modalHapus();
?>