<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Test Database Kategori Aset</h2>";

// Koneksi
include("cores/database.php");
include("app-config.php");

echo "<h3>1. Koneksi Database</h3>";
echo "Koneksi: OK<br>";

// Cek tabel
echo "<h3>2. Cek Tabel kategori_aset</h3>";
try {
    $stmt = $koneksiku->query("SHOW TABLES LIKE 'kategori_aset'");
    $result = $stmt->fetchAll();
    if (count($result) > 0) {
        echo "Tabel kategori_aset: ADA<br>";
    } else {
        echo "<b style='color:red'>Tabel kategori_aset: TIDAK ADA!</b><br>";
        echo "Silakan buat tabelnya dulu dengan SQL ini:<br>";
        echo "<pre>CREATE TABLE IF NOT EXISTS kategori_aset (
    IdKategori INT AUTO_INCREMENT PRIMARY KEY,
    KodeKategori VARCHAR(20) NOT NULL,
    NamaKategori VARCHAR(100) NOT NULL,
    Deskripsi TEXT
);</pre>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

// Cek struktur tabel
echo "<h3>3. Struktur Tabel</h3>";
try {
    $stmt = $koneksiku->query("DESCRIBE kategori_aset");
    $cols = $stmt->fetchAll();
    echo "<table border='1' cellpadding='5'><tr><th>Field</th><th>Type</th></tr>";
    foreach ($cols as $col) {
        echo "<tr><td>{$col['Field']}</td><td>{$col['Type']}</td></tr>";
    }
    echo "</table><br>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

// Test insert
echo "<h3>4. Test Insert</h3>";
try {
    $testData = [
        'KodeKategori' => 'TEST',
        'NamaKategori' => 'Test Kategori',
        'Deskripsi' => 'Data test'
    ];
    $simpan = insertData($koneksiku, 'kategori_aset', $testData);
    if ($simpan) {
        echo "<b style='color:green'>Insert BERHASIL!</b><br>";
        // Hapus data test
        $koneksiku->exec("DELETE FROM kategori_aset WHERE KodeKategori = 'TEST'");
        echo "Data test sudah dihapus.<br>";
    } else {
        echo "<b style='color:red'>Insert GAGAL (return false)</b><br>";
    }
} catch (Exception $e) {
    echo "<b style='color:red'>Insert ERROR: " . $e->getMessage() . "</b><br>";
}

// Cek tabel kelola_aset 
echo "<h3>5. Cek Tabel kelola_aset</h3>";
try {
    $stmt = $koneksiku->query("SHOW TABLES LIKE 'kelola_aset'");
    $result = $stmt->fetchAll();
    echo count($result) > 0 ? "Tabel kelola_aset: ADA<br>" : "<b style='color:red'>Tabel kelola_aset: TIDAK ADA!</b><br>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

// Cek tabel lokasi_aset
echo "<h3>6. Cek Tabel lokasi_aset</h3>";
try {
    $stmt = $koneksiku->query("SHOW TABLES LIKE 'lokasi_aset'");
    $result = $stmt->fetchAll();
    echo count($result) > 0 ? "Tabel lokasi_aset: ADA<br>" : "<b style='color:red'>Tabel lokasi_aset: TIDAK ADA!</b><br>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
?>
