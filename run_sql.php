<?php
include("cores/database.php");
include("app-config.php");

try {
    $sql = file_get_contents("sql_bast.sql");
    $koneksiku->exec($sql);
    echo "Tabel berhasil dibuat!";
} catch (Exception $e) {
    echo "Gagal membuat tabel: " . $e->getMessage();
}
?>
