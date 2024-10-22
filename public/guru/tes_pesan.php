<?php 
require "../../private/function/db_init.php";

$query = mysqli_query($con, "SELECT * FROM siswa WHERE nisn='0089745533'");
$data = mysqli_fetch_array($query);
$queryConfig = mysqli_query($con, "SELECT * FROM config WHERE id='1'");
$dataConfig = mysqli_fetch_array($queryConfig);
$pesanHadir = $dataConfig['pesan_hadir'];
$pesanPulang = $dataConfig['pesan_pulang'];

echo "<h1> sebelum </h1>";
var_dump($pesanHadir);
echo "<br>";
var_dump($pesanPulang);

echo "<h1> sesudah </h1>";
var_dump(str_replace("{nama_siswa}", $data['nama'], $dataConfig['pesan_hadir']));
echo "<br>";
var_dump(str_replace("{nama_siswa}", $data['nama'], $dataConfig['pesan_pulang']));