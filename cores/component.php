<?php
    function button($var="",$val="",$warna="",$icon="",$attbr="")
    {
        return <<<button
            <button type="submit" name="$var" value="$val" class="btn btn-$warna fw-bold shadow-sm" style="border:none; white-space: nowrap;" $attbr>
                <i data-lucide="$icon" style="width:18px" class="me-1"></i> $val
            </button>
        button;
    }

    function buttonhref($link="",$val="",$warna="",$icon="",$attbr="")
    {
        return <<<buttonhref
            <a href="$link" class="btn btn-$warna fw-bold py-2 shadow-sm" style="border:none;" $attbr>
                <i data-lucide="$icon" style="width:18px" class="me-1"></i> $val
            </a>
        buttonhref;
    }


    function AksiDropdown($li=[])
    {
        //0=jenis, 1=link, 2=icon, 3=Judul, 4=warna, 5=onclick
        $Arli = "";
        $hasil = "";
        foreach($li as $Arli)
        {
            switch($Arli[0])
            {
                case "hapus":
                    $hasil .= <<<a
                        <li>
                            <a href="#" class="dropdown-item small text-{$Arli[4]} bg-{$Arli[4]} bg-opacity-10"
                            data-bs-toggle="modal" 
                            data-bs-target="#modalHapus" 
                            onclick="{$Arli[5]}">
                                <i data-lucide="{$Arli[2]}" style="width: 16px;"></i> {$Arli[3]}
                            </a>
                        </li>
                    a;
                break;
                case "qr":
                    $hasil .= <<<a
                        <li>
                            <a href="#" class="dropdown-item small text-{$Arli[4]} bg-{$Arli[4]} bg-opacity-10"
                            data-bs-toggle="modal" 
                            data-bs-target="#modalCetakQR" 
                            onclick="{$Arli[5]}">
                                <i data-lucide="{$Arli[2]}" style="width: 16px;"></i> {$Arli[3]}
                            </a>
                        </li>
                    a;
                break;
                case "print":
                    $hasil .=<<<a
                        <li>
                            <a href="#" class="dropdown-item small" onclick="{$Arli[5]}">
                                <i data-lucide="{$Arli[2]}" style="width: 16px;"></i> {$Arli[3]}
                            </a>
                        </li>
                    a;
                break;
                case "hr":
                    $hasil.=<<<a
                        <li><hr class="dropdown-divider my-1"></li>
                    a;
                break;
                default :
                    $hasil .= <<<a
                        <li><a href="{$Arli[1]}" class="dropdown-item small"><i data-lucide="{$Arli[2]}" style="width: 16px;"></i> {$Arli[3]}</a></li>
                    a;
                break;
            }
        }
        
        return <<<aksi
            <div class="dropdown">
                <button class="btn btn-sm btn-light border shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}'>
                    <i data-lucide="more-horizontal" style="width:16px"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="z-index: 9999;">
                    $hasil
                </ul>
            </div>
        aksi;
    }

    function PageHeader($Judul="",$JudulDeskripsi="",$Tambahan=""){
        echo <<<PageHeader
            <div class="row align-items-center mb-4 g-3">
                <div class="col-md-6">
                    <h4 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">$Judul</h4>
                    <p class="text-secondary small mb-0 mt-1">$JudulDeskripsi</p>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2 justify-content-md-end">
                        $Tambahan
                    </div>
                </div>
            </div>
        PageHeader;
    }

    function PageContentTabel($th="",$tr="",$ketnum="",$li="")
    {
        echo <<<PageContent
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: #fff;">
                <div class="card-body p-0">
                    <div class="table-responsive" style="overflow-x: auto; overflow-y: hidden;">
                        <table class="table table-hover align-middle mb-0" style="border-collapse: collapse; white-space: nowrap;">
                
                            <thead class="bg-white border-bottom sticky-top" style="z-index: 10;">
                                <tr>
                                    $th
                                </tr>
                            </thead>

                            <tbody class="border-top-0">
                                
                                    $tr
                                    
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-top py-3 px-4">
                     <div class="d-flex justify-content-between align-items-center">
                        $ketnum
                        <nav>
                            <ul class="pagination pagination-sm mb-0 gap-1">
                                $li
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        PageContent;
    }

    function PageContentForm($Konten)
    {
        echo <<<PageContent
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: #fff;">
                <div class="card-body p-4">
                    $Konten
                </div>
            </div>
        PageContent;
    }


    function modalHapus()
    {
        echo <<<m
            <div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                        
                        <div class="modal-body text-center p-4">
                            <div class="mb-3">
                                <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                                    <i data-lucide="alert-triangle" style="width: 32px; height: 32px;"></i>
                                </div>
                            </div>

                            <h6 class="fw-bold text-dark mb-1">Yakin Data dihapus?</h6>
                            <p class="text-muted small mb-4">
                                Tindakan ini tidak dapat dibatalkan. Data akan hilang permanen dari sistem
                            </p>

                            <div class="d-grid gap-2">
                                <a href="#" id="btnLinkHapus" class="btn btn-danger fw-bold py-2 rounded-3 shadow-sm">
                                    Ya
                                </a>
                                
                                <button type="button" class="btn btn-light text-secondary fw-bold py-2 rounded-3" data-bs-dismiss="modal">
                                    Batal
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <script>
            function konfirmasiHapus(link) {
                document.getElementById('btnLinkHapus').href = link;
            }
            </script>
        m;
    }

    function modalQRCode()
    {
        echo <<<qr
            <div class="modal fade" id="modalCetakQR" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                        <div class="modal-header border-0 pb-0 px-4 pt-4">
                            <h6 class="modal-title fw-bold">
                                <i data-lucide="qr-code" style="width: 20px; margin-bottom: 2px;" class="me-1 text-primary"></i> QR Code Aset
                            </h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <!-- Tab Navigation -->
                        <div class="px-4 pt-3">
                            <ul class="nav nav-pills nav-fill gap-2 p-1 rounded-3" style="background: #f1f5f9;" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active rounded-3 fw-bold small py-2" id="tab-generate" data-bs-toggle="pill" data-bs-target="#pane-generate" type="button" role="tab" style="font-size: 0.8rem;">
                                        <i data-lucide="qr-code" style="width: 14px; margin-bottom: 1px;" class="me-1"></i> QR Code
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-3 fw-bold small py-2" id="tab-scan" data-bs-toggle="pill" data-bs-target="#pane-scan" type="button" role="tab" style="font-size: 0.8rem;">
                                        <i data-lucide="scan" style="width: 14px; margin-bottom: 1px;" class="me-1"></i> Scan
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <!-- Tab: Generate QR -->
                            <div class="tab-pane fade show active" id="pane-generate" role="tabpanel">
                                <div class="modal-body text-center px-4 py-3" id="areaCetak">
                                    <div class="p-4 border border-2 rounded-3 mb-3 d-inline-block bg-white" style="border-style: dashed !important; border-color: #dee2e6;">
                                        <div class="fw-bold text-uppercase small mb-3" style="letter-spacing: 1px; color: #6366f1;">INVENTARIS ASET</div>
                                        
                                        <div class="d-flex justify-content-center mb-2">
                                            <div id="qrcode"></div>
                                        </div>
                                        
                                        <div class="mt-2">
                                            <span id="labelKode" class="d-block text-muted small" style="font-size: 0.75rem;"></span>
                                            <span id="labelNamaAset" class="d-block fw-bold text-dark" style="font-size: 0.85rem;"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-4 pb-4">
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-primary flex-fill rounded-3 fw-bold shadow-sm" onclick="printLabel()">
                                            <i data-lucide="printer" class="me-1" style="width: 16px;"></i> Print
                                        </button>
                                        <button type="button" class="btn btn-success flex-fill rounded-3 fw-bold shadow-sm" onclick="downloadQR()">
                                            <i data-lucide="download" class="me-1" style="width: 16px;"></i> Download
                                        </button>
                                        <button type="button" class="btn btn-info flex-fill rounded-3 fw-bold shadow-sm text-white" onclick="shareQR()">
                                            <i data-lucide="share-2" class="me-1" style="width: 16px;"></i> Bagikan
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab: Scan QR -->
                            <div class="tab-pane fade" id="pane-scan" role="tabpanel">
                                <div class="modal-body px-4 py-3">
                                    <div id="qr-reader-container" class="rounded-3 overflow-hidden mb-3" style="background: #000;">
                                        <div id="qr-reader" style="width: 100%;"></div>
                                    </div>

                                    <!-- Scan Result -->
                                    <div id="scanResult" style="display: none;">
                                        <div class="p-3 rounded-3 border" style="background: #f0fdf4; border-color: #bbf7d0 !important;">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="d-inline-flex align-items-center justify-content-center bg-success rounded-circle me-2" style="width: 28px; height: 28px;">
                                                    <i data-lucide="check" class="text-white" style="width: 14px;"></i>
                                                </div>
                                                <span class="fw-bold text-success small">QR Code Terdeteksi!</span>
                                            </div>
                                            <div class="bg-white rounded-2 p-2 mt-2">
                                                <code id="scanResultText" class="text-dark small fw-bold" style="word-break: break-all;"></code>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="scanPlaceholder" class="text-center py-3">
                                        <p class="text-muted small mb-2">Arahkan kamera ke QR Code aset</p>
                                        <button type="button" class="btn btn-outline-primary rounded-pill px-4 fw-bold" id="btnStartScan" onclick="startQRScanner()">
                                            <i data-lucide="camera" style="width: 16px; margin-bottom: 1px;" class="me-1"></i> Mulai Scan
                                        </button>
                                        <button type="button" class="btn btn-outline-danger rounded-pill px-4 fw-bold" id="btnStopScan" onclick="stopQRScanner()" style="display:none;">
                                            <i data-lucide="camera-off" style="width: 16px; margin-bottom: 1px;" class="me-1"></i> Stop Scan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        qr;
    }

    function dialogPrint()
    {
        echo <<<d
            <iframe id="frameCetak" name="frameCetak" style="display:none;"></iframe>
        d;
    }
?>