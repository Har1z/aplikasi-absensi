<?php

    require "../../private/function/db_init.php";
    $get_nisn = $_GET['q'];

    $querySiswa = mysqli_query($con, "SELECT * FROM siswa WHERE nisn='$get_nisn'");
    $data = mysqli_fetch_array($querySiswa);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Attendance - data siswa</title>
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
            appearance: textfield;
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
                    <h4 class="fw-bold">EDIT DATA SISWA (<?=  $data['nama'] ?>)</h4>
                </div>
            </div>

            <div class="col-12 mb-4">
                <!-- box data -->
                <div class="shadow-sm rounded bg-white">
                    <div class="container-fluid">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-12 col-lg-4 mb-3">

                                    <div class="mb-3 mt-3">
                                        <label for="nisnInput" class="form-label">NISN</label>
                                        <input type="text" class="form-control" id="nisnInput" name="nisn" value="<?= $data['nisn'] ?>" minlength="10" required >
                                    </div>

                                    <div class="mb-3">
                                        <label for="noHpSiswaInput" class="form-label">No. HP siswa (opsional)</label>
                                        <input type="number" class="form-control" id="noHpSiswaInput" name="noHpSiswa" value="<?= $data['no_siswa'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="noHpOrtuInput" class="form-label">No. HP orangtua</label>
                                        <input type="number" class="form-control" id="noHpOrtuInput" name="noHpOrtu" value="<?= $data['no_orangtua'] ?>" required >
                                    </div>

                                </div>

                                <div class="col-12 col-lg-4 mb-3">

                                    <div class="mb-3 mt-3">
                                        <label for="namaInput" class="form-label">Nama siswa</label>
                                        <input type="text" class="form-control" id="namaInput" name="nama" autocomplete="off" value="<?= $data['nama'] ?>" required >
                                    </div>

                                    <div class="mb-3">
                                        <label for="jenisKelaminInput" class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" aria-label="Default select example" id="jenisKelaminInput" name="jenisKelamin" >
                                            <option value="laki-laki" <?php if ($data['jenis_kelamin'] == "laki-laki") {echo "selected";}?> >Laki-laki</option>
                                            <option value="perempuan" <?php if ($data['jenis_kelamin'] == "perempuan") {echo "selected";}?> >Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <div class="container-fluid p-0">
                                            <div class="row">

                                                <div class="col-4">
                                                    <label for="kelasInput" class="form-label">Kelas</label>
                                                    <select class="form-select" aria-label="Default select example" id="kelasInput" name="kelas" >
                                                        <option value="10" <?php if ($data['kelas'] == 10) {echo "selected";}?> >10 (sepuluh)</option>
                                                        <option value="11" <?php if ($data['kelas'] == 11) {echo "selected";}?> >11 (sebelas)</option>
                                                        <option value="12" <?php if ($data['kelas'] == 12) {echo "selected";}?> >12 (dua belas)</option>
                                                    </select>
                                                </div>

                                                <div class="col-8">
                                                    <label for="jurusanInput" class="form-label">Jurusan</label>
                                                    <select class="form-select" aria-label="Default select example" id="jurusanInput" name="jurusan" >
                                                        <option value="Kecantikan" <?php if ($data['jurusan'] == "Kecantikan") {echo "selected";}?> >Tata Kecantikan</option>
                                                        <option value="Keperawatan" <?php if ($data['jurusan'] == "Keperawatan") {echo "selected";}?> >Keperawatan</option>
                                                        <option value="TKJ" <?php if ($data['jurusan'] == "TKJ") {echo "selected";}?> >Teknik Komputer dan Jaringan (TKJ)</option>
                                                        <option value="RPL" <?php if ($data['jurusan'] == "RPL") {echo "selected";}?> >Rekayasa Perangkat Lunak (RPL)</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            
                            <button type="submit" class="btn btn-primary mb-3" name="submit">Simpan</button>
                            <button type="submit" class="btn btn-light border mb-3 user-select-none" value="Submit" form="back">cancel</button>
                            <!-- <a href="./?tab=data-siswa" type="button" class="btn btn-light border mb-3 user-select-none">cancel</a> -->
                        </form>
                        <form method="POST" action="./?tab=data-siswa" id="back">
                            <input type="hidden" name="kelas" value="<?= isset($_GET['c']) ? $_GET['c'] : 0 ?>" /> 
                            <input type="hidden" name="jurusan" value="<?= isset($_GET['j']) ? $_GET['j'] : 0 ?>" /> 
                        </form>
                    </div>
                </div>
                <!-- box data end -->

                <?php
                    if(isset($_POST['submit'])){
                        
                        $nisn = htmlspecialchars($_POST['nisn']);
                        $nama = htmlspecialchars($_POST['nama']);
                        if (isset($_POST['noHpSiswa'])) {
                            $noSiswa = htmlspecialchars($_POST['noHpSiswa']);
                        } else {
                            $noSiswa = "-";
                        }
                        $noOrtu = htmlspecialchars($_POST['noHpOrtu']);
                        $jenisKelamin = htmlspecialchars($_POST['jenisKelamin']);
                        $kelas = htmlspecialchars($_POST['kelas']);
                        $jurusan = htmlspecialchars($_POST['jurusan']);

                        //i checking for the duplicated student data in case the admin forgot and input the data twice
                        //first i need to check if the user changed the nisn or nah
                        if ($nisn == $get_nisn) {
                            $jumlahData = 0;
                        } else {
                            $query = mysqli_query($con, "SELECT * FROM siswa WHERE nisn='$nisn'");
                            $jumlahData = mysqli_num_rows($query);
                        }

                        if($jumlahData > 0){
                            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                siswa dengan NISN tersebut sudah ada.
                            </div>
                            <?php
                        } else {
                            //updating the data
                            $querySimpan = mysqli_query($con, "UPDATE siswa SET `nisn`='$nisn',`nama`='$nama',`jenis_kelamin`='$jenisKelamin',`kelas`='$kelas',`jurusan`='$jurusan',`no_siswa`='$noSiswa',`no_orangtua`='$noOrtu' WHERE nisn='$get_nisn'");
                            
                            if($querySimpan){
                                ?>
                                <div class="alert alert-success mt-3" role="alert">
                                    Data berhasil tersimpan.
                                </div>
    
                                <script>
                                    setTimeout(function() {
                                    document.getElementById('back').submit();
                                    }, 1000);
                                </script>
                                <!-- <meta http-equiv="refresh" content="1; url=./?tab=data-siswa" /> -->
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