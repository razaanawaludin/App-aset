<?php
    $isEdit = ($ak === 'edit' && !empty($id));
    $formTitle = $isEdit ? "Edit Lokasi" : "Tambah Lokasi";
    $kodeValue = $isEdit ? $edit_kode_val : $kodeLokasiOtomatis;
    $namaValue = $isEdit ? $edit_nama_val : '';
    $formAction = $isEdit ? "?pg=$pg&fl=$fl&ak=edit&id=$id" : "?pg=$pg&fl=$fl";

    PageHeader(
        "Lokasi",
        "Pengelolaan titik penempatan dan distribusi fisik aset"
    );
?>

<div class="container-fluid p-0">
    <div class="row g-4">
        
        <div class="col-lg-4">
            <?php
                $BtnSimpan = button("Btn","Simpan","primary","save","");
                PageContentForm(
                    <<<a
                        <form method="POST" action="$formAction" autocomplete="off">
                        
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">
                                    <i data-lucide="<?= $isEdit ? 'pencil' : 'plus-circle' ?>" style="width: 16px; margin-bottom: 2px;" class="me-1 text-primary"></i>
                                    $formTitle
                                </h6>
                                <?php if ($isEdit): ?>
                                    <a href="?pg=$pg&fl=$fl" class="btn btn-outline-secondary btn-sm rounded-pill px-3" style="font-size: 0.75rem;">
                                        <i data-lucide="x" style="width: 12px; margin-bottom: 1px;" class="me-1"></i> Batal
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">
                                    <i data-lucide="hash" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Kode Lokasi
                                </label>
                                <input type="text" name="kode" value="$kodeValue" class="form-control form-control-lg bg-light border-0 fs-6" style="border-radius: 10px;" readonly>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">
                                    <i data-lucide="map-pinned" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Nama Lokasi
                                </label>
                                <input type="text" name="lokasi" value="$namaValue" class="form-control form-control-lg bg-light border-0 fs-6" placeholder="Contoh : Ruang Server Lt. 2" style="border-radius: 10px;" required>
                            </div>

                            <div class="d-grid mt-5">
                                $BtnSimpan
                            </div>

                        </form>
                    a
                );
            ?>
        </div>

        <div class="col-lg-8">
             <?php
                $barisTabel = "";
                foreach ($semuaLokasi as $lok) {
                    $namaLok = $lok['NamaLokasiAset'] ?? $lok['NamaLokasi'] ?? $lok['Lokasi'] ?? '';
                    $kodeLok = $lok['KodeLokasiAset'] ?? $lok['KodeLokasi'] ?? $lok['Kode'] ?? '';
                    $idLok = $lok['IdLokasiAset'] ?? $lok['IdLokasi'] ?? '';

                    $BtnAksi = AksiDropdown([
                        ["","?pg=$pg&fl=$fl&ak=edit&id=$idLok", "pencil", "Edit"],
                        ["hr"],
                        ["hapus", "#", "trash-2", "Hapus", "danger", "konfirmasiHapus('?pg=$pg&fl=$fl&ak=hapus&id=$idLok')"]
                    ]);

                    $barisTabel .= <<<tr
                        <tr>
                            <td class="ps-4 py-3">
                                <span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2" style="border-radius: 8px; font-size: 0.8rem;">
                                    $kodeLok
                                </span>
                            </td>
                            <td class="ps-4 py-3 fw-bold text-dark small">$namaLok</td>
                            <td class="pe-4 text-end">
                                $BtnAksi
                            </td>
                        </tr>
                    tr;
                }

                if (empty($barisTabel)) {
                    $barisTabel = '<tr><td colspan="3" class="text-center py-4 text-muted">Belum ada data lokasi.</td></tr>';
                }

                PageContentTabel(
                    <<<th
                        <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold">Kode</th>
                        <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold">Lokasi</th>
                        <th class="pe-4 py-3 text-end text-secondary small text-uppercase fw-bold">Aksi</th>
                    th,
                    $barisTabel,
                    "",
                    ""
                );
            ?>

        </div>

    </div>
</div>

<?php modalHapus() ?>