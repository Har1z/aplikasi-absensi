<?php

    require "../../private/function/db_init.php";


    if (isset($_POST['kelas'])){
        $filterKelas = $_POST['kelas'];
    } else {
        $filterKelas = '0';
    }

    if (isset($_POST['jurusan'])){
        $filterJurusan = $_POST['jurusan'];
    } else {
        $filterJurusan = '0';
    }

    switch($filterKelas) {
        case '0' :
            $kelas = "";
            break;
        
        case '10' :
            $kelas = "kelas='10'";
            break;
        
        case '11' :
            $kelas = "kelas='11'";
            break;
        
        case '12' :
            $kelas = "kelas='12'";
            break;

        default :
            $kelas = "";
            break;
    }

    switch($filterJurusan) {
        case '0' :
            $jurusan = "";
            break;
        
        case 'Kecantikan' :
            $jurusan = "jurusan='Kecantikan'";
            break;
        
        case 'Keperawatan' :
            $jurusan = "jurusan='Keperawatan'";
            break;
        
        case 'TKJ' :
            $jurusan = "jurusan='TKJ'";
            break;
        
        case 'RPL' :
            $jurusan = "jurusan='RPL'";
            break;

        default :
            $jurusan = "";
            break;
    }

    // if($jurusan != "" && $kelas != ""){
    //     echo "semua filter dipilih";
    // } else if($jurusan != "" || $kelas != "") {
    //     echo "salah satu filter dipilih";
    // } else {
    //     echo "tidak ada filter dipilih";
    // }
    
    if($jurusan != "" && $kelas != ""){
        $querySiswa = mysqli_query($con, "SELECT * FROM siswa WHERE $kelas AND $jurusan ORDER BY nama ASC");
    } else if($jurusan != "" || $kelas != "") {
        $querySiswa = mysqli_query($con, "SELECT * FROM siswa WHERE $kelas $jurusan ORDER BY nama ASC");
    } else {
        $querySiswa = mysqli_query($con, "SELECT * FROM siswa ORDER BY nama ASC");
    }


    
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

        @media (min-width: 1024px) {
            .hide-scrollbar::-webkit-scrollbar {
                display: block;
            }

            /* Hide scrollbar for IE, Edge and Firefox */
            .hide-scrollbar {
                -ms-overflow-style: block;  /* IE and Edge */
                scrollbar-width: block;  /* Firefox */
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
                    <h4 class="fw-bold">DATA SISWA</h4>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div>
                    <a type="button" href="?tab=tambah-data-siswa" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path></svg> Tambah data siswa</a>
                </div>
            </div>


            <div class="col-12 mb-4">
                <!-- box data -->
                <div class="shadow-sm rounded bg-white overflow-scroll hide-scrollbar">
                    <div class="container-fluid">
                        <!-- table -->
                        <div class="row">

                            <div class="col-6 col-lg-2 mb-2 mt-4">
                                <div>
                                <form method="post">
                                    <span for="kelas" class="form-label">Kelas</span>
                                    <select class="form-select" aria-label="Default select example" name='kelas' id="kelas" onchange='this.form.submit()'>
                                        <option value='0'>Semua Kelas</option>
                                        <option value='10' <?php if ($filterKelas == "10") {echo "selected";}?> >10 (sepuluh)</option>
                                        <option value='11' <?php if ($filterKelas == "11") {echo "selected";}?> >11 (sebelas)</option>
                                        <option value='12' <?php if ($filterKelas == "12") {echo "selected";}?> >12 (dua belas)</option>
                                    </select>
                                    <!-- <?= $filterKelas ?> -->
                                </div>
                            </div>

                            <div class="col-6 col-lg-2 mb-2 mt-4">
                                <div>

                                    <span for="jurusan" class="form-label">Jurusan</span>
                                    <select class="form-select" aria-label="Default select example" name='jurusan' id="jurusan" onchange='this.form.submit();'>
                                        <option value='0'>Semua Jurusan</option>
                                        <option value='Kecantikan' <?php if ($filterJurusan == "Kecantikan") {echo "selected";}?> >Tata Kecantikan</option>
                                        <option value='Keperawatan' <?php if ($filterJurusan == "Keperawatan") {echo "selected";}?> >Keperawatan</option>
                                        <option value='TKJ' <?php if ($filterJurusan == "TKJ") {echo "selected";}?> >Teknik Komputer dan Jaringan (TKJ)</option>
                                        <option value='RPL' <?php if ($filterJurusan == "RPL") {echo "selected";}?> >Rekayasa Perangkat Lunak</option>
                                    </select>
                                    <!-- <?= $filterJurusan ?> -->
                                </form>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class=" p-1">
                                    <table class="table">
                                        <thead>
                                            <tr class="user-select-none">
                                                <th scope="col">#</th>
                                                <th scope="col">NISN</th>
                                                <th scope="col">Nama Siswa</th>
                                                <th scope="col">Jenis Kelamin</th>
                                                <th scope="col">Kelas</th>
                                                <th scope="col">Jurusan</th>
                                                <th scope="col">No HP siswa</th>
                                                <th scope="col">No HP wali murid</th>
                                                <th scope="col" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                            $jumlahSiswa = mysqli_num_rows($querySiswa);
                                            // echo "$jumlahSiswa";
                                            $jumlahKategori = 0;

                                            if($jumlahSiswa==0) {
                                                echo '<tr>
                                                        <td colspan=8 class="text-center">data siswa tidak tersedia</td>
                                                    </tr>';
                                            } 
                                            else {
                                                $nomor = 1;

                                                while($data=mysqli_fetch_array($querySiswa)) {
                                        ?>
                                                    <tr>
                                                            <th scope="row"> <?=$nomor?> </th>
                                                            <td><?= $data['nisn']?></td>
                                                            <td><?= $data['nama']?></td>
                                                            <td><?= $data['jenis_kelamin']?></td>
                                                            <td><?= $data['kelas']?></td>
                                                            <td><?= $data['jurusan']?></td>
                                                            <td><?= $data['no_siswa']?></td>
                                                            <td><?= $data['no_orangtua']?></td>
                                                            <td class="user-select-none text-center">
                                                                <a href="./?tab=edit-data-siswa&q=<?= $data['nisn'] ?>" type="button" class="btn btn-primary">Edit</a>
                                                                <a href="./?tab=delete-siswa&q=<?= $data['nisn'] ?>" onclick="return confirm('Yakin ingin menghapus data?')" type="button" class="btn btn-danger">Delete</a>
                                                                <!-- <a type="button" class="btn btn-success">Download QR</a> -->
                                                                <?php
                                                                $pathQR = "../resources/images/QRcode/".$data['nama']."-QR.png";
                                                                if (file_exists($pathQR)) {
                                                                    // Tampilkan download button
                                                                    ?>
                                                                    <a class="btn btn-success" href="../resources/images/QRcode/<?= $data['nama'] ?>-QR.png" download="<?= $data['nama'].'_'.$data['kelas'].'-'.$data['jurusan'].'.png' ?>" > download QR </a>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-placement="top" title="mohon generate QR terlebih dahulu">
                                                                        <a class="btn btn-success disabled" > download QR </a>
                                                                    </span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                        <?php
                                                $nomor++;
                                                };
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- table -->
                    </div>
                </div>
                <!-- box data end -->
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
</script>

</html>