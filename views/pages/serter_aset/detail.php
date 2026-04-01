<?php
    PageHeader(
        "Serah Terima Aset",
        ($ak=="edit") ? "Perubahan dokumen serah terima" : "Pembuatan dokumen berita acara dan validasi perpindahan aset secara resmi",
       buttonhref("?pg=$pg&fl=kserah","Kembali","primary","circle-chevron-left","")
    );

    // Opsi pegawai penyerah
    $opsiPenyerah = '<option value="" selected disabled>-- Pilih pegawai --</option>';
    foreach ($semuaPegawai as $peg) {
        $sel = ($penyerah_val == $peg['IdPegawai']) ? 'selected' : '';
        $opsiPenyerah .= "<option value=\"{$peg['IdPegawai']}\" $sel>{$peg['Nama']}</option>";
    }

    // Opsi pegawai penerima
    $opsiPenerima = '<option value="" selected disabled>-- Pilih pegawai --</option>';
    foreach ($semuaPegawai as $peg) {
        $sel = ($penerima_val == $peg['IdPegawai']) ? 'selected' : '';
        $opsiPenerima .= "<option value=\"{$peg['IdPegawai']}\" $sel>{$peg['Nama']}</option>";
    }

    // Opsi aset (filter yang belum ada di detail)
    $asetSudahDipilih = array_column($detailAset, 'IdAset');
    $opsiAset = '<option value="" selected disabled>-- Pilih Aset --</option>';
    foreach ($semuaAset as $aset) {
        if (!in_array($aset['IdAset'], $asetSudahDipilih)) {
            $opsiAset .= "<option value=\"{$aset['IdAset']}\">{$aset['KodeAset']} - {$aset['NamaAset']}</option>";
        }
    }

    // Tentukan nomor surat
    $noSuratDisplay = ($ak === 'edit') ? $noSurat_val : $noSuratOtomatis;

    // Status badge
    $statusBadge = '';
    if ($ak === 'edit') {
        $statusBadge = ($status_val === 'selesai')
            ? '<span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2 ms-2" style="border-radius: 8px;"><i data-lucide="check-circle" style="width: 14px; margin-bottom: 1px;" class="me-1"></i> Selesai</span>'
            : '<span class="badge bg-warning bg-opacity-10 text-warning fw-bold px-3 py-2 ms-2" style="border-radius: 8px;"><i data-lucide="clock" style="width: 14px; margin-bottom: 1px;" class="me-1"></i> Draft</span>';
    }

    // Tentukan readonly jika status selesai
    $isSelesai = ($ak === 'edit' && $status_val === 'selesai');
    $disabledAttr = $isSelesai ? 'disabled' : '';

    // Escape berita acara untuk heredoc
    $beritaAcaraEsc = htmlspecialchars($beritaAcara_val);
?>

<div class="container-fluid p-0">
    <div class="row g-4">
        
        <div class="col-lg-5">
            <?php
                // Tombol-tombol
                $ak_buttons = '';
                if ($ak === 'tambah') {
                    $ak_buttons = button("Btn","Buat Dokumen","primary","file-plus","");
                } elseif ($ak === 'edit' && !$isSelesai) {
                    $ak_buttons = button("Btn","Simpan","primary","save","");
                    $ak_buttons .= ' ' . button("Btn","Selesai","success","circle-check-big","onclick=\"return confirm('Yakin selesaikan serah terima ini? Status tidak dapat dikembalikan.')\"");
                    $ak_buttons .= ' ' . buttonhref("#","Batal","danger","circle-x","data-bs-toggle=\"modal\" data-bs-target=\"#modalHapus\" onclick=\"konfirmasiHapus('?pg=$pg&fl=detail&ak=edit&aksi=hapus&id=$id')\"");
                }
                // Tombol Cetak (hanya tampil jika edit dan sudah ada data)
                if ($ak === 'edit') {
                    $ak_buttons .= ' ' . buttonhref("#","Cetak","info text-white","printer","onclick=\"cetakBeritaAcara()\"");
                }

                $formAction = ($ak === 'edit') ? "index.php?pg=$pg&fl=detail&ak=edit&id=$id" : "index.php?pg=$pg&fl=detail&ak=tambah";

                PageContentForm(
                    <<<a
                        <form method="POST" action="$formAction" autocomplete="off">
                            <div class="d-flex align-items-center mb-4">
                                <h6 class="fw-bold text-dark mb-0">Informasi Dokumen</h6>
                                $statusBadge
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Nomor Serah Terima</label>
                                <div class="position-relative">
                                    <input type="text" name="no_surat" value="$noSuratDisplay" class="form-control form-control-lg bg-light border-0 fs-6 ps-5" style="border-radius: 10px;" readonly>
                                    <div class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                                        <i data-lucide="notebook-tabs" style="width: 18px;"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                    <i data-lucide="user-minus" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Pegawai yang Menyerahkan
                                </label>
                                <select name="penyerah" class="form-select form-select-lg bg-light border-0 fs-6 text-dark" style="cursor: pointer; border-radius: 10px;" required $disabledAttr>
                                    $opsiPenyerah
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                    <i data-lucide="user-plus" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Pegawai yang Menerima
                                </label>
                                <select name="penerima" class="form-select form-select-lg bg-light border-0 fs-6 text-dark" style="cursor: pointer; border-radius: 10px;" required $disabledAttr>
                                    $opsiPenerima
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                    <i data-lucide="message-square" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Keterangan
                                </label>
                                <textarea name="keterangan" class="form-control bg-light border-0 fs-6" style="border-radius: 10px; min-height: 80px;" placeholder="Keterangan tambahan (opsional)" $disabledAttr>$keterangan_val</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                    <i data-lucide="file-text" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Berita Acara
                                </label>
                                <textarea name="berita_acara" class="form-control bg-light border-0 fs-6" style="border-radius: 10px; min-height: 150px;" placeholder="Isi berita acara serah terima aset..." $disabledAttr>$beritaAcara_val</textarea>
                                <div class="form-text text-muted small mt-1">
                                    <i data-lucide="info" style="width: 12px; margin-bottom: 1px;" class="me-1"></i>
                                    Tuliskan isi berita acara secara detail untuk dokumen resmi.
                                </div>
                            </div>

                            <div class="d-flex gap-2 flex-wrap">
                                {$ak_buttons}
                            </div>

                        </form>
                    a
                );
            ?>
        </div>

        <div class="col-lg-7">
            <?php if ($ak === 'edit' && !$isSelesai): ?>
            <?php
                PageContentForm(
                    <<<a
                        <form method="POST" action="index.php?pg=$pg&fl=detail&ak=edit&id=$id" autocomplete="off">
                                <label class="form-label small fw-bold text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                                    <i data-lucide="package" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Tambah Aset ke Dokumen
                                </label>
                                
                                <div class="d-flex gap-2">
                                    <select name="id_aset" class="form-select form-select-lg bg-light border-0 fs-6 text-dark" style="cursor: pointer; border-radius: 10px;" required>
                                        $opsiAset
                                    </select>
                                    <button type="submit" name="Btn" value="Tambah" class="btn btn-primary fw-bold shadow-sm" style="border:none; white-space: nowrap;">
                                        <i data-lucide="circle-plus" style="width:18px" class="me-1"></i> Tambah
                                    </button>
                                </div>
                        </form>
                    a
                );
            ?>
            <?php endif; ?>

            <div class='mt-2'>&nbsp</div>
            <?php
                // Tabel detail aset
                $trDetail = "";
                $nomorUrut = 1;
                foreach ($detailAset as $det) {
                    $kodeAset = htmlspecialchars($det['KodeAset'] ?? '-');
                    $namaAset = htmlspecialchars($det['NamaAset'] ?? '-');
                    $kategori = htmlspecialchars($det['Kategori'] ?? '-');
                    $idDetail = $det['IdDetail'];
                    $fotoAset = !empty($det['FotoAset']) && file_exists('assets/uploads/' . $det['FotoAset'])
                        ? 'assets/uploads/' . htmlspecialchars($det['FotoAset'])
                        : 'https://ui-avatars.com/api/?name=' . urlencode($namaAset) . '&background=random&color=fff';

                    $btnHapusDetail = '';
                    if (!$isSelesai) {
                        $btnHapusDetail = <<<hps
                            <a href="#" class="btn btn-sm btn-danger"
                            data-bs-toggle="modal" 
                            data-bs-target="#modalHapus" 
                            onclick="konfirmasiHapus('?pg=$pg&fl=detail&ak=edit&aksi=hapusbarang&id=$id&idDetail=$idDetail')">
                                <i data-lucide="trash-2" style="width: 16px;"></i>
                            </a>
hps;
                    }

                    $trDetail .= <<<row
                        <tr>
                            <td class="ps-4 py-3 text-center text-muted small">$nomorUrut</td>
                            <td class="ps-3 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="position-relative me-3">
                                        <img src="$fotoAset" 
                                            alt="Foto" 
                                            class="rounded-3 shadow-sm border border-light" 
                                            style="width: 42px; height: 42px; object-fit: cover;">
                                    </div>
                                    <div>
                                        <span class="text-muted" style="font-size: 0.7rem;">$kodeAset</span>
                                        <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.85rem;">$namaAset</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 small text-muted">$kategori</td>
                            <td class="pe-4 text-end">
                                $btnHapusDetail
                            </td>
                        </tr>
row;
                    $nomorUrut++;
                }

                if (empty($trDetail)) {
                    $trDetail = '<tr><td colspan="4" class="text-center py-4 text-muted">Belum ada aset yang ditambahkan.</td></tr>';
                }

                $jumlahDetail = count($detailAset);

                PageContentTabel(
                    <<<a
                        <th class="ps-4 py-3 text-center text-secondary small text-uppercase fw-bold" style="width: 50px;">No</th>
                        <th class="ps-3 py-3 text-secondary small text-uppercase fw-bold">Aset</th>
                        <th class="py-3 text-secondary small text-uppercase fw-bold">Kategori</th>
                        <th class="pe-4 py-3 text-end text-secondary small text-uppercase fw-bold">Aksi</th>
                    a,
                    $trDetail,
                    <<<ket
                        <span class="text-muted small">Total <strong>$jumlahDetail</strong> aset dalam dokumen</span>
                    ket,
                    "")
            ?>

        </div>

    </div>
</div>

<?php
    modalHapus();

    // ===== DATA UNTUK CETAK =====
    // Build tabel aset untuk print
    $printRows = '';
    $noP = 1;
    foreach ($detailAset as $det) {
        $kA = htmlspecialchars($det['KodeAset'] ?? '-');
        $nA = htmlspecialchars($det['NamaAset'] ?? '-');
        $ktg = htmlspecialchars($det['Kategori'] ?? '-');
        $printRows .= "<tr><td style='text-align:center;padding:8px;border:1px solid #ccc;'>$noP</td><td style='padding:8px;border:1px solid #ccc;'>$kA</td><td style='padding:8px;border:1px solid #ccc;'>$nA</td><td style='padding:8px;border:1px solid #ccc;'>$ktg</td></tr>";
        $noP++;
    }
    
    $printNoSurat = htmlspecialchars($noSuratDisplay);
    $printNamaPenyerah = htmlspecialchars($namaPenyerah);
    $printNamaPenerima = htmlspecialchars($namaPenerima);
    $printKeterangan   = nl2br(htmlspecialchars($keterangan_val));
    $printBeritaAcara  = nl2br(htmlspecialchars($beritaAcara_val));
    $printTanggal      = !empty($tanggalDokumen) ? date('d F Y', strtotime($tanggalDokumen)) : date('d F Y');
    $printStatus       = ($status_val === 'selesai') ? 'SELESAI' : 'DRAFT';
?>

<script>
function cetakBeritaAcara() {
    const pw = window.open('', '_blank', 'width=800,height=900');
    pw.document.write(`<!DOCTYPE html>
<html>
<head>
    <title>Berita Acara Serah Terima Aset</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Times New Roman', serif; 
            color: #222; 
            padding: 40px 50px;
            font-size: 13px;
            line-height: 1.6;
        }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px double #333; padding-bottom: 15px; }
        .header h2 { font-size: 18px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 3px; }
        .header h3 { font-size: 15px; text-transform: uppercase; letter-spacing: 1px; font-weight: normal; }
        .header .no-surat { font-size: 13px; color: #555; margin-top: 8px; }
        .info-section { margin: 20px 0; }
        .info-row { display: flex; margin-bottom: 6px; }
        .info-label { width: 200px; font-weight: bold; }
        .info-value { flex: 1; }
        .berita-acara { 
            margin: 20px 0; 
            padding: 15px 20px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            background: #fafafa;
            text-align: justify;
        }
        .ba-title { font-weight: bold; text-transform: uppercase; font-size: 13px; margin-bottom: 10px; letter-spacing: 0.5px; }
        table.aset { width: 100%; border-collapse: collapse; margin: 15px 0; }
        table.aset th { 
            background: #f0f0f0; 
            padding: 8px; 
            border: 1px solid #ccc; 
            font-size: 12px; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
            text-align: left;
        }
        table.aset td { padding: 8px; border: 1px solid #ccc; font-size: 12px; }
        .ttd-section { 
            display: flex; 
            justify-content: space-between; 
            margin-top: 50px; 
            text-align: center; 
        }
        .ttd-box { width: 45%; }
        .ttd-label { font-size: 12px; color: #666; margin-bottom: 5px; }
        .ttd-line { 
            border-bottom: 1px solid #333; 
            margin: 60px auto 5px auto; 
            width: 80%; 
        }
        .ttd-name { font-weight: bold; font-size: 13px; }
        .keterangan { margin: 15px 0; font-style: italic; color: #555; }
        .footer { margin-top: 30px; text-align: center; font-size: 11px; color: #999; border-top: 1px solid #ddd; padding-top: 10px; }
        .status-badge { 
            display: inline-block; 
            padding: 3px 12px; 
            border-radius: 4px; 
            font-size: 11px; 
            font-weight: bold; 
            letter-spacing: 1px;
        }
        .status-selesai { background: #d4edda; color: #155724; }
        .status-draft { background: #fff3cd; color: #856404; }
        @media print {
            body { padding: 20px 30px; }
            @page { margin: 15mm; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Berita Acara</h2>
        <h3>Serah Terima Aset</h3>
        <div class="no-surat">No: <?= $printNoSurat ?></div>
    </div>

    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Nomor Dokumen</div>
            <div class="info-value">: <?= $printNoSurat ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal</div>
            <div class="info-value">: <?= $printTanggal ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Yang Menyerahkan</div>
            <div class="info-value">: <?= $printNamaPenyerah ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Yang Menerima</div>
            <div class="info-value">: <?= $printNamaPenerima ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Status</div>
            <div class="info-value">: <span class="status-badge status-<?= strtolower($printStatus) ?>"><?= $printStatus ?></span></div>
        </div>
    </div>

    <?php if (!empty($beritaAcara_val)): ?>
    <div class="berita-acara">
        <div class="ba-title">Isi Berita Acara</div>
        <p><?= $printBeritaAcara ?></p>
    </div>
    <?php endif; ?>

    <div class="ba-title" style="margin-top: 20px;">Daftar Aset yang Diserahterimakan</div>
    <table class="aset">
        <thead>
            <tr>
                <th style="width:40px; text-align:center;">No</th>
                <th style="width:120px;">Kode Aset</th>
                <th>Nama Aset</th>
                <th style="width:120px;">Kategori</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($printRows)): ?>
                <?= $printRows ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align:center;padding:12px;border:1px solid #ccc;color:#999;">Belum ada aset</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if (!empty($keterangan_val)): ?>
    <div class="keterangan">
        <strong>Keterangan:</strong> <?= $printKeterangan ?>
    </div>
    <?php endif; ?>

    <div class="ttd-section">
        <div class="ttd-box">
            <div class="ttd-label">Yang Menyerahkan,</div>
            <div class="ttd-line"></div>
            <div class="ttd-name"><?= $printNamaPenyerah ?></div>
        </div>
        <div class="ttd-box">
            <div class="ttd-label">Yang Menerima,</div>
            <div class="ttd-line"></div>
            <div class="ttd-name"><?= $printNamaPenerima ?></div>
        </div>
    </div>

    <div class="footer">
        Dokumen ini dicetak secara otomatis dari Sistem Manajemen Aset &mdash; <?= date('d/m/Y H:i') ?>
    </div>
</body>
</html>`);
    pw.document.close();
    pw.onload = function() {
        pw.focus();
        pw.print();
    };
}
</script>