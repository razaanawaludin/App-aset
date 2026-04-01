<?php
$btn = $_POST['Btn'] ?? '';

// Ambil data pegawai untuk dropdown
try { $semuaPegawai = selectData($koneksiku, 'pegawai'); } catch (Exception $e) { $semuaPegawai = []; }

// Ambil data aset untuk dropdown
try { $semuaAset = selectData($koneksiku, 'kelola_aset'); } catch (Exception $e) { $semuaAset = []; }

// Fungsi generate nomor penghapusan otomatis
function generateNoPenghapusan($koneksiku) {
    try {
        $tahun = date('Y');
        $stmt = $koneksiku->query("SELECT MAX(IdPenghapusan) as maxId FROM penghapusan_aset");
        $result = $stmt->fetch();
        $nextId = ($result['maxId'] ?? 0) + 1;
        return 'PH/' . $tahun . '/' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    } catch (Exception $e) {
        return 'PH/' . date('Y') . '/0001';
    }
}

// ========== AKSI: Buat Dokumen Baru ==========
if ($btn === 'Buat') {
    $penanggungJawab = $_POST['penanggung_jawab'] ?? '';
    $alasan          = $_POST['alasan'] ?? '';
    $keterangan      = $_POST['keterangan'] ?? '';

    if (!empty($alasan)) {
        try {
            $noPenghapusan = generateNoPenghapusan($koneksiku);
            $dataBaru = [
                'NoPenghapusan'     => $noPenghapusan,
                'IdPenanggungJawab' => !empty($penanggungJawab) ? $penanggungJawab : null,
                'AlasanPenghapusan' => $alasan,
                'Keterangan'        => $keterangan,
                'Status'            => 'draft'
            ];
            $simpan = insertData($koneksiku, 'penghapusan_aset', $dataBaru);
            
            if ($simpan) {
                // Ambil ID yang baru dibuat
                $newId = $koneksiku->lastInsertId();
                $_SESSION['alert'] = "SimpanBerhasil";
                header("location:index.php?pg=$pg&fl=edit&id=$newId");
                exit();
            } else {
                $_SESSION['alert'] = "SimpanGagal";
            }
        } catch (Exception $e) {
            $_SESSION['alert'] = "SimpanGagal";
        }
    }
    header("location:index.php?pg=$pg&fl=kpenghapusan");
    exit();
}

$noPenghapusanOtomatis = generateNoPenghapusan($koneksiku);
?>
