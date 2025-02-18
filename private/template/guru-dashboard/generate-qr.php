<?php

    require "../../private/function/db_init.php";

    $querySiswa = mysqli_query($con, "SELECT * FROM siswa");
    $jumlahSiswa = mysqli_num_rows($querySiswa);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Attendance - generate qr</title>
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
    <div id="refresh"></div>
    <?php require "navbar.php"; ?>

    <!--Container Main start-->
    <div class="container-fluid">
        <div class="row">


            <div class="col-12 mb-2">
                <div>
                    <h4 class="fw-bold mb-1">GENERATE QR</h4>
                    <p class="text-muted" >note: jika terjadi masalah saat mendownload QR mohon tekan "Generate" terlebih dahulu</p>
                </div>
            </div>

            <div class="col-12 mb-4">
                <!-- box data -->
                <div class="shadow-sm rounded bg-white overflow-scroll hide-scrollbar">
                    <div class="container-fluid">
                        <!-- table -->
                        <div class="row">

                            <div class="col-12 col-lg-6 mb-2 mt-4">
                                <div class="p-4 border border-light shadow-sm rounded">
                                    <h4 class="text-primary mb-2"><b>Data Siswa</b></h4>
                                    <p class="mb-0">Total jumlah siswa : <b><?= $jumlahSiswa ?></b></p>
                                    <a href="./?tab=data-siswa">Lihat data</a><br>
                                    <button class="btn btn-primary mt-3" type="button" id="generateButton" onclick="generate()" > Generate All </button>
                                    <button class="btn btn-primary mt-3" type="button" id="loadingButton" disabled hidden>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                    <?php
                                        $filename = "../resources/images/QRcode/QR-zip/QR_code.zip";

                                        if (file_exists($filename)) {
                                            ?>
                                                <a class="btn btn-success mt-3" href="../resources/images/QRcode/QR-zip/QR_code.zip" download="QR_code_all.zip" > Download All </a>  
                                            <?php
                                        }else {
                                            ?>
                                                <a class="btn btn-success disabled mt-3" href="../resources/images/QRcode/QR-zip/QR_code.zip" download="QR_code_all.zip" title="Mohon tekan tombol Generate all terlebih dahulu"> Download All </a>  
                                            <?php
                                        }
                                        ?>
                                </div>
                            </div>

                            <!-- JUJUR NGEJAR DEADLINE JADI FITUR DOWNLOAD PERKELAS DI CANCEL DULU :) -->
                            <!-- SAYA NGERJAIN PROJEK INI SENDIRI BTW DI TAHUN SAYA SKLH 2022/2024 ITU GURU RPL BLM ADA YG BENER BENER BISA NGAJAR -->
                            
                            <!-- <div class="col-6 mb-2 mt-4">
                                <div class="p-4 border border-light shadow-sm rounded">
                                    <h4 class="text-primary mb-2"><b>Generate per kelas</b></h4>
                                    <form action="" id="filterKelas">
                                        <select name="kelas" id="kelas" class="form-select" onchange="cekKelas()">
                                            <option value="0">--Pilih kelas--</option>
                                            <option value="10">10 (Sepuluh)</option>
                                            <option value="11">11 (Sebelas)</option>
                                            <option value="12">12 (Dua belas)</option>
                                        </select>
                                    </form>
                                    <button class="btn btn-primary mt-4" id="generatePerKelas" onclick="generatePerKelas()" disabled> Generate per kelas </button>
                                    <button class="btn btn-primary mt-4" type="button" id="loadingButton2" disabled hidden>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                    <a class="btn btn-success mt-4"> Download per kelas </a>
                                </div>
                            </div> -->

                            <div class="col-12">
                                <div class=" p-1">
                                    <p class="text-muted">*anda dapat membuat QR secara manual dengan aplikasi lain dengan NISN siswa sebagai isi dari QR code</p>
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
    });

    function generate() {
        $('#generateButton').attr("hidden", true);
        $("#loadingButton").removeAttr("hidden");
        jQuery.ajax({
            url: "./?tab=create-qr",
            type: 'post',
            data: {
                'create': "generate"
            },
            success: function(response, status, xhr) {
                // console.log(response);
                $('#refresh').html(response);
            },
            error: function(xhr, status, thrown) {
                console.log(thrown);
            }
        });
    }

    function generatePerKelas() {
        $('#generatePerKelas').attr("hidden", true);
        $("#loadingButton2").removeAttr("hidden");
        var form = $('#filterKelas').serializeArray()

        jQuery.ajax({
            url: "./?tab=create-qr",
            type: 'post',
            data: {
                'create': "generate",
                'kelas': form[0]['value']
            },
            success: function(response, status, xhr) {
                // console.log(response);
                $('#refresh').html(response);
            },
            error: function(xhr, status, thrown) {
                console.log(thrown);
            }
        });
    }

    function unduh() {

        jQuery.ajax({
            url: "./?tab=create-qr",
            type: 'post',
            data: {
                'download': "donlod"
            },
            success: function(response, status, xhr) {
                // console.log(response);
                // $('#refresh').html(response);
            },
            error: function(xhr, status, thrown) {
                console.log(thrown);
            }
        });
    }

    function cekKelas() {
        var form = $('#filterKelas').serializeArray()

        console.log("kelas : ",form[0]['value'])

        var selectedKelas = $("#kelas").val();
        
        if (selectedKelas !== "0") {
            // Aktifkan tombol jika kelas dipilih
            $("#generatePerKelas").prop("disabled", false);
        } else {
            // Nonaktifkan tombol jika belum ada kelas yang dipilih
            $("#generatePerKelas").prop("disabled", true);
        }
    }

</script>

</html>