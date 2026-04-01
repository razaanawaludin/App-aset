<?php
// Halaman hapus sudah tidak digunakan lagi
// Fungsi hapus sudah dipindahkan ke controller kpenghapusan.php dan edit.php
// Redirect ke halaman daftar penghapusan
header("location:index.php?pg=$pg&fl=kpenghapusan");
exit();
?>
