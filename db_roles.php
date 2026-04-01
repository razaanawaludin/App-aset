<?php
include("cores/database.php");
$koneksiku = connectDB();
$stmt = $koneksiku->query("SELECT DISTINCT Role FROM pegawai");
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($roles);
?>
