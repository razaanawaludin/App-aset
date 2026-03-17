<?php
    PageHeader(
        "Edit Role Pegawai", 
        "Ubah role akses untuk pegawai yang dipilih", 
        buttonhref("?pg=$pg&fl=pengelola","Kembali","primary","circle-chevron-left","")
    );
?>

<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <?php
                $BtnSimpan = button("Btn","Simpan Perubahan","primary","save","");
                
                $rAdmin = ($role_edit == 'Admin Instansi') ? 'selected' : '';
                $rPengelola = ($role_edit == 'Pengelola Aset') ? 'selected' : '';
                $rStaf = ($role_edit == 'Staf') ? 'selected' : '';
                $rTeknisi = ($role_edit == 'Teknisi') ? 'selected' : '';

                PageContentForm(
                    <<<a
                        <form method="POST" autocomplete="off">
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">
                                    <i data-lucide="user" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Pegawai Terpilih
                                </label>
                                <input type="text" class="form-control form-control-lg bg-light border-0 fs-6 text-dark" value="{$nama_pegawai} ({$username_pegawai})" disabled readonly>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary text-uppercase" style="letter-spacing: 0.5px;">
                                    <i data-lucide="shield" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Ubah Role Access
                                </label>
                                
                                <select class="form-select form-select-lg bg-light border-0 fs-6 text-dark" name="role" style="cursor: pointer;" required>
                                    <option value="" disabled>-- Tentukan Role --</option>
                                    <option value="Admin Instansi" {$rAdmin}>Admin Instansi</option>
                                    <option value="Pengelola Aset" {$rPengelola}>Pengelola Aset</option>
                                    <option value="Staf" {$rStaf}>Staf</option>
                                    <option value="Teknisi" {$rTeknisi}>Teknisi</option>
                                </select>
                                <div class="form-text text-muted x-small ms-1 mt-2">
                                    <i data-lucide="info" style="width: 12px; margin-bottom: 1px;" class="me-1"></i>
                                    Role menentukan menu apa saja yang bisa diakses user.
                                </div>
                            </div>

                            <div class="d-grid mt-5">
                                $BtnSimpan
                            </div>
                        </form>
                    a
                );
            ?>

        </div>
    </div>
</div>