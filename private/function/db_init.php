<?php
    $con = mysqli_connect("localhost","u736687820_yaylabtech","Absensilab@11_","u736687820_lab_attendance", "3306");
    // $con = mysqli_connect("localhost","root","","attendance_management");

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
?>