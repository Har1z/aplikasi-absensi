<?php
require "../private/function/db_init.php";

$password = "130706@Haris";
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$querySimpan = mysqli_query($con, "INSERT INTO `admin`(`nama`, `email`, `jk`, `password`) VALUES ('Admin','suharisbaihaqi7@gmail.com','laki-laki','$hashedPassword')");
if($querySimpan) {
    echo "berhasil";
}
?>