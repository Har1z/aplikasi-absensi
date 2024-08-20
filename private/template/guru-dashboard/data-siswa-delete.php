<?php

    require "../../private/function/db_init.php";
    $nisn = $_GET['q'];

    $queryDelete = mysqli_query($con, "DELETE FROM siswa WHERE nisn='$nisn'");
    
    if($queryDelete) {
        header('location: ./?tab=data-siswa');
    }
    else{
        echo mysqli_error($con);
    }

?>