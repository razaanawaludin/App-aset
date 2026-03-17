<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$_SESSION['status'] = 'OKE';
$_SESSION['IdUser'] = 1;

$_GET['pg'] = 'kpegawai';
$_GET['fl'] = 'form';
$_GET['ak'] = 'edit';
$_GET['id'] = 1;

require 'index.php';
?>
