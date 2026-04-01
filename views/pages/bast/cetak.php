<?php
if (empty($id) || empty($bastData)) {
    echo "<div class='text-center mt-5'>Data BAST tidak ditemukan.</div>";
    exit;
}

$noBast = htmlspecialchars($bastData['NoBast']);
$tanggal = date('d F Y', strtotime($bastData['Create_at']));
$keterangan = htmlspecialchars($bastData['Keterangan']);
$status = $bastData['Status'];

// Set locale to Indonesian for dates
setlocale(LC_ALL, 'id_ID.utf8', 'id_ID', 'id', 'indonesian');
function formatTanggal($date) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $b = (int)date('m', strtotime($date));
    return date('d', strtotime($date)) . ' ' . $bulan[$b] . ' ' . date('Y', strtotime($date));
}
$tanggalFormat = formatTanggal($bastData['Create_at']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAST - <?= $noBast ?></title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
            position: relative;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .kop-surat h2 {
            margin: 0 0 5px 0;
            font-size: 16pt;
            text-transform: uppercase;
        }
        .kop-surat p {
            margin: 0;
            font-size: 11pt;
        }
        .judul-surat {
            text-align: center;
            margin-bottom: 30px;
        }
        .judul-surat h3 {
            margin: 0;
            font-size: 14pt;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .judul-surat p {
            margin: 5px 0 0 0;
        }
        .paragraf {
            text-align: justify;
            margin-bottom: 15px;
        }
        .table-aset {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table-aset th, .table-aset td {
            border: 1px solid #000;
            padding: 8px 12px;
            text-align: left;
        }
        .table-aset th {
            font-weight: bold;
            text-align: center;
            background-color: #f2f2f2;
        }
        .ttd-section {
            width: 100%;
            margin-top: 50px;
            page-break-inside: avoid;
        }
        .ttd-box {
            width: 45%;
            text-align: center;
            float: left;
        }
        .ttd-box.right {
            float: right;
        }
        .ttd-nama {
            margin-top: 80px;
            font-weight: bold;
            text-decoration: underline;
        }
        .ttd-jabatan {
            margin-top: 5px;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80pt;
            color: rgba(0,0,0,0.05);
            z-index: -1;
            white-space: nowrap;
        }
        /* Hide buttons when printing */
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .watermark { color: rgba(0,0,0,0.05) !important; }
        }
        .action-bar {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            margin-bottom: 30px;
        }
        .btn {
            display: inline-block;
            padding: 8px 20px;
            background: #0d6efd;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }
        .btn:hover { background: #0b5ed7; }
        
        /* Floating notification if not approved */
        .not-approved-banner {
            background: #ffeeba;
            color: #856404;
            padding: 10px;
            text-align: center;
            font-family: Arial, sans-serif;
            font-weight: bold;
            margin-bottom: 20px;
            border: 1px solid #ffeeba;
        }
    </style>
</head>
<body>

    <div class="action-bar no-print">
        <button class="btn" onclick="window.print()">🖨️ Cetak Dokumen</button>
        <button class="btn" onclick="window.close()" style="background: #6c757d; margin-left: 10px;">Tutup</button>
    </div>

    <div class="container">
        <?php if ($status !== 'selesai (approved)'): ?>
            <div class="not-approved-banner no-print">
                ⚠️ DOKUMEN INI BELUM DISETUJUI SEPENUHNYA (Masih DRAFT)
            </div>
            <div class="watermark">DRAFT</div>
        <?php endif; ?>

        <div class="kop-surat">
            <h2>BERITA ACARA SERAH TERIMA ASET</h2>
            <p>Sistem Manajemen Inventaris (MenSet)</p>
        </div>

        <div class="judul-surat">
            <h3>BERITA ACARA SERAH TERIMA</h3>
            <p>Nomor: <?= $noBast ?></p>
        </div>

        <div class="paragraf">
            Pada hari ini, tanggal <strong><?= $tanggalFormat ?></strong>, telah dilakukan serah terima barang/aset inventaris dengan rincian sebagai berikut:
        </div>

        <table style="width: 100%; margin-bottom: 20px; border-collapse: collapse;">
            <tr>
                <td style="width: 30%; padding: 5px 0; vertical-align: top;"><strong>PIHAK PERTAMA (Penyerah)</strong></td>
                <td style="width: 5%; padding: 5px 0; vertical-align: top;">:</td>
                <td style="width: 65%; padding: 5px 0; vertical-align: top;"><?= htmlspecialchars($namaPenyerah) ?></td>
            </tr>
            <tr>
                <td style="padding: 5px 0; vertical-align: top;"><strong>PIHAK KEDUA (Penerima)</strong></td>
                <td style="padding: 5px 0; vertical-align: top;">:</td>
                <td style="padding: 5px 0; vertical-align: top;"><?= htmlspecialchars($namaPenerima) ?></td>
            </tr>
        </table>

        <div class="paragraf">
            PIHAK PERTAMA menyerahkan barang/aset kepada PIHAK KEDUA, dan PIHAK KEDUA menyatakan telah menerima barang/aset tersebut dalam kondisi yang telah diperiksa bersama, dengan rincian sebagai berikut:
        </div>

        <table class="table-aset">
            <thead>
                <tr>
                    <th style="width: 8%;">No.</th>
                    <th style="width: 20%;">Kode Aset</th>
                    <th style="width: 42%;">Nama Aset</th>
                    <th style="width: 15%;">Kategori</th>
                    <th style="width: 15%;">Kondisi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($detailAset)) {
                    echo '<tr><td colspan="5" style="text-align:center; padding: 15px;">Belum ada rincian aset</td></tr>';
                } else {
                    $no = 1;
                    foreach ($detailAset as $d) {
                        echo '<tr>';
                        echo '<td style="text-align:center;">' . $no++ . '</td>';
                        echo '<td>' . htmlspecialchars($d['KodeAset']) . '</td>';
                        echo '<td>' . htmlspecialchars($d['NamaAset']) . '</td>';
                        echo '<td>' . htmlspecialchars($d['Kategori']) . '</td>';
                        echo '<td>' . htmlspecialchars($d['KondisiAset'] ?? 'Baik') . '</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>

        <?php if (!empty($keterangan)): ?>
        <div class="paragraf mt-4">
            <strong>Catatan Tambahan:</strong><br>
            <?= nl2br($keterangan) ?>
        </div>
        <?php endif; ?>

        <div class="paragraf" style="margin-top: 30px;">
            Demikian Berita Acara Serah Terima ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya. Sejak ditandatanganinya Berita Acara ini, maka tanggung jawab pemeliharaan dan pengamanan aset beralih kepada PIHAK KEDUA.
        </div>

        <div class="ttd-section">
            <div class="ttd-box">
                <div><strong>PIHAK KEDUA</strong></div>
                <div>(Penerima)</div>
                <div class="ttd-nama"><?= htmlspecialchars($namaPenerima) ?></div>
                <div class="ttd-jabatan"></div>
            </div>
            
            <div class="ttd-box right">
                <div><strong>PIHAK PERTAMA</strong></div>
                <div>(Penyerah)</div>
                <div class="ttd-nama"><?= htmlspecialchars($namaPenyerah) ?></div>
                <div class="ttd-jabatan"></div>
            </div>
            <div style="clear: both;"></div> <!-- Clear float -->
        </div>

    </div>

    <!-- Script to auto-print when ready (optional, disabled by default) -->
    <script>
        window.onload = function() {
            // Uncomment line below to auto-print when opened
            // window.print();
        }
    </script>
</body>
</html>
