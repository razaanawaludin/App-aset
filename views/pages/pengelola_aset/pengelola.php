<?php
    PageHeader("Pengelola Aset","Pengaturan tanggung jawab pegawai dalam manajemen aset","");

?>

<div class="container-fluid p-0">
    <div class="row g-4">
        
        <div class="col-lg-4">

            <?php
                $BtnSimpan=button("Btn","Simpan","primary","save","");
                
                $opsiPegawai = "";
                foreach ($semuaPegawai as $p) {
                    $opsiPegawai .= "<option value=\"{$p['IdPegawai']}\">{$p['Nama']} ({$p['Username']})</option>";
                }

                PageContentForm(
                    <<<a
                         <form method="POST" autocomplete="off">
                        
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">
                                    <i data-lucide="user" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Pilih Pegawai
                                </label>
                                <select name="pegawai" class="form-select form-select-lg bg-light border-0 fs-6 text-dark" style="cursor: pointer;" required>
                                    <option value="" selected disabled>-- Cari nama pegawai --</option>
                                    $opsiPegawai
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">
                                    <i data-lucide="shield" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Role Access
                                </label>
                                
                                <select class="form-select form-select-lg bg-light border-0 fs-6 text-dark" name="role" style="cursor: pointer;" required>
                                    <option value="" selected disabled>-- Tentukan Role --</option>
                                    <option value="Admin Instansi">Admin Instansi</option>
                                    <option value="Pengelola Aset">Pengelola Aset</option>
                                    <option value="Staf">Staf</option>
                                    <option value="Teknisi">Teknisi</option>
                                </select>
                                <div class="form-text text-muted x-small ms-1 mt-2">
                                    <i data-lucide="info" style="width: 12px; margin-bottom: 1px;" class="me-1"></i>
                                    Role menentukan menu apa saja yang bisa diakses user.
                                </div>
                            </div>

                            <div class="d-grid mt-5">
                                <button type="submit" name="Btn" value="Simpan" class="btn btn-primary fw-bold py-2 rounded-3 shadow-sm d-flex justify-content-center align-items-center gap-2">
                                    <i data-lucide="save" style="width: 18px;"></i> Simpan
                                </button>
                            </div>

                        </form>
                    a
                );
            ?>

        </div>

        <div class="col-lg-8">
            
            <?php
                $barisTabel = "";
                foreach ($semuaPegawai as $p) {
                    if (!empty($p['Role']) && $p['Role'] !== 'Tidak Ada Role') {
                        $BtnAksi = AksiDropdown([
                            ["", "?pg=$pg&fl=edit&id={$p['IdPegawai']}", "pencil", "Edit"],
                            ["hr"],
                            ["hapus", "#", "trash-2", "Delete", "danger", "konfirmasiHapus('?pg=$pg&fl=$fl&ak=hapus&id={$p['IdPegawai']}')"]
                        ]);
                        
                        $barisTabel .= <<<tr
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative me-3">
                                            <img src="https://ui-avatars.com/api/?name={$p['Nama']}&background=random&color=fff" class="rounded-circle shadow-sm" style="width: 42px; height: 42px; font-size: 0.9rem;">
                                            <span class="position-absolute bottom-0 start-100 translate-middle p-1 bg-success border border-white rounded-circle"></span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;">{$p['Nama']}</h6>
                                            <span class="text-muted small">{$p['Username']}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="small fw-bold text-primary">{$p['Role']}</td>
                                <td class="pe-4 text-end">
                                    $BtnAksi
                                </td>
                            </tr>
                        tr;
                    }
                }

                if (empty($barisTabel)) {
                    $barisTabel = '<tr><td colspan="3" class="text-center py-4 text-muted">Belum ada role yang diatur.</td></tr>';
                }

                PageContentTabel(
                    <<<a
                        <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold">Pegawai</th>
                        <th class="py-3 text-secondary small text-uppercase fw-bold">Role</th>
                        <th class="pe-4 py-3 text-end text-secondary small text-uppercase fw-bold">Aksi</th>
                    a,
                    $barisTabel,
                    "&nbsp",
                    ""
                );
            ?>

        </div>

    </div>
</div>

<?php
    modalHapus()
?>
