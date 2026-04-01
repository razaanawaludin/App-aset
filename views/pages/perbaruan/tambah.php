<?php
    PageHeader(
        "Perbaruan Aset",
        "Tambah catatan perbaikan atau perawatan aset",
       buttonhref("?pg=$pg&fl=list","Kembali","primary","circle-chevron-left","")
    );

    $BtnSimpan = button("Btn","Simpan","primary","save","");

    // Opsi aset dari database
    $opsiAset = '<option value="" selected disabled>-- Pilih Aset --</option>';
    foreach ($semuaAset as $aset) {
        $opsiAset .= "<option value=\"{$aset['IdAset']}\">{$aset['KodeAset']} - {$aset['NamaAset']}</option>";
    }

    PageContentForm(
        <<<a1
            <form method="POST" autocomplete="off"> 

                <div class="d-flex align-items-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-3 me-3" style="width: 42px; height: 42px;">
                        <i data-lucide="wrench" style="width: 20px;"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Informasi Perbaruan</h6>
                        <span class="text-muted small">Lengkapi data perbaikan/perawatan aset</span>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                            <i data-lucide="package" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Aset
                        </label>
                        <div class="position-relative">
                            <select name="id_aset" class="form-select form-select-lg bg-light border-0 fs-6 text-dark" style="cursor: pointer; border-radius: 10px;" required>
                                $opsiAset
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                            <i data-lucide="settings" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Jenis Perbaruan
                        </label>
                        <div class="position-relative">
                            <select name="jenis_perbaruan" class="form-select form-select-lg bg-light border-0 fs-6 text-dark" style="cursor: pointer; border-radius: 10px;" required>
                                <option value="" selected disabled>-- Pilih Jenis --</option>
                                <option value="Perbaikan">🔧 Perbaikan</option>
                                <option value="Perawatan">🛡️ Perawatan</option>
                                <option value="Upgrade">⬆️ Upgrade</option>
                                <option value="Kalibrasi">📐 Kalibrasi</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                            <i data-lucide="calendar" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Tanggal Mulai
                        </label>
                        <div class="position-relative">
                            <input type="date" name="tanggal_mulai" class="form-control form-control-lg bg-light border-0 fs-6" style="border-radius: 10px;" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                            <i data-lucide="calendar-check" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Tanggal Selesai <span class="text-muted fw-normal">(opsional)</span>
                        </label>
                        <div class="position-relative">
                            <input type="date" name="tanggal_selesai" class="form-control form-control-lg bg-light border-0 fs-6" style="border-radius: 10px;">
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                            <i data-lucide="user" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Nama Teknisi
                        </label>
                        <div class="position-relative">
                            <input type="text" name="teknisi" class="form-control form-control-lg bg-light border-0 fs-6 ps-5" placeholder="Nama teknisi yang menangani" style="border-radius: 10px;">
                            <div class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                                <i data-lucide="hard-hat" style="width: 18px;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                            <i data-lucide="banknote" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Biaya
                        </label>
                        <div class="position-relative">
                            <input type="number" name="biaya" class="form-control form-control-lg bg-light border-0 fs-6 ps-5" placeholder="0" style="border-radius: 10px;" min="0">
                            <div class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                                <span class="fw-bold small">Rp</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                            <i data-lucide="activity" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Status
                        </label>
                        <div class="position-relative">
                            <select name="status" class="form-select form-select-lg bg-light border-0 fs-6 text-dark" style="cursor: pointer; border-radius: 10px;" required>
                                <option value="proses" selected>⏳ Sedang Proses</option>
                                <option value="selesai">✅ Selesai</option>
                                <option value="dibatalkan">❌ Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                        <i data-lucide="file-text" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Deskripsi Pekerjaan
                    </label>
                    <textarea name="deskripsi" class="form-control bg-light border-0 fs-6" style="border-radius: 10px; min-height: 100px;" placeholder="Jelaskan detail pekerjaan yang dilakukan..."></textarea>
                </div>

                <div class="mb-5">
                    <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                        <i data-lucide="message-square" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Catatan <span class="text-muted fw-normal">(opsional)</span>
                    </label>
                    <textarea name="catatan" class="form-control bg-light border-0 fs-6" style="border-radius: 10px; min-height: 80px;" placeholder="Catatan tambahan..."></textarea>
                </div>

                <div class="gap-2 pb-3">
                    $BtnSimpan
                </div>

            </form>
        a1
    );

?>
