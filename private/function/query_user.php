<?php
function checkEmail($email)
{
    require "db_init.php";

    $query = mysqli_query($con, "SELECT * FROM admin WHERE email='$email'");
    $countdata = mysqli_num_rows($query);
    $data = mysqli_fetch_array($query);

    if ($countdata > 0) {
        echo "admin";
        echo $data['nama'];
        $countdata = -1;
    } else {
        $query = mysqli_query($con, "SELECT * FROM guru WHERE email='$email'");
        $countdata = mysqli_num_rows($query);
        $data = mysqli_fetch_array($query);

        if ($countdata > 0) {
            echo "guru";
            echo $data['nama'];
            $countdata = -1;
        } else {
            $query = mysqli_query($con, "SELECT * FROM siswa WHERE email='$email'");
            $countdata = mysqli_num_rows($query);
            $data = mysqli_fetch_array($query);

            if ($countdata > 0) {
                echo "siswa";
                echo $data['nama'];
                $countdata = -1;
            } else if ($countdata == 0) {
                echo "data tidak ketemu nih..";
            }
        }
    }



}

function checkEmailV2($email) 
{
    require "db_init.php";
    $roles = ['admin', 'guru', 'siswa'];
    $roleFound = false;

    foreach ($roles as $role) {
        $query = mysqli_query($con, "SELECT * FROM $role WHERE email='$email'");
        $countdata = mysqli_num_rows($query);

        if ($countdata > 0) {
            $roleFound = true;
            $data = mysqli_fetch_array($query);
            break;
        }
    }
}
checkEmail("rendang@gmail.com");

//u can use smth like this header('location: '.$url)

?>