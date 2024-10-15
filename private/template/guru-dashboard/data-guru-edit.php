<?php

    require "../../private/function/db_init.php";
    $get_id = $_GET['q'];

    $queryGuru = mysqli_query($con, "SELECT * FROM guru WHERE id_g='$get_id'");
    $data = mysqli_fetch_array($queryGuru);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Attendance - data guru</title>
    <link rel="icon" type="image/png" href="../resources/images/logo.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");

        :root {
            --header-height: 3rem;
            --nav-width: 68px;
            --first-color: #4723D9;
            --first-color-light: #AFA5D9;
            --white-color: #F7F6FB;
            --body-font: 'Nunito', sans-serif;
            --normal-font-size: 1rem;
            --z-fixed: 100
        }

        *,
        ::before,
        ::after {
            box-sizing: border-box
        }

        body {
            position: relative;
            margin: var(--header-height) 0 0 0;
            padding: 0 1rem;
            font-family: var(--body-font);
            font-size: var(--normal-font-size);
            transition: .5s
        }

        a {
            text-decoration: none
        }

        .header {
            width: 100%;
            height: var(--header-height);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            background-color: var(--white-color);
            z-index: var(--z-fixed);
            transition: .5s
        }

        .header_toggle {
            color: var(--first-color);
            font-size: 1.5rem;
            cursor: pointer
        }

        .header_img {
            width: 35px;
            height: 35px;
            display: flex;
            justify-content: center;
            border-radius: 50%;
            overflow: hidden
        }

        .header_img img {
            width: 40px
        }

        .l-navbar {
            position: fixed;
            top: 0;
            left: -30%;
            width: var(--nav-width);
            height: 100vh;
            background-color: var(--first-color);
            padding: .5rem 1rem 0 0;
            transition: .5s;
            z-index: var(--z-fixed)
        }

        .nav {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden
        }

        .nav_logo,
        .nav_link {
            display: grid;
            grid-template-columns: max-content max-content;
            align-items: center;
            column-gap: 1rem;
            padding: .5rem 0 .5rem 1.5rem
        }

        .nav_logo {
            margin-bottom: 2rem
        }

        .nav_logo-icon {
            font-size: 1.25rem;
            color: var(--white-color)
        }

        .nav_logo-name {
            color: var(--white-color);
            font-weight: 700
        }

        .nav_link {
            position: relative;
            color: var(--first-color-light);
            margin-bottom: 1.5rem;
            transition: .3s
        }

        .nav_link:hover {
            color: var(--white-color)
        }

        .nav_icon {
            font-size: 1.25rem
        }

        .show {
            left: 0
        }

        .body-pd {
            padding-left: calc(var(--nav-width) + 1rem)
        }

        .active {
            color: var(--white-color)
        }

        .active::before {
            content: '';
            position: absolute;
            left: 0;
            width: 2px;
            height: 32px;
            background-color: var(--white-color)
        }

        .height-100 {
            height: 100vh
        }

        .card {
            width: 22rem;
            margin-top: 5px;
            border-color: white;
        }

        .card-body {
            width: 350px;
            height: 99.3px;
        }

        .card-title {
            font-weight: bolder;
            font-size: 30px;
            color: #fff;
            transform: translate(30px, 0px);
        }

        /* HIDE INPUT TYPE NUMBER ARROW */
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        @media screen and (min-width: 768px) {
            body {
                margin: calc(var(--header-height) + 1rem) 0 0 0;
                padding-left: calc(var(--nav-width) + 2rem)
            }

            .header {
                height: calc(var(--header-height) + 1rem);
                padding: 0 2rem 0 calc(var(--nav-width) + 2rem)
            }

            .header_img {
                width: 40px;
                height: 40px
            }

            .header_img img {
                width: 45px
            }

            .l-navbar {
                left: 0;
                padding: 1rem 1rem 0 0
            }

            .show {
                width: calc(var(--nav-width) + 156px)
            }

            .body-pd {
                padding-left: calc(var(--nav-width) + 188px)
            }
        }

        @media (max-width: 1024px) {
            .card {
                width: 430px;
                margin-bottom: 10px;
            }
        }

        @media (max-width: 768px) {
            .card {
                width: 300px;
                margin-bottom: 10px;
            }
        }

        @media (max-width: 467px) {
            .card {
                width: 18rem;
                margin-bottom: 10px;
            }
        }

        @media (max-width: 320px) {
            .card {
                width: 16rem;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body id="body-pd" class="bg-light">
    <?php require "navbar.php"; ?>

    <!--Container Main start-->
    <div class="container-fluid">
        <div class="row">


            <div class="col-12 mb-2">
                <div>
                    <h4 class="fw-bold">EDIT DATA GURU (<?=  $data['nama'] ?>)</h4>
                </div>
            </div>

            <div class="col-12 mb-4">
                <!-- box data -->
                <div class="shadow-sm rounded bg-white">
                    <div class="container-fluid">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-4 mb-3">

                                    <div class="mb-3 mt-3">
                                        <label for="emailInput" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="emailInput" name="email" value="<?= $data['email'] ?>" required >
                                    </div>

                                    <div class="mb-3">
                                        <label for="noHpInput" class="form-label">No. HP Guru</label>
                                        <input type="number" class="form-control" id="noHpInput" name="noHp" value="<?= $data['no_guru'] ?>" required >
                                    </div>

                                    <div class="mb-3">
                                        <label for="passwordInput" class="form-label">Ganti password (opsional)</label>
                                        <input type="text" class="form-control" id="passwordInput" name="password" autocomplete="off">
                                    </div>

                                </div>

                                <div class="col-4 mb-3">

                                    <div class="mb-3 mt-3">
                                        <label for="namaInput" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="namaInput" name="nama" autocomplete="off" value="<?= $data['nama'] ?>" required >
                                    </div>

                                    <div class="mb-3">
                                        <label for="jenisAkunInput" class="form-label">Jenis Akun</label>
                                        <select class="form-select" aria-label="Default select example" id="jenisAkunInput" name="jenisAkun" >
                                            <option value="admin" <?php if ($data['jenis_akun'] == "admin") {echo "selected";}?> >Admin</option>
                                            <option value="petugas" <?php if ($data['jenis_akun'] == "petugas") {echo "selected";}?> >Petugas</option>
                                        </select>
                                    </div>

                                </div>

                            </div>

                            
                            <button type="submit" class="btn btn-primary mb-3" name="submitForm">Simpan</button>
                            <a href="./?tab=data-guru" type="button" class="btn btn-light border mb-3 user-select-none">cancel</a>
                        </form>
                    </div>
                </div>
                <!-- box data end -->

                <?php
                    if(isset($_POST['submitForm'])){
                        
                        $email = htmlspecialchars($_POST['email']);
                        $nama = htmlspecialchars($_POST['nama']);
                        $noHp = htmlspecialchars($_POST['noHp']);
                        $jenisAkun = htmlspecialchars($_POST['jenisAkun']);

                        if (isset($_POST['password'])) {
                            $password = htmlspecialchars($_POST['password']);
                        }

                        //i checking for the duplicated student data in case the admin forgot and input the data twice
                        //first i need to check if the user changed the nisn or nah
                        if ($email == $data['email']) {
                            $jumlahData = 0;
                        } else {
                            $query = mysqli_query($con, "SELECT * FROM guru WHERE email='$email'");
                            $jumlahData = mysqli_num_rows($query);
                        }

                        if($jumlahData > 0){
                            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                data dengan email tersebut sudah ada.
                            </div>
                            <?php
                        } else {
                            //updating the data
                            if ($password != "") {
                                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                                $querySimpan = mysqli_query($con, "UPDATE guru SET `email`='$email',`nama`='$nama',`jenis_akun`='$jenisAkun', `no_guru`='$noHp', `password`='$hashedPassword' WHERE id_g='$get_id'");
                            } else {
                                $querySimpan = mysqli_query($con, "UPDATE guru SET `email`='$email',`nama`='$nama',`jenis_akun`='$jenisAkun', `no_guru`='$noHp' WHERE id_g='$get_id'");
                            }
                            

                            if($querySimpan){
                                ?>
                                <div class="alert alert-success mt-3" role="alert">
                                    Data berhasil tersimpan.
                                </div>
    
                                <meta http-equiv="refresh" content="1; url=./?tab=data-guru" />
                                <?php
    
                            }
                            else{
                                echo mysqli_error($con);
                            }
                        }
                    }
                ?>

            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function (event) {

        const showNavbar = (toggleId, navId, bodyId, headerId) => {
            const toggle = document.getElementById(toggleId),
                nav = document.getElementById(navId),
                bodypd = document.getElementById(bodyId),
                headerpd = document.getElementById(headerId)

            // Validate that all variables exist
            if (toggle && nav && bodypd && headerpd) {
                toggle.addEventListener('click', () => {
                    // show navbar
                    nav.classList.toggle('show')
                    // change icon
                    toggle.classList.toggle('bx-x')
                    // add padding to body
                    bodypd.classList.toggle('body-pd')
                    // add padding to header
                    headerpd.classList.toggle('body-pd')
                })
            }
        }

        showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header')

        // Your code to run since DOM is loaded and ready
    });

    function myClick() {
        console.log("hello");
    }
</script>

</html>