<?php 
        //untuk logout
        if($pg=='logout'){
            session_destroy();
            header('Location:index.php');
        } 
    
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Core | Premium Enterprise Dashboard</title>                           
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <?php include('dashboard/sidebar.php') ?>

    <div class="main-content">
        
        <?php include('dashboard/header.php') ?>

        <div class="p-4 p-lg-5">
           
        <?php
        if ($pg == '' && $fl == '') {
             include('pages/beranda.php');
        }
        elseif ($pg != '' && $fl != '') {
            include('pages/'.$pg.'/'.$fl.'.php');
        }
        ?>
        

        </div> 
    </div> 
    <script src="assets/js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- QR Code Functions -->
    <script>
    function generateQRCode(kode, nama) {
        const qrContainer = document.getElementById('qrcode');
        const labelKode = document.getElementById('labelKode');
        const labelNama = document.getElementById('labelNamaAset');
        
        // Bersihkan QR sebelumnya
        if (qrContainer) {
            qrContainer.innerHTML = '';
        }
        
        // Set label
        if (labelKode) labelKode.textContent = kode;
        if (labelNama) labelNama.textContent = nama;
        
        // Generate QR Code baru
        if (qrContainer && typeof QRCode !== 'undefined') {
            new QRCode(qrContainer, {
                text: kode,
                width: 150,
                height: 150,
                colorDark: '#000000',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.H
            });
        }
    }

    function printLabel() {
        const areaCetak = document.getElementById('areaCetak');
        if (!areaCetak) return;

        const printWindow = window.open('', '_blank', 'width=400,height=500');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Cetak QR Code</title>
                <style>
                    * { margin: 0; padding: 0; box-sizing: border-box; }
                    body { 
                        display: flex; 
                        justify-content: center; 
                        align-items: center; 
                        min-height: 100vh; 
                        font-family: 'Plus Jakarta Sans', Arial, sans-serif;
                    }
                    .print-container {
                        text-align: center;
                        padding: 20px;
                        border: 2px dashed #ccc;
                        border-radius: 12px;
                    }
                    .print-title {
                        font-weight: 700;
                        text-transform: uppercase;
                        font-size: 11px;
                        letter-spacing: 1px;
                        margin-bottom: 15px;
                    }
                    .print-kode {
                        font-size: 11px;
                        color: #666;
                        margin-top: 10px;
                    }
                    .print-nama {
                        font-weight: 700;
                        font-size: 13px;
                        color: #000;
                    }
                    img { display: block; margin: 0 auto; }
                    @media print {
                        body { margin: 0; }
                        .print-container { border: 2px dashed #ccc; }
                    }
                </style>
            </head>
            <body>
                <div class="print-container">
                    <div class="print-title">INVENTARIS ASET</div>
                    ${document.getElementById('qrcode').innerHTML}
                    <div class="print-kode">${document.getElementById('labelKode').textContent}</div>
                    <div class="print-nama">${document.getElementById('labelNamaAset').textContent}</div>
                </div>
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.onload = function() {
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        };
    }

    // Download QR Code sebagai gambar PNG
    function downloadQR() {
        const qrContainer = document.getElementById('qrcode');
        const labelKode = document.getElementById('labelKode');
        const labelNama = document.getElementById('labelNamaAset');
        if (!qrContainer) return;

        const qrImg = qrContainer.querySelector('img') || qrContainer.querySelector('canvas');
        if (!qrImg) { alert('QR Code belum dibuat'); return; }

        // Create canvas for download
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const padding = 40;
        const qrSize = 200;
        const textHeight = 60;
        canvas.width = qrSize + padding * 2;
        canvas.height = qrSize + padding * 2 + textHeight;

        // Background
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        // Title
        ctx.fillStyle = '#6366f1';
        ctx.font = 'bold 11px Arial';
        ctx.textAlign = 'center';
        ctx.fillText('INVENTARIS ASET', canvas.width / 2, padding - 10);

        // Draw QR
        const img = new Image();
        img.onload = function() {
            ctx.drawImage(img, padding, padding, qrSize, qrSize);

            // Kode text
            ctx.fillStyle = '#666666';
            ctx.font = '11px Arial';
            ctx.fillText(labelKode.textContent, canvas.width / 2, padding + qrSize + 20);

            // Nama text
            ctx.fillStyle = '#000000';
            ctx.font = 'bold 13px Arial';
            ctx.fillText(labelNama.textContent, canvas.width / 2, padding + qrSize + 40);

            // Download
            const link = document.createElement('a');
            link.download = 'QR_' + (labelKode.textContent || 'aset') + '.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        };
        img.src = qrImg.src || qrImg.toDataURL();
    }

    // Bagikan QR Code via Web Share API
    async function shareQR() {
        const qrContainer = document.getElementById('qrcode');
        const labelKode = document.getElementById('labelKode');
        const labelNama = document.getElementById('labelNamaAset');
        if (!qrContainer) return;

        const qrImg = qrContainer.querySelector('img') || qrContainer.querySelector('canvas');
        if (!qrImg) { alert('QR Code belum dibuat'); return; }

        // Create canvas
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 280;
        canvas.height = 320;
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        ctx.fillStyle = '#6366f1';
        ctx.font = 'bold 11px Arial';
        ctx.textAlign = 'center';
        ctx.fillText('INVENTARIS ASET', canvas.width / 2, 30);

        const img = new Image();
        img.onload = async function() {
            ctx.drawImage(img, 40, 45, 200, 200);
            ctx.fillStyle = '#666';
            ctx.font = '11px Arial';
            ctx.fillText(labelKode.textContent, canvas.width / 2, 270);
            ctx.fillStyle = '#000';
            ctx.font = 'bold 13px Arial';
            ctx.fillText(labelNama.textContent, canvas.width / 2, 290);

            try {
                const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/png'));
                const file = new File([blob], 'QR_' + (labelKode.textContent || 'aset') + '.png', { type: 'image/png' });

                if (navigator.share && navigator.canShare && navigator.canShare({ files: [file] })) {
                    await navigator.share({
                        title: 'QR Code Aset - ' + labelNama.textContent,
                        text: 'QR Code untuk aset: ' + labelNama.textContent + ' (' + labelKode.textContent + ')',
                        files: [file]
                    });
                } else {
                    // Fallback: copy image to clipboard or download
                    try {
                        await navigator.clipboard.write([
                            new ClipboardItem({ 'image/png': blob })
                        ]);
                        Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'QR Code disalin ke clipboard', timer: 2000, showConfirmButton: false });
                    } catch(e) {
                        // Final fallback: download
                        const link = document.createElement('a');
                        link.download = 'QR_' + (labelKode.textContent || 'aset') + '.png';
                        link.href = canvas.toDataURL('image/png');
                        link.click();
                        Swal.fire({ icon: 'info', title: 'Info', text: 'Fitur bagikan tidak didukung browser ini. File telah didownload.', timer: 2500, showConfirmButton: false });
                    }
                }
            } catch(err) {
                console.error('Share error:', err);
            }
        };
        img.src = qrImg.src || qrImg.toDataURL();
    }

    // QR Scanner
    let html5QrScanner = null;

    function startQRScanner() {
        const scanResult = document.getElementById('scanResult');
        const scanResultText = document.getElementById('scanResultText');
        const btnStart = document.getElementById('btnStartScan');
        const btnStop = document.getElementById('btnStopScan');

        if (scanResult) scanResult.style.display = 'none';
        btnStart.style.display = 'none';
        btnStop.style.display = 'inline-block';

        html5QrScanner = new Html5Qrcode('qr-reader');
        html5QrScanner.start(
            { facingMode: 'environment' },
            { fps: 10, qrbox: { width: 220, height: 220 } },
            (decodedText) => {
                // QR berhasil di-scan
                if (scanResultText) scanResultText.textContent = decodedText;
                if (scanResult) scanResult.style.display = 'block';
                
                stopQRScanner();

                // Re-init lucide icons
                if (typeof lucide !== 'undefined') lucide.createIcons();
            },
            (errorMessage) => {
                // Scan error (normal, terus mencoba)
            }
        ).catch(err => {
            console.error('QR Scanner error:', err);
            Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Tidak dapat mengakses kamera. Pastikan izin kamera sudah diberikan.', showConfirmButton: true });
            btnStart.style.display = 'inline-block';
            btnStop.style.display = 'none';
        });
    }

    function stopQRScanner() {
        const btnStart = document.getElementById('btnStartScan');
        const btnStop = document.getElementById('btnStopScan');

        if (html5QrScanner) {
            html5QrScanner.stop().then(() => {
                html5QrScanner.clear();
                html5QrScanner = null;
            }).catch(err => console.error('Stop error:', err));
        }

        if (btnStart) btnStart.style.display = 'inline-block';
        if (btnStop) btnStop.style.display = 'none';
    }

    // Auto-stop scanner when modal closes
    document.addEventListener('DOMContentLoaded', function() {
        const modalEl = document.getElementById('modalCetakQR');
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function() {
                stopQRScanner();
            });
        }
    });
    </script>

    <?php if (isset($_SESSION['alert'])): ?>
        <script>
            <?php
            $alertType = 'info';
            $alertTitle = 'Info';
            $alertText = '';
            
            switch ($_SESSION['alert']) {
                case "SimpanBerhasil":
                    $alertType = 'success'; $alertTitle = 'Berhasil!'; $alertText = 'Data berhasil disimpan.'; break;
                case "SimpanGagal":
                    $debugMsg = $_SESSION['alert_debug'] ?? '';
                    $alertType = 'error'; $alertTitle = 'Gagal!'; $alertText = 'Data gagal disimpan.' . ($debugMsg ? ' Error: ' . $debugMsg : ''); 
                    unset($_SESSION['alert_debug']);
                    break;
                case "HapusBerhasil":
                    $alertType = 'success'; $alertTitle = 'Berhasil!'; $alertText = 'Data berhasil dihapus.'; break;
                case "HapusGagal":
                    $alertType = 'error'; $alertTitle = 'Gagal!'; $alertText = 'Data gagal dihapus.'; break;
                case "AktifBerhasil":
                    $alertType = 'success'; $alertTitle = 'Berhasil!'; $alertText = 'Status berhasil diaktifkan.'; break;
                case "NonAktifBerhasil":
                    $alertType = 'success'; $alertTitle = 'Berhasil!'; $alertText = 'Status berhasil dinonaktifkan.'; break;
            }
            ?>
            Swal.fire({
                icon: '<?= $alertType ?>',
                title: '<?= $alertTitle ?>',
                text: '<?= $alertText ?>',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
</body>
</html>