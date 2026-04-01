<?php
    PageHeader(
        "Aset",
        ($ak=="tambah")?"Tambahkan data baru aset":"Ubah data aset",
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
        $namaLok = $lok['NamaLokasiAset'] ?? $lok['Lokasi'] ?? '';
        $selected = ($lokasi_val === $namaLok) ? 'selected' : '';
        $opsiLokasi .= "<option value=\"$namaLok\" $selected>$namaLok</option>";
    }

    // Preview foto (untuk edit)
    $previewFoto = '';
    if ($ak === 'edit' && !empty($foto_val) && file_exists('assets/uploads/' . $foto_val)) {
        $fotoSrc = 'assets/uploads/' . htmlspecialchars($foto_val);
        $previewFoto = <<<prev
            <div class="mb-3">
                <img src="$fotoSrc" class="rounded-3 shadow-sm" style="max-height: 120px; object-fit: cover;">
                <p class="text-muted small mt-1 mb-0">Foto saat ini</p>
            </div>
prev;
    }

    $kodeAsetValue = ($ak === 'edit') ? $kode_val : $kodeAsetOtomatis;

    PageContentForm(
        <<<a1
            <form method="POST" enctype="multipart/form-data"> 
    
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Kode Aset</label>
                        <div class="position-relative">
                            <input type="text" name="kode_aset" value="{$kodeAsetValue}" class="form-control form-control-lg bg-light border-0 fs-6 ps-5" style="border-radius: 10px;" readonly>
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
                    <div id="uploadArea" class="position-relative p-4 bg-light text-center border border-2 border-dashed d-flex flex-column align-items-center justify-content-center" style="border-radius: 12px; border-color: #e5e7eb !important; min-height: 150px; transition: all 0.3s ease;">
                        
                        <!-- Default state: belum ada foto -->
                        <div id="uploadDefault">
                            <div class="mb-3">
                                <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm p-3">
                                    <i data-lucide="image-plus" class="text-primary" style="width: 24px;"></i>
                                </div>
                            </div>
                            <div class="z-1">
                                <span class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-medium mb-2 pointer-events-none">
                                    Pilih Gambar
                                </span>
                                <p class="text-muted small mb-0">Format: JPG, PNG (Max. 2MB)</p>
                            </div>
                        </div>

                        <!-- Preview state: foto sudah dipilih -->
                        <div id="uploadPreview" style="display: none;">
                            <div class="d-flex align-items-center gap-3 text-start w-100">
                                <div class="position-relative flex-shrink-0">
                                    <img id="previewImg" src="" alt="Preview" class="rounded-3 shadow-sm" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #198754;">
                                    <div class="position-absolute" style="top: -6px; right: -6px;">
                                        <span class="d-inline-flex align-items-center justify-content-center bg-success rounded-circle" style="width: 22px; height: 22px;">
                                            <i data-lucide="check" class="text-white" style="width: 13px;"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1" style="font-size: 0.7rem; border-radius: 6px;">
                                            <i data-lucide="image" style="width: 11px; margin-bottom: 1px;" class="me-1"></i> Foto Terpilih
                                        </span>
                                    </div>
                                    <p id="fileName" class="fw-bold text-dark small mb-0 text-truncate" style="max-width: 250px;"></p>
                                    <p id="fileSize" class="text-muted mb-0" style="font-size: 0.7rem;"></p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="btn btn-outline-secondary btn-sm rounded-pill px-3 pointer-events-none" style="font-size: 0.75rem;">
                                        <i data-lucide="refresh-cw" style="width: 12px; margin-bottom: 1px;" class="me-1"></i> Ganti
                                    </span>
                                </div>
                            </div>
                        </div>

                        <input type="file" id="inputFotoAset" name="foto_aset" class="form-control position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;" accept="image/*">
                    </div>
                </div>

                <div class="gap-2 pb-3">
                    $BtnSimpan
                </div>

            </form>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const inputFoto = document.getElementById('inputFotoAset');
                const uploadArea = document.getElementById('uploadArea');
                const uploadDefault = document.getElementById('uploadDefault');
                const uploadPreview = document.getElementById('uploadPreview');
                const previewImg = document.getElementById('previewImg');
                const fileName = document.getElementById('fileName');
                const fileSize = document.getElementById('fileSize');

                if (inputFoto) {
                    inputFoto.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file && file.type.startsWith('image/')) {
                            // Tampilkan preview
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                previewImg.src = event.target.result;
                                fileName.textContent = file.name;

                                // Format ukuran file
                                const size = file.size;
                                if (size < 1024) {
                                    fileSize.textContent = size + ' B';
                                } else if (size < 1024 * 1024) {
                                    fileSize.textContent = (size / 1024).toFixed(1) + ' KB';
                                } else {
                                    fileSize.textContent = (size / (1024 * 1024)).toFixed(1) + ' MB';
                                }

                                uploadDefault.style.display = 'none';
                                uploadPreview.style.display = 'block';
                                uploadArea.style.borderColor = '#198754';
                                uploadArea.style.backgroundColor = '#f0fdf4';

                                // Re-init lucide icons for new elements
                                if (typeof lucide !== 'undefined') {
                                    lucide.createIcons();
                                }
                            };
                            reader.readAsDataURL(file);
                        } else {
                            // Reset jika bukan gambar
                            uploadDefault.style.display = 'block';
                            uploadPreview.style.display = 'none';
                            uploadArea.style.borderColor = '#e5e7eb';
                            uploadArea.style.backgroundColor = '';
                        }
                    });
                }
            });
            </script>
        a1
    );

?>
      
