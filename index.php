<?php 
error_reporting(0);
// ini_set('display_errors', 1);
session_start();

$pg=$_GET['pg']??'';//page
$fl=$_GET['fl']??''; //file
$ak=$_GET['ak']??''; //aksi

include("cores/database.php");
include("app-config.php");

if($_SESSION['status']!=''){
    include("cores/component.php");
    include("controller/pages/$pg/$fl.php");
    include("views/dashboard.php");
}else{
    include("controller/login/login.php");
    include("views/login.php");
}

?>