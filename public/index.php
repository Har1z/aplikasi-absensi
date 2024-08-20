<?php
    session_start();

    if($_SESSION['login']==true){
        if ($_SESSION['role'] == "admin") {
            header("location: ./admin");
            ob_end_flush();
            die();
        } else if ($_SESSION['role'] == "guru") {
            header("location: ./guru");
            ob_end_flush();
            die();
        } else if ($_SESSION['role'] == "siswa") {
            header("location: ./siswa");
            ob_end_flush();
            die();
        }
        die();
    } else {
        header('location: login.php');
        die(); //seriously i better off dead rather than exit()
    }
?>