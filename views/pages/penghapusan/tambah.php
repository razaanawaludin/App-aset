<?php
    PageHeader(
        "Penghapusan Aset",
        "Buat dokumen berita acara penghapusan aset baru",
       buttonhref("?pg=$pg&fl=kpenghapusan","Kembali","primary","circle-chevron-left","")
    );

    // Opsi pegawai
    $opsiPegawai = '<option value="" selected disabled>-- Pilih Penanggung Jawab --</option>';
    foreach ($semuaPegawai as $peg) {
        $opsiPegawai .= "<option value=\"{$peg['IdPegawai']}\">{$peg['Nama']}</option>";
    }

    PageContentForm(
        <<<a1
            <form method="POST" autocomplete="off"> 

                <div class="d-flex align-items-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-3 me-3" style="width: 42px; height: 42px;">
                        <i data-lucide="file-x" style="width: 20px;"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Dokumen Penghapusan Baru</h6>
                        <span class="text-muted small">Nomor otomatis: <strong>$noPenghapusanOtomatis</strong></span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                        <i data-lucide="notebook-tabs" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Nomor Dokumen
                    </label>
                    <div class="position-relative">
                        <input type="text" value="$noPenghapusanOtomatis" class="form-control form-control-lg bg-light border-0 fs-6 ps-5" style="border-radius: 10px;" readonly>
                        <div class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                            <i data-lucide="hash" style="width: 18px;"></i>
                        </div>
                    </div>
                    <div class="form-text text-muted small mt-1">
                        <i data-lucide="info" style="width: 12px; margin-bottom: 1px;" class="me-1"></i>
                        Nomor dokumen akan diberikan secara otomatis oleh sistem.
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                        <i data-lucide="alert-triangle" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Alasan Penghapusan
                    </label>
                    <div class="position-relative">
                        <select name="alasan" class="form-select form-select-lg bg-light border-0 fs-6 text-dark" style="cursor: pointer; border-radius: 10px;" required>
                            <option value="" selected disabled>-- Pilih Alasan --</option>
                            <option value="Rusak Berat">🔨 Rusak Berat / Tidak Bisa Dipakai</option>
                            <option value="Hilang">🔍 Kehilangan / Pencurian</option>
                            <option value="Dijual">🏷️ Penjualan Aset</option>
                            <option value="Hibah">🎁 Hibah / Donasi</option>
                            <option value="Kadaluarsa">⏱️ Masa Pakai Habis (Depresiasi Penuh)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                        <i data-lucide="user" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Penanggung Jawab
                    </label>
                    <select name="penanggung_jawab" class="form-select form-select-lg bg-light border-0 fs-6 text-dark" style="cursor: pointer; border-radius: 10px;">
                        $opsiPegawai
                    </select>
                </div>

                <div class="mb-5">
                    <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                        <i data-lucide="message-square" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Keterangan <span class="text-muted fw-normal">(opsional)</span>
                    </label>
                    <textarea name="keterangan" class="form-control bg-light border-0 fs-6" style="border-radius: 10px; min-height: 80px;" placeholder="Keterangan tambahan mengenai penghapusan aset..."></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" name="Btn" value="Buat" class="btn btn-danger fw-bold shadow-sm" style="border:none; white-space: nowrap;">
                        <i data-lucide="file-plus" style="width:18px" class="me-1"></i> Buat Dokumen
                    </button>
                </div>

            </form>
        a1
    );
?>
