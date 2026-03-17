<?php
    PageHeader(
        "Serah Terima Aset",
        ($ak=="edit")?"Perubahan dokumen":"Pembuatan dokumen berita acara dan validasi perpindahan aset secara resmi",
       buttonhref("?pg=$pg&fl=kserah","Kembali","primary","circle-chevron-left","")
    );
?>

<div class="container-fluid p-0">
    <div class="row g-4">
        
        <div class="col-lg-5">
            <?php
                $BtnBaru = button("Btn","Baru","primary","file-plus","");
                $BtnSelesai = button("Btn","Selesai","success","circle-check-big","");
                $BtnBatal = buttonhref("#","Batal","danger","circle-x","onclick=\"konfirmasiBatal('?pg=$pg&fl=$fl&ak=$ak&aksi=hapus&id=XXXXX')\"");
                $BtnCetak = buttonhref("#",$val="Cetak","info text-white","printer","onclick=\"cetakDariFile('id', 'jenis')\"");

                PageContentForm(
                    <<<a
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
                                $BtnBaru $BtnSelesai $BtnBatal $BtnCetak
                            </div>

                        </form>
                    a
                );
            ?>
        </div>

        <div class="col-lg-7">
            <?php
                $BtnTambah = button("Btn","Tambah","primary","circle-plus","");
                PageContentForm(
                    <<<a
                        <form method="POST" autocomplete="off">
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
                                    $BtnTambah
                                </div>
                        </form>
                    a
                );

                $BtnAksi = AksiDropdown(
                    [
                        ["hapus","#", "trash-2", "Hapus", "danger","konfirmasiHapus('?pg=Kaset&fl=list&ak=hapus&id=XXXXX')"]
                    ]
                );
            ?>
            <div class='mt-2'>&nbsp</div>
            <?php
                PageContentTabel(
                    <<<a
                        <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold">Aset</th>
                        <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold">Kategori</th>
                        <th class="pe-4 py-3 text-end text-secondary small text-uppercase fw-bold">Aksi</th>
                    a,
                    <<<b
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
                    b,
                    $ketnum="",
                    $li="")
            ?>

        </div>

    </div>
</div>


<?php
    modalHapus();
    dialogPrint();
?>