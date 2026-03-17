<div class="row align-items-center mb-4 g-3">
    <div class="col-md-6">
        <h4 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Penghapusan Aset</h4>
        <p class="text-secondary small mb-0 mt-1">Pembuatan dokumen berita acara dan validasi penghapusan aset secara resmi</p>
    </div>
    
    <div class="col-md-6">
        <div class="d-flex gap-2 justify-content-md-end">
            <div class="d-flex gap-2 justify-content-md-end">
                <a href="?pg=<?= $pg ?>&fl=kpenghapusan" class="btn btn-danger d-flex align-items-center gap-2 shadow-sm px-4 rounded-3 fw-medium" style="background-color: ##e60000; border: none; padding-top: 0.6rem; padding-bottom: 0.6rem;">
                    <i data-lucide="circle-chevron-left" style="width: 18px; height: 18px;"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0">
    <div class="row g-4">
        
        <div class="col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: #fff;">
                <div class="card-body p-4">
                    <form method="POST" autocomplete="off">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Nomor Serah Terima</label>
                            <div class="position-relative">
                                <input type="text" name="kode_aset" class="form-control form-control-lg bg-light border-0 fs-6 ps-5" placeholder="" style="border-radius: 10px;">
                                <div class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                                    <i data-lucide="notebook-tabs" style="width: 18px;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                                <i data-lucide="user" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Pegawai yang menyerahkan
                            </label>
                            <select name="pegawai" class="form-select form-select-lg bg-light border-0 fs-6 text-dark" name="id_pegawai" style="cursor: pointer;">
                                <option value="" selected disabled>-- Cari nama pegawai --</option>
                                <option value="1">Siti Nurhaliza (SN)</option>
                                <option value="2">John Doe (JD)</option>
                                <option value="3">Budi Santoso (BS)</option>
                                <option value="4">Dewi Persik (DP)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                                <i data-lucide="user" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Pegawai yang menerima
                            </label>
                            
                            <select name="pegawai" class="form-select form-select-lg bg-light border-0 fs-6 text-dark" name="id_pegawai" style="cursor: pointer;">
                                <option value="" selected disabled>-- Cari nama pegawai --</option>
                                <option value="1">Siti Nurhaliza (SN)</option>
                                <option value="2">John Doe (JD)</option>
                                <option value="3">Budi Santoso (BS)</option>
                                <option value="4">Dewi Persik (DP)</option>
                            </select>
                        </div>

                        <div>
                            <button type="submit" name="btn" value="Simpan" class="btn btn-success fw-bold py-2 shadow-sm"  style="border:none; border-radius: 12px;">
                                <i data-lucide="file-plus" style="width:18px" class="me-1"></i> Baru
                            </button>
                            
                            <button type="submit" name="btn" value="Batal" class="btn btn-primary fw-bold py-2 shadow-sm" style="border:none; border-radius: 12px;">
                                <i data-lucide="circle-check-big" style="width:18px" class="me-1"></i> Selesai
                            </button>

                            <a href="#" onclick="cetakDariFile('<?= $ArrDt['kode'] ?>','reset')" class="btn btn-info text-white fw-bold py-2 shadow-sm" style="border:none; border-radius: 12px;">
                                <i data-lucide="printer" style="width:18px" class="me-1"></i> Cetak
                            </a>

                            <a href="#" type="submit" name="btn" value="Batal" class="btn btn-danger fw-bold py-2 shadow-sm" style="border:none; border-radius: 12px;"
                                data-bs-toggle="modal" 
                                data-bs-target="#modalBatal" 
                                onclick="konfirmasiBatal('?pg=<?= $pg ?>&fl=<?= $fl ?>&aksi=hapus&id=XXXXX')">
                                <i data-lucide="circle-x" style="width:18px" class="me-1"></i> Batal
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="col-lg-7">
            
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: #fff;">
                <div class="card-body p-4">
                    <form method="POST" autocomplete="off">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">
                                <i data-lucide="user" style="width: 14px; margin-bottom: 2px;" class="me-1"></i> Pilih Aset
                            </label>
                            
                            <div class="d-flex gap-2">
                                <select name="id_pegawai" class="form-select form-select-lg bg-light border-0 fs-6 text-dark" style="cursor: pointer;">
                                    <option value="" selected disabled>-- Cari Aset --</option>
                                    <option value="1">BRG-001 - Laptop Asus</option>
                                    <option value="2">BRG-002 - Lemari Arsip</option>
                                    <option value="3">BRG-003 - Kipas Angin</option>
                                    <option value="4">BRG-004 - TV LED 40 In</option>
                                </select>

                                <button type="submit" name="btn" value="Simpan" class="btn btn-primary fw-bold px-4 shadow-sm" style="background: linear-gradient(to right, #4f46e5, #4338ca); border:none; border-radius: 12px; white-space: nowrap;">
                                    <i data-lucide="circle-plus" style="width:18px" class="me-1"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mt-3" style="background: #fff;">
                <div class="card-body p-0">
                    
                    <div class="table-responsive" style="overflow-x: auto; overflow-y: hidden;">
                        <table class="table table-hover align-middle mb-0" style="white-space: nowrap;">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold">Aset</th>
                                    <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold">Kategori</th>
                                    <th class="pe-4 py-3 text-end text-secondary small text-uppercase fw-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative me-3">
                                                <img src="https://id-media.apjonlinecdn.com/wysiwyg/blog/reasons_to_own_all_in_one_desktop_computer/500x436_px._hp_pavilion_24_inch_all_in_one_desktop.png" 
                                                    alt="Foto Barang" 
                                                    class="rounded-3 shadow-sm border border-light" 
                                                    style="width: 48px; height: 48px; object-fit: cover;">
                                            </div>
                                            <div>
                                                <span class="text-muted small">KODE: BRG-00121</span>
                                                <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;">Laptop Gaming ACER</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Komputer</td>
                                    <td class="pe-4 text-end">
                                        <a href="#" class="btn btn-sm btn-danger"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalHapus" 
                                        onclick="konfirmasiHapus('?pg=<?= $pg ?>&fl=<?= $fl ?>&aksi=hapusbarang&id=XXXXX')">
                                            <i data-lucide="trash-2" style="width: 16px;"></i>
                                        </a>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-white border-top p-3 d-flex justify-content-between align-items-center">
                        
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>


<div class="modal fade" id="modalBatal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                        <i data-lucide="alert-triangle" style="width: 32px; height: 32px;"></i>
                    </div>
                </div>

                <h6 class="fw-bold text-dark mb-1">Yakin dibatalkan?</h6>
                <p class="text-muted small mb-4">
                    Tindakan ini akan menghapus secara permanen
                </p>

                <div class="d-grid gap-2">
                    <a href="#" id="btnLinkBatal" class="btn btn-danger fw-bold py-2 rounded-3 shadow-sm">
                        Ya, Hapus Permanen
                    </a>
                    
                    <button type="button" class="btn btn-light text-secondary fw-bold py-2 rounded-3" data-bs-dismiss="modal">
                        Batal
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                        <i data-lucide="alert-triangle" style="width: 32px; height: 32px;"></i>
                    </div>
                </div>

                <h6 class="fw-bold text-dark mb-1">Hapus Data Ini?</h6>
                <p class="text-muted small mb-4">
                    Tindakan ini tidak dapat dibatalkan. Data dihapus secara permanen dari sistem
                </p>

                <div class="d-grid gap-2">
                    <a href="#" id="btnLinkHapus" class="btn btn-danger fw-bold py-2 rounded-3 shadow-sm">
                        Ya, Hapus
                    </a>
                    
                    <button type="button" class="btn btn-light text-secondary fw-bold py-2 rounded-3" data-bs-dismiss="modal">
                        Batal
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<iframe id="frameCetak" name="frameCetak" style="display:none;"></iframe>
