<?php

// echo password_hash("7639402671", PASSWORD_DEFAULT);
include "../../library/phpqrcode/qrlib.php";

$tempdir = "../resources/images/QRcode/"; //Nama folder tempat menyimpan file qrcode
if (!file_exists($tempdir)) //Buat folder bername temp
    mkdir($tempdir);

//ambil logo
$logopath = "../resources/images/logo.png";




//isi qrcode jika di scan
// $codeContents = 'absen-lab1234567890';
// $codeContents = '5674893026';
$codeContents = '1234567890';
//jadi format nisn itu 10 digit
$nama = "haris";

//simpan file qrcode
QRcode::png($codeContents, $tempdir . $nama . '.png', QR_ECLEVEL_H, 10, 4);


// ambil file qrcode
$QR = imagecreatefrompng($tempdir . $nama . '.png');

// memulai menggambar logo dalam file qrcode
$logo = imagecreatefromstring(file_get_contents($logopath));

imagecolortransparent($logo, imagecolorallocatealpha($logo, 0, 0, 0, 127));
imagealphablending($logo, false);
imagesavealpha($logo, true);

$QR_width = imagesx($QR);
$QR_height = imagesy($QR);

$logo_width = imagesx($logo);
$logo_height = imagesy($logo);

// Scale logo to fit in the QR Code
$logo_qr_width = $QR_width / 4;
$scale = $logo_width / $logo_qr_width;
$logo_qr_height = $logo_height / $scale;

imagecopyresampled($QR, $logo, $QR_width / 2.65, $QR_height / 2.65, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

// Simpan kode QR lagi, dengan logo di atasnya
imagepng($QR, $tempdir . 'qrwithlogo.png');

//menampilkan file qrcode 
echo '<div align="center"><h2>Create QR Code With Logo PHP</h2>';
echo '<img src="' . $tempdir . 'qrwithlogo.png' . '" />';

// Create Image From Existing File
$jpg_image = imagecreatefrompng($tempdir . 'qrwithlogo.png');

// Allocate A Color For The Text
$black = imagecolorallocate($jpg_image, 255, 255, 255);

// Set Path to Font File
$font_path = '../resources/font/Arial.ttf';

// Set Text to Be Printed On Image
$text = "aufa";

// Print Text On Image
imagettftext($jpg_image, 20, 0, 45, 280, $black, $font_path, $text);

imagepng($jpg_image, $tempdir . 'qrwithlogotext.png');

//menampilkan file qrcode 
echo '<div align="center"><h2>Create QR Code With Logo PHP</h2>';
echo '<img src="' . $tempdir . 'qrwithlogotext.png' . '" />';


?>