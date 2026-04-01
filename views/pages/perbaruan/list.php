<?php
    PageHeader(
        "Perbaruan Aset",
        "Catatan perbaikan, perawatan, dan pemeliharaan aset",
       buttonhref("?pg=$pg&fl=tambah","Tambah Perbaruan","primary","circle-plus","")
    );

    // Statistik ringkasan
    $formatBiaya = 'Rp ' . number_format($totalBiaya, 0, ',', '.');
?>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-25 rounded-3 me-3" style="width: 48px; height: 48px;">
                    <i data-lucide="wrench" class="text-white" style="width: 22px;"></i>
                </div>
                <div>
                    <div class="text-white" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; opacity: 0.85;">Total Perbaruan</div>
                    <div class="text-white fw-bold fs-5"><?= $jumlahPerbaruan ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-25 rounded-3 me-3" style="width: 48px; height: 48px;">
                    <i data-lucide="loader" class="text-white" style="width: 22px;"></i>
                </div>
                <div>
                    <div class="text-white" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; opacity: 0.85;">Sedang Proses</div>
                    <div class="text-white fw-bold fs-5"><?= $totalProses ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-25 rounded-3 me-3" style="width: 48px; height: 48px;">
                    <i data-lucide="banknote" class="text-white" style="width: 22px;"></i>
                </div>
                <div>
                    <div class="text-white" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; opacity: 0.85;">Total Biaya</div>
                    <div class="text-white fw-bold fs-6"><?= $formatBiaya ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $tr = "";
    $no = 1;
    foreach ($semuaPerbaruan as $row) {
        $fotoSrc = !empty($row['FotoAset']) && file_exists('assets/uploads/' . $row['FotoAset'])
            ? 'assets/uploads/' . htmlspecialchars($row['FotoAset'])
            : 'https://ui-avatars.com/api/?name=' . urlencode($row['NamaAset'] ?? 'Aset') . '&background=random&color=fff';

        $namaAset = htmlspecialchars($row['NamaAset'] ?? '-');
        $kodeAset = htmlspecialchars($row['KodeAset'] ?? '-');
        $jenis    = htmlspecialchars($row['JenisPerbaruan'] ?? '-');
        $teknisi  = htmlspecialchars($row['Teknisi'] ?? '-');
        $biaya    = 'Rp ' . number_format(floatval($row['Biaya']), 0, ',', '.');
        $tglMulai = !empty($row['TanggalMulai']) ? date('d M Y', strtotime($row['TanggalMulai'])) : '-';
        $status   = $row['Status'] ?? 'proses';

        // Badge status
        switch ($status) {
            case 'selesai':
                $badgeStatus = '<span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2" style="border-radius: 8px; font-size: 0.7rem;"><i data-lucide="check-circle" style="width: 12px; margin-bottom: 1px;" class="me-1"></i>Selesai</span>';
                break;
            case 'dibatalkan':
                $badgeStatus = '<span class="badge bg-danger bg-opacity-10 text-danger fw-bold px-3 py-2" style="border-radius: 8px; font-size: 0.7rem;"><i data-lucide="x-circle" style="width: 12px; margin-bottom: 1px;" class="me-1"></i>Dibatalkan</span>';
                break;
            default:
                $badgeStatus = '<span class="badge bg-warning bg-opacity-10 text-warning fw-bold px-3 py-2" style="border-radius: 8px; font-size: 0.7rem;"><i data-lucide="clock" style="width: 12px; margin-bottom: 1px;" class="me-1"></i>Proses</span>';
                break;
        }

        // Badge jenis
        $jenisIcon = 'wrench';
        $jenisColor = 'primary';
        switch (strtolower($jenis)) {
            case 'perbaikan': $jenisIcon = 'hammer'; $jenisColor = 'danger'; break;
            case 'perawatan': $jenisIcon = 'shield-check'; $jenisColor = 'info'; break;
            case 'upgrade':   $jenisIcon = 'arrow-up-circle'; $jenisColor = 'success'; break;
            case 'kalibrasi': $jenisIcon = 'gauge'; $jenisColor = 'warning'; break;
        }
        $badgeJenis = "<span class=\"badge bg-{$jenisColor} bg-opacity-10 text-{$jenisColor} fw-bold px-2 py-1\" style=\"border-radius: 6px; font-size: 0.7rem;\"><i data-lucide=\"{$jenisIcon}\" style=\"width: 11px; margin-bottom: 1px;\" class=\"me-1\"></i>{$jenis}</span>";

        $Aksi = AksiDropdown(
            [
                ["","?pg=$pg&fl=edit&id={$row['IdPerbaruan']}", "pencil", "Edit"],
                ["hr"],
                ["hapus","#", "trash-2", "Hapus", "danger","konfirmasiHapus('?pg=$pg&fl=$fl&ak=hapus&id={$row['IdPerbaruan']}')"]
            ]
        );

        $tr .= <<<row
            <tr class="group-hover-shadow">
                <td class="ps-4 py-3 text-center text-muted small">$no</td>
                <td class="py-3">
                    <div class="d-flex align-items-center">
                        <div class="position-relative me-3">
                            <img src="$fotoSrc" 
                                alt="Foto Aset" 
                                class="rounded-3 shadow-sm border border-light" 
                                style="width: 42px; height: 42px; object-fit: cover;">
                        </div>
                        <div>
                            <span class="text-muted" style="font-size: 0.7rem;">$kodeAset</span>
                            <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.85rem;">$namaAset</h6>
                        </div>
                    </div>
                </td>
                <td class="py-3">$badgeJenis</td>
                <td class="py-3 small text-muted">$teknisi</td>
                <td class="py-3 small text-muted">$tglMulai</td>
                <td class="py-3 fw-medium text-dark small">$biaya</td>
                <td class="py-3 text-center">$badgeStatus</td>
                <td class="pe-4 py-3 text-end">
                    $Aksi
                </td>
            </tr>
row;
        $no++;
    }

    if (empty($tr)) {
        $tr = '<tr><td colspan="8" class="text-center py-5 text-muted"><div class="py-3"><i data-lucide="inbox" style="width: 40px; height: 40px; opacity: 0.3;" class="mb-2 d-block mx-auto"></i><span class="d-block">Belum ada data perbaruan aset.</span><span class="d-block small mt-1">Klik tombol "Tambah Perbaruan" untuk menambahkan data baru.</span></div></td></tr>';
    }

    PageContentTabel(
    <<<th
        <th class="ps-4 py-3 text-center text-uppercase text-secondary" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; width: 50px;">No</th>
        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Aset</th>
        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Jenis</th>
        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Teknisi</th>
        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Tanggal</th>
        <th class="py-3 text-uppercase text-secondary" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Biaya</th>
        <th class="py-3 text-center text-uppercase text-secondary" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Status</th>
        <th class="pe-4 py-3 text-end text-uppercase text-secondary" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Aksi</th>
    th,
    $tr,
    <<<knum
        <span class="text-muted small">Total <strong>{$jumlahPerbaruan}</strong> data perbaruan</span>
    knum,
    ""
    );

    modalHapus();
?>
