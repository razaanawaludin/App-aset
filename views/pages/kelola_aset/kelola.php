<?php
    PageHeader(
        "Aset",
        "Pengelolaan daftar inventaris dan pelacakan status aset secara mendetail",
       buttonhref("?pg=$pg&fl=tambah&ak=tambah","Tambah","primary","circle-plus","")
    );

    $tr = "";
    foreach ($semuaAset as $row) {
        $fotoSrc = !empty($row['FotoAset']) && file_exists('assets/uploads/' . $row['FotoAset'])
            ? 'assets/uploads/' . htmlspecialchars($row['FotoAset'])
            : 'https://ui-avatars.com/api/?name=' . urlencode($row['NamaAset']) . '&background=random&color=fff';

        // Badge kondisi aset
        $kondisiAset = $row['KondisiAset'] ?? 'Baik';
        switch ($kondisiAset) {
            case 'Baik':
                $kondisiBadge = '<span class="badge rounded-pill px-3 py-2" style="background-color: #d1fae5; color: #065f46; font-size: 0.75rem;"> Baik</span>';
                break;
            case 'Kurang Baik':
                $kondisiBadge = '<span class="badge rounded-pill px-3 py-2" style="background-color: #fef3c7; color: #92400e; font-size: 0.75rem;"> Kurang Baik</span>';
                break;
            case 'Rusak Ringan':
                $kondisiBadge = '<span class="badge rounded-pill px-3 py-2" style="background-color: #ffedd5; color: #9a3412; font-size: 0.75rem;"> Rusak Ringan</span>';
                break;
            case 'Rusak Berat':
                $kondisiBadge = '<span class="badge rounded-pill px-3 py-2" style="background-color: #fee2e2; color: #991b1b; font-size: 0.75rem;"> Rusak Berat</span>';
                break;
            default:
                $kondisiBadge = '<span class="badge rounded-pill px-3 py-2" style="background-color: #f3f4f6; color: #4b5563; font-size: 0.75rem;">' . htmlspecialchars($kondisiAset) . '</span>';
        }

        $Aksi = AksiDropdown(
            [
                ["","?pg=$pg&fl=edit&ak=edit&id={$row['IdAset']}", "pencil", "Edit"],
                ["qr","#", "qr-code", "QR-Code", "","generateQRCode('{$row['KodeAset']}', '{$row['NamaAset']}')"],
                ["hr"],
                ["hapus","#", "trash-2", "Hapus", "danger","konfirmasiHapus('?pg=$pg&fl=$fl&ak=hapus&id={$row['IdAset']}')"]
            ]
        );

        $tr .= <<<row
            <tr class="group-hover-shadow">
                <td class="ps-4 py-3">
                    <div class="d-flex align-items-center">
                        <div class="position-relative me-3">
                            <img src="$fotoSrc" 
                                alt="Foto Barang" 
                                class="rounded-3 shadow-sm border border-light" 
                                style="width: 48px; height: 48px; object-fit: cover;">
                        </div>
                        <div>
                            <span class="text-muted small">KODE: {$row['KodeAset']}</span>
                            <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;">{$row['NamaAset']}</h6>
                        </div>
                    </div>
                </td>
                <td class="py-3"><span class="fw-medium text-dark">{$row['Kategori']}</span></td>
                <td class="py-3 text-secondary small">{$row['Lokasi']}</td>
                <td class="py-3">$kondisiBadge</td>
                <td class="pe-4 py-3 text-end">
                    $Aksi
                </td>
            </tr>
row;
    }

    if (empty($tr)) {
        $tr = '<tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data aset.</td></tr>';
    }

    PageContentTabel(
    <<<th
        <th class="ps-4 py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Inventaris</th>
        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Kategori</th>
        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Lokasi</th>
        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Kondisi</th>
        <th class="pe-4 py-3 text-end text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Aksi</th>
    th,
    $tr,
    <<<knum
        <span class="text-muted small">Total <strong>{$jumlahAset}</strong> aset</span>
    knum,
    ""
    );

    modalHapus();

    modalQRCode();
?>