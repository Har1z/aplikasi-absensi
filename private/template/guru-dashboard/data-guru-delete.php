<?php

    require "../../private/function/db_init.php";
    $id = $_GET['q'];

    $queryDelete = mysqli_query($con, "DELETE FROM guru WHERE id_g='$id'");
    
    if($queryDelete) {
        header('location: ./?tab=data-guru');
    }
    else{
        echo mysqli_error($con);
    }

?>