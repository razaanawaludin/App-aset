<?php
    PageHeader(
        "Kategori Aset",
        "Pengelolaan klasifikasi dan pengelompokan jenis aset"
    );
?>

<div class="container-fluid p-0">
    <div class="row g-4">
        
        <div class="col-lg-4">
            <?php
                $BtnSimpan = button("Btn","Simpan","primary","save","");
                PageContentForm(
                    <<<a
                        <form method="POST" autocomplete="off">
                        
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">
                                    <i data-lucide="hash" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Kode Kategori
                                </label>
                                <input type="text" name="kode" class="form-control form-control-lg bg-light border-0 fs-6" placeholder="Contoh : ELK, FRN, KND" style="border-radius: 10px;" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">
                                    <i data-lucide="tag" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Nama Kategori
                                </label>
                                <input type="text" name="nama" class="form-control form-control-lg bg-light border-0 fs-6" placeholder="Contoh : Elektronik, Furniture" style="border-radius: 10px;" required>
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
                foreach ($semuaKategori as $k) {
                    $BtnAksi = AksiDropdown([
                        ["hapus", "#", "trash-2", "Hapus", "danger", "konfirmasiHapus('?pg=$pg&fl=$fl&ak=hapus&id={$k['IdKategori']}')"]
                    ]);

                    $barisTabel .= <<<tr
                        <tr>
                            <td class="ps-4 py-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-3 py-2" style="border-radius: 8px; font-size: 0.8rem;">
                                    {$k['KodeKategori']}
                                </span>
                            </td>
                            <td class="py-3 fw-bold text-dark small">{$k['NamaKategori']}</td>
                            <td class="pe-4 text-end">
                                $BtnAksi
                            </td>
                        </tr>
                    tr;
                }

                if (empty($barisTabel)) {
                    $barisTabel = '<tr><td colspan="3" class="text-center py-4 text-muted">Belum ada kategori aset.</td></tr>';
                }

                PageContentTabel(
                    <<<th
                        <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold">Kode</th>
                        <th class="py-3 text-secondary small text-uppercase fw-bold">Nama Kategori</th>
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
