<?php
    PageHeader(
        "Aset",
        "Ubah data aset",
       buttonhref("?pg=$pg&fl=kelola","Kembali","primary","circle-chevron-left",$attbr="")
    );

    $BtnSimpan = button("btn","Simpan","primary","save","");

    // Opsi kategori dari database
    $opsiKategori = '<option value="" selected disabled>Pilih Kategori...</option>';
    foreach ($semuaKategori as $kat) {
        $selected = ($kategori_val === $kat['NamaKategori']) ? 'selected' : '';
        $opsiKategori .= "<option value=\"{$kat['NamaKategori']}\" $selected>{$kat['NamaKategori']}</option>";
    }

    // Opsi lokasi dari database
    $opsiLokasi = '<option value="" selected disabled>Pilih Lokasi...</option>';
    foreach ($semuaLokasi as $lok) {
        $namaLok = $lok['NamaLokasi'] ?? $lok['Lokasi'] ?? '';
        $selected = ($lokasi_val === $namaLok) ? 'selected' : '';
        $opsiLokasi .= "<option value=\"$namaLok\" $selected>$namaLok</option>";
    }

    // Preview foto
    $previewFoto = '';
    if (!empty($foto_val) && file_exists('assets/uploads/' . $foto_val)) {
        $fotoSrc = 'assets/uploads/' . htmlspecialchars($foto_val);
        $previewFoto = <<<prev
            <div class="mb-3">
                <img src="$fotoSrc" class="rounded-3 shadow-sm" style="max-height: 120px; object-fit: cover;">
                <p class="text-muted small mt-1 mb-0">Foto saat ini</p>
            </div>
prev;
    }

    PageContentForm(
        <<<a1
            <form method="POST" enctype="multipart/form-data"> 
    
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Kode Aset</label>
                        <div class="position-relative">
                            <input type="text" name="kode_aset" value="{$kode_val}" class="form-control form-control-lg bg-light border-0 fs-6 ps-5" placeholder="AST-001" style="border-radius: 10px;" required>
                            <div class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                                <i data-lucide="qr-code" style="width: 18px;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Nama Aset</label>
                        <div class="position-relative">
                            <input type="text" name="nama_aset" value="{$nama_val}" class="form-control form-control-lg bg-light border-0 fs-6 ps-5" placeholder="Contoh: Laptop Dell Latitude 7490" style="border-radius: 10px;" required>
                            <div class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                                <i data-lucide="tag" style="width: 18px;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Kategori</label>
                        <div class="position-relative">
                            <select name="kategori" class="form-select form-select-lg bg-light border-0 fs-6 ps-5 text-dark" style="border-radius: 10px; cursor: pointer;" required>
                                $opsiKategori
                            </select>
                            <div class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                                <i data-lucide="layers" style="width: 18px;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Lokasi Penempatan</label>
                        <div class="position-relative">
                            <select name="lokasi" class="form-select form-select-lg bg-light border-0 fs-6 ps-5 text-dark" style="border-radius: 10px; cursor: pointer;" required>
                                $opsiLokasi
                            </select>
                            <div class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                                <i data-lucide="map-pin" style="width: 18px;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Kondisi Aset</label>
                        <div class="position-relative">
                            <select name="kondisi" class="form-select form-select-lg bg-light border-0 fs-6 ps-5 text-dark" style="border-radius: 10px; cursor: pointer;" required>
                                <option value="Baik" <?= ($kondisi_val === 'Baik') ? 'selected' : '' ?>>✅ Baik</option>
                                <option value="Kurang Baik" <?= ($kondisi_val === 'Kurang Baik') ? 'selected' : '' ?>>⚠️ Kurang Baik</option>
                                <option value="Rusak Ringan" <?= ($kondisi_val === 'Rusak Ringan') ? 'selected' : '' ?>>🔧 Rusak Ringan</option>
                                <option value="Rusak Berat" <?= ($kondisi_val === 'Rusak Berat') ? 'selected' : '' ?>>❌ Rusak Berat</option>
                            </select>
                            <div class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                                <i data-lucide="heart-pulse" style="width: 18px;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Foto Aset</label>
                    $previewFoto
                    <div class="position-relative p-4 bg-light text-center border border-2 border-dashed d-flex flex-column align-items-center justify-content-center" style="border-radius: 12px; border-color: #e5e7eb !important; min-height: 150px;">
                        
                        <div class="mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm p-3">
                                <i data-lucide="image-plus" class="text-primary" style="width: 24px;"></i>
                            </div>
                        </div>
                        
                        <input type="file" name="foto_aset" class="form-control position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;" accept="image/*">
                        
                        <div class="z-1">
                            <span class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-medium mb-2 pointer-events-none">
                                Pilih Gambar
                            </span>
                            <p class="text-muted small mb-0">Format: JPG, PNG (Max. 2MB)</p>
                        </div>
                    </div>
                </div>

                <div class="gap-2 pb-3">
                    $BtnSimpan
                </div>

            </form>
        a1
    );

?>
