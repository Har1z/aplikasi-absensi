<?php
    $con = mysqli_connect("absensi.sekolahlaboratoriumjakarta.com","u736687820_yaylabtech","Absensilab@11_","u736687820_lab_attendance");

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
?>