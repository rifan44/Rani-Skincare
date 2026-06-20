<?php
$host = "localhost";
$user = "ifummiid_kelasa"; 
$pass = "pemweb_db_a";     
$db   = "ifummiid_kelasa";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>