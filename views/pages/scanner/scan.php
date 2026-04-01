<?php
    PageHeader(
        "Scan QR Aset",
        "Arahkan kamera ke QR Code yang ada pada aset fisik untuk melihat detailnya.",
       ""
    );
?>

<div class="row g-4 justify-content-center">
    <div class="col-md-6 col-lg-5">

        <?php if (!empty($errorMsg)): ?>
            <div class="alert alert-danger d-flex align-items-center mb-4 border-0 shadow-sm" role="alert" style="border-radius: 12px; font-size: 0.9rem;">
                <i data-lucide="alert-circle" style="width: 20px;" class="me-2 flex-shrink-0"></i>
                <div>
                    <?= htmlspecialchars($errorMsg) ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
            <div class="card-body p-4 text-center">
                <!-- Wrapper Kamera -->
                <div class="position-relative mx-auto bg-light rounded-4 overflow-hidden mb-4" style="width: 100%; max-width: 320px; aspect-ratio: 1/1; border: 2px dashed #cbd5e1; display: flex; align-items: center; justify-content: center;">
                    <div id="qr-reader-full" style="width: 100%; height: 100%;"></div>
                    <div id="scan-placeholder" class="text-secondary opacity-50 position-absolute d-flex flex-column align-items-center pointer-events-none">
                        <i data-lucide="camera" style="width: 48px; height: 48px; margin-bottom: 10px;"></i>
                        <span class="small fw-bold">Kamera Mati</span>
                    </div>
                </div>

                <h6 class="fw-bold text-dark mb-1">Arahkan Kamera ke QR Code</h6>
                <p class="text-muted small mb-4">Pastikan pencahayaan cukup dan QR code terlihat jelas di dalam kotak</p>

                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" id="btnStartScanFull" onclick="startScannerFull()">
                        <i data-lucide="camera" style="width: 16px; margin-bottom: 1px;" class="me-1"></i> Mulai Scan
                    </button>
                    <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm" id="btnStopScanFull" onclick="stopScannerFull()" style="display:none;">
                        <i data-lucide="square" style="width: 16px; margin-bottom: 1px;" class="me-1"></i> Berhenti
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    let html5QrScannerFull = null;

    function startScannerFull() {
        const btnStart = document.getElementById('btnStartScanFull');
        const btnStop = document.getElementById('btnStopScanFull');
        const placeholder = document.getElementById('scan-placeholder');

        btnStart.style.display = 'none';
        btnStop.style.display = 'inline-block';
        if (placeholder) placeholder.style.display = 'none';

        html5QrScannerFull = new Html5Qrcode('qr-reader-full');
        html5QrScannerFull.start(
            { facingMode: 'environment' },
            { fps: 10, qrbox: { width: 220, height: 220 } },
            (decodedText) => {
                // Berhasil scan!
                stopScannerFull();
                // Redirect untuk diproses oleh controller
                window.location.href = "?pg=scanner&fl=scan&kode=" + encodeURIComponent(decodedText);
            },
            (errorMessage) => {
                // Silent error (normal saat mencari qr)
            }
        ).catch(err => {
            console.error('QR Scanner error:', err);
            Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Tidak dapat mengakses kamera.', showConfirmButton: true });
            btnStart.style.display = 'inline-block';
            btnStop.style.display = 'none';
            if (placeholder) placeholder.style.display = 'flex';
        });
    }

    function stopScannerFull() {
        const btnStart = document.getElementById('btnStartScanFull');
        const btnStop = document.getElementById('btnStopScanFull');
        const placeholder = document.getElementById('scan-placeholder');

        if (html5QrScannerFull) {
            html5QrScannerFull.stop().then(() => {
                html5QrScannerFull.clear();
                html5QrScannerFull = null;
            }).catch(err => console.error('Stop error:', err));
        }

        if (btnStart) btnStart.style.display = 'inline-block';
        if (btnStop) btnStop.style.display = 'none';
        if (placeholder) placeholder.style.display = 'flex';
    }

    // Auto start scanner when page loads
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(startScannerFull, 500);
    });
</script>
