<?php
    $idUser = $_SESSION['IdUser'] ?? '';
    $isEdit = ($ak === 'edit' && !empty($id));
    $isTambah = ($ak === 'tambah');
    $isDisetujui = ($status_val === 'selesai (approved)');

    // Cek apakah user login adalah penyerah atau penerima
    $isUserSerah = ($idUser == $penyerah_val);
    $isUserTerima = ($idUser == $penerima_val);

    PageHeader(
        "BAST",
        ($isTambah) ? "Buat dokumen BAST baru" : "Detail Berita Acara Serah Terima",
       buttonhref("?pg=$pg&fl=list","Kembali","primary","circle-chevron-left","")
    );
?>

<div class="container-fluid p-0">
    <div class="row g-4">

        <!-- Left Panel: Form -->
        <div class="col-lg-5">
            <?php
                // Header badge
                $headerBadge = '';
                if ($isEdit && !$isDisetujui) {
                    $headerBadge = '<span class="badge rounded-pill px-3 py-2" style="background-color: #fef3c7; color: #92400e; font-size: 0.7rem;">Menunggu Approval</span>';
                } elseif ($isDisetujui) {
                    $headerBadge = '<span class="badge rounded-pill px-3 py-2" style="background-color: #d1fae5; color: #065f46; font-size: 0.7rem;">Selesai (Approved)</span>';
                }

                $docTitle = $isTambah ? 'Dokumen Baru' : 'Detail BAST';
                $noBastValue = htmlspecialchars($isEdit ? $noBast_val : $noBastOtomatis);
                
                $tglHtml = '';
                if ($isEdit && !empty($tanggalDokumen)) {
                    $tglStr = date('d-m-Y H:i', strtotime($tanggalDokumen));
                    $tglHtml = '
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">
                            <i data-lucide="calendar" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Tanggal
                        </label>
                        <input type="text" value="' . $tglStr . '" class="form-control form-control-lg bg-light border-0 fs-6" style="border-radius: 10px;" readonly>
                    </div>';
                }

                $attrSelect = $isDisetujui ? 'disabled' : 'required';
                
                $opsiPenyerah = '<option value="" disabled ' . (empty($penyerah_val) ? 'selected' : '') . '>Pilih Penyerah...</option>';
                foreach ($semuaPegawai as $p) {
                    $sel = ($penyerah_val == $p['IdPegawai']) ? 'selected' : '';
                    $opsiPenyerah .= '<option value="' . $p['IdPegawai'] . '" ' . $sel . '>' . htmlspecialchars($p['Nama']) . '</option>';
                }

                $opsiPenerima = '<option value="" disabled ' . (empty($penerima_val) ? 'selected' : '') . '>Pilih Penerima...</option>';
                foreach ($semuaPegawai as $p) {
                    $sel = ($penerima_val == $p['IdPegawai']) ? 'selected' : '';
                    $opsiPenerima .= '<option value="' . $p['IdPegawai'] . '" ' . $sel . '>' . htmlspecialchars($p['Nama']) . '</option>';
                }

                $attrKet = $isDisetujui ? 'readonly' : '';
                $ketValue = htmlspecialchars($keterangan_val);

                $btnSubmitHtml = '';
                if (!$isDisetujui) {
                    if ($isTambah) {
                        $btnSubmitHtml = '
                        <div class="d-grid">
                            <button type="submit" name="Btn" value="Buat Dokumen" class="btn btn-primary fw-bold shadow-sm py-2" style="border-radius: 10px;">
                                <i data-lucide="plus" style="width:18px" class="me-1"></i> Buat Dokumen
                            </button>
                        </div>';
                    } else {
                        $btnSubmitHtml = '
                        <div class="d-grid">
                            <button type="submit" name="Btn" value="Simpan" class="btn btn-primary fw-bold shadow-sm py-2" style="border-radius: 10px;">
                                <i data-lucide="save" style="width:18px" class="me-1"></i> Simpan Perubahan
                            </button>
                        </div>';
                    }
                }

                $approvalPanelHtml = '';
                if ($isEdit) {
                    $bgSerah = $approveSerah_val ? '#f0fdf4' : '#f8fafc';
                    $bgSerahIcon = $approveSerah_val ? '#dcfce7' : '#e2e8f0';
                    $colorSerahIcon = $approveSerah_val ? '#16a34a' : '#94a3b8';
                    $iconSerah = $approveSerah_val ? 'check' : 'clock';
                    $namaSerah = htmlspecialchars($namaPenyerah ?: 'Penyerah');
                    
                    $badgeSerahHtml = '';
                    if ($approveSerah_val) {
                        $badgeSerahHtml = '<span class="badge rounded-pill px-3 py-2" style="background-color: #d1fae5; color: #065f46; font-size: 0.7rem;">Approved</span>';
                    } elseif ($isUserSerah && !$isDisetujui) {
                        $badgeSerahHtml = '<a href="?pg=' . $pg . '&fl=detail&ak=approve_serah&id=' . $id . '" class="btn btn-success btn-sm fw-bold rounded-pill px-3 shadow-sm" onclick="return confirm(\'Yakin approve sebagai pihak penyerah?\')"><i data-lucide="check" style="width: 14px;" class="me-1"></i> Approve</a>';
                    } else {
                        $badgeSerahHtml = '<span class="badge rounded-pill px-3 py-2" style="background-color: #fef3c7; color: #92400e; font-size: 0.7rem;">Menunggu</span>';
                    }

                    $bgTerima = $approveTerima_val ? '#f0fdf4' : '#f8fafc';
                    $bgTerimaIcon = $approveTerima_val ? '#dcfce7' : '#e2e8f0';
                    $colorTerimaIcon = $approveTerima_val ? '#16a34a' : '#94a3b8';
                    $iconTerima = $approveTerima_val ? 'check' : 'clock';
                    $namaTerima = htmlspecialchars($namaPenerima ?: 'Penerima');

                    $badgeTerimaHtml = '';
                    if ($approveTerima_val) {
                        $badgeTerimaHtml = '<span class="badge rounded-pill px-3 py-2" style="background-color: #d1fae5; color: #065f46; font-size: 0.7rem;">Approved</span>';
                    } elseif ($isUserTerima && !$isDisetujui) {
                        $badgeTerimaHtml = '<a href="?pg=' . $pg . '&fl=detail&ak=approve_terima&id=' . $id . '" class="btn btn-success btn-sm fw-bold rounded-pill px-3 shadow-sm" onclick="return confirm(\'Yakin approve sebagai pihak penerima?\')"><i data-lucide="check" style="width: 14px;" class="me-1"></i> Approve</a>';
                    } else {
                        $badgeTerimaHtml = '<span class="badge rounded-pill px-3 py-2" style="background-color: #fef3c7; color: #92400e; font-size: 0.7rem;">Menunggu</span>';
                    }

                    $cetakBtnHtml = '';
                    if ($isDisetujui) {
                        $cetakBtnHtml = '
                        <div class="mt-3">
                            <a href="?pg=' . $pg . '&fl=cetak&id=' . $id . '" class="btn btn-outline-primary w-100 fw-bold rounded-3" target="_blank">
                                <i data-lucide="printer" style="width: 16px;" class="me-1"></i> Cetak / Export BAST
                            </a>
                        </div>';
                    }

                    $approvalPanelHtml = '
                    <div class="mt-4 pt-4 border-top">
                        <h6 class="fw-bold text-dark mb-3" style="font-size: 0.9rem;">
                            <i data-lucide="shield-check" style="width: 16px; margin-bottom: 2px;" class="me-1 text-primary"></i> Status Approval
                        </h6>

                        <!-- Penyerah Approval -->
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3 mb-2" style="background: ' . $bgSerah . ';">
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: ' . $bgSerahIcon . ';">
                                    <i data-lucide="' . $iconSerah . '" style="width: 16px; color: ' . $colorSerahIcon . ';"></i>
                                </div>
                                <div>
                                    <div class="fw-bold small text-dark">' . $namaSerah . '</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">Pihak Penyerah</div>
                                </div>
                            </div>
                            ' . $badgeSerahHtml . '
                        </div>

                        <!-- Penerima Approval -->
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: ' . $bgTerima . ';">
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: ' . $bgTerimaIcon . ';">
                                    <i data-lucide="' . $iconTerima . '" style="width: 16px; color: ' . $colorTerimaIcon . ';"></i>
                                </div>
                                <div>
                                    <div class="fw-bold small text-dark">' . $namaTerima . '</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">Pihak Penerima</div>
                                </div>
                            </div>
                            ' . $badgeTerimaHtml . '
                        </div>

                        ' . $cetakBtnHtml . '
                    </div>';
                }

                $formHtml = '
                <form method="POST" autocomplete="off">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">
                            <i data-lucide="file-text" style="width: 16px; margin-bottom: 2px;" class="me-1 text-primary"></i>
                            ' . $docTitle . '
                        </h6>
                        ' . $headerBadge . '
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">
                            <i data-lucide="hash" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Nomor BAST
                        </label>
                        <input type="text" value="' . $noBastValue . '" class="form-control form-control-lg bg-light border-0 fs-6" style="border-radius: 10px;" readonly>
                    </div>

                    ' . $tglHtml . '

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">
                            <i data-lucide="user-check" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Pihak Penyerah
                        </label>
                        <select name="penyerah" class="form-select form-select-lg bg-light border-0 fs-6" style="border-radius: 10px;" ' . $attrSelect . '>
                            ' . $opsiPenyerah . '
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">
                            <i data-lucide="user-plus" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Pihak Penerima
                        </label>
                        <select name="penerima" class="form-select form-select-lg bg-light border-0 fs-6" style="border-radius: 10px;" ' . $attrSelect . '>
                            ' . $opsiPenerima . '
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">
                            <i data-lucide="file-text" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Keterangan
                        </label>
                        <textarea name="keterangan" class="form-control bg-light border-0 fs-6" style="border-radius: 10px; min-height: 80px;" placeholder="Keterangan tambahan..." ' . $attrKet . '>' . $ketValue . '</textarea>
                    </div>

                    ' . $btnSubmitHtml . '
                </form>
                ' . $approvalPanelHtml;

                PageContentForm($formHtml);
            ?>
        </div>

        <!-- Right Panel: Daftar Aset -->
        <?php if ($isEdit): ?>
        <div class="col-lg-7">
            <?php
                // Form tambah aset
                $formTambahAset = '';
                if (!$isDisetujui) {
                    $opsiAset = '<option value="" disabled selected>Pilih Aset...</option>';
                    foreach ($semuaAset as $aset) {
                        $opsiAset .= '<option value="' . $aset['IdAset'] . '">' . htmlspecialchars($aset['KodeAset'] . ' - ' . $aset['NamaAset']) . '</option>';
                    }

                    $formTambahAset = <<<fa
                        <div class="card border-0 shadow-sm rounded-4 mb-3" style="background: #f8fafc;">
                            <div class="card-body p-3">
                                <form method="POST" class="d-flex gap-2 align-items-center">
                                    <select name="id_aset" class="form-select form-select-sm bg-white border-0 fw-medium" style="border-radius: 8px; flex: 1;" required>
                                        $opsiAset
                                    </select>
                                    <button type="submit" name="Btn" value="Tambah" class="btn btn-primary btn-sm fw-bold px-3" style="border-radius: 8px; white-space: nowrap;">
                                        <i data-lucide="plus" style="width: 14px;"></i> Tambah
                                    </button>
                                </form>
                            </div>
                        </div>
fa;
                }

                // Tabel daftar aset
                $barisTabelAset = "";
                $no = 1;
                foreach ($detailAset as $d) {
                    $fotoSrc = !empty($d['FotoAset']) && file_exists('assets/uploads/' . $d['FotoAset'])
                        ? 'assets/uploads/' . htmlspecialchars($d['FotoAset'])
                        : 'https://ui-avatars.com/api/?name=' . urlencode($d['NamaAset'] ?? 'Aset') . '&background=random&color=fff';

                    $hapusBtn = '';
                    if (!$isDisetujui) {
                        $hapusBtn = '<a href="?pg=' . $pg . '&fl=detail&ak=edit&id=' . $id . '&aksi=hapusbarang&idDetail=' . $d['IdBastDetail'] . '" class="btn btn-outline-danger btn-sm rounded-pill px-2" onclick="return confirm(\'Hapus aset ini?\')" style="font-size: 0.7rem;">
                            <i data-lucide="x" style="width: 12px;"></i>
                        </a>';
                    }

                    $barisTabelAset .= <<<tr
                        <tr>
                            <td class="ps-4 py-3 small text-muted">$no</td>
                            <td class="py-3">
                                <div class="d-flex align-items-center">
                                    <img src="$fotoSrc" class="rounded-3 shadow-sm me-2" style="width: 36px; height: 36px; object-fit: cover;">
                                    <div>
                                        <span class="text-muted" style="font-size: 0.7rem;">{$d['KodeAset']}</span>
                                        <div class="fw-bold text-dark small">{$d['NamaAset']}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 small text-muted">{$d['Kategori']}</td>
                            <td class="pe-4 py-3 text-end">$hapusBtn</td>
                        </tr>
tr;
                    $no++;
                }

                if (empty($barisTabelAset)) {
                    $barisTabelAset = '<tr><td colspan="4" class="text-center py-4 text-muted">Belum ada aset ditambahkan.</td></tr>';
                }

                echo $formTambahAset;

                PageContentTabel(
                    <<<th
                        <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold">No</th>
                        <th class="py-3 text-secondary small text-uppercase fw-bold">Aset</th>
                        <th class="py-3 text-secondary small text-uppercase fw-bold">Kategori</th>
                        <th class="pe-4 py-3 text-end text-secondary small text-uppercase fw-bold">Aksi</th>
                    th,
                    $barisTabelAset,
                    <<<knum
                        <span class="text-muted small">Total <strong><?= count($detailAset) ?></strong> aset</span>
                    knum,
                    ""
                );
            ?>
        </div>
        <?php endif; ?>

    </div>
</div>
