<?php

date_default_timezone_set('Asia/Bangkok');
require "../../private/function/db_init.php";

$todayDate = date('Y') . '-' . date('m') . '-' . date('d');
$telat = date('Hi') > 705;

$queryConfig = mysqli_query($con, "SELECT * FROM config WHERE id='1'");
$data = mysqli_fetch_array($queryConfig);
$pesanHadir = $data['pesan_hadir'];
$pesanPulang = $data['pesan_pulang'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pesanHadir = $_POST['pesanHadir'];
    $pesanPulang = $_POST['pesanPulang'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Attendance - kelola pesan</title>
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

        .shows {
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

            .shows {
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
                -ms-overflow-style: block;
                /* IE and Edge */
                scrollbar-width: block;
                /* Firefox */
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
    <style>
        .chat-bubble {
        background-color: #333;
        color: white;
        border-radius: 15px;
        padding: 10px 15px;
        display: inline-block;
        position: relative;
        max-width: 70%;
        }
        
        .chat-bubble::after {
        content: '';
        position: absolute;
        top: 0;
        right: 10px;
        border-width: 10px;
        border-style: solid;
        border-color: #333 transparent transparent transparent;
        }
        
        .chat-time {
        display: block;
        font-size: 0.8em;
        color: #b0b0b0;
        text-align: right;
        }
        
        .chat-container {
        margin: 20px;
        }
    </style>
</head>

<body id="body-pd" class="bg-light">
    <?php require "navbar.php"; ?>

    <!--Container Main start-->
    <div class="container-fluid">
        <div class="row">
            <div id="refresh" hidden></div>

            <div class="col-12 col-lg-8 mb-4 mt-2">
                <div class="shadow-sm rounded bg-white overflow-scroll hide-scrollbar">
                    <div class="container-fluid mt-3">
                        <h4 class="fw-bold mb-3 fs-3">Kelola Pesan</h4>
                        <p class="fw-light"></p>

                        <div class="row mb-2">

                            <div class="col-12">
                                <form id="notificationForm" method="post">

                                    <label for="input" class="form-label mt-1"><b>Pesan Absen Masuk</b></label>
                                    <textarea name="pesanHadir" class="form-control mb-2" id="inputHadir" form="notificationForm"><?= $pesanHadir ?></textarea>
                                    <label for="input" class="form-label mt-2"><b>Tampilan absen Masuk</b></label>
                                    <div class="preview-chat mb-4">
                                        <div class="chat-bubble">
                                            <p class="fs-6" id="pesan-masuk"><?php echo str_replace("{nama_siswa}", "Nur Khoiriah Sitompul", $pesanHadir)?></p>
                                            <span class="chat-time">05.23</span>
                                        </div>
                                    </div>

                                    <label for="input" class="form-label mt-4"><b>Pesan Absen Pulang</b></label>
                                    <textarea name="pesanPulang" class="form-control mb-2" id="inputPulang" form="notificationForm"><?= $pesanPulang ?></textarea>
                                    <label for="input" class="form-label mt-2"><b>Tampilan absen Pulang</b></label>
                                    <div class="preview-chat mb-3">
                                        <div class="chat-bubble">
                                            <p class="fs-6" id="pesan-pulang"><?php echo str_replace("{nama_siswa}", "Nur Khoiriah Sitompul", $pesanPulang)?></p>
                                            <span class="chat-time">07.13</span>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-3" name="submitForm">Simpan</button>
                                    <a href="./" type="button" class="btn btn-light border mb-3 user-select-none">kembali</a>
                                </form>

                                <?php
                                if (isset($_POST['submitForm'])) {
                                    $pesanHadir = $_POST['pesanHadir'];
                                    $pesanPulang = $_POST['pesanPulang'];

                                    $querySimpan = mysqli_query($con, "UPDATE config SET `pesan_hadir`='$pesanHadir', `pesan_pulang`='$pesanPulang'");
                                    if($querySimpan){
                                        ?>
                                        <div class="alert alert-success mt-3" role="alert">
                                            Data berhasil diperbarui.
                                        </div>
                                        <?php
            
                                    }
                                    else{
                                        echo mysqli_error($con);
                                    }
                                }
                                ?>

                            </div>

                        </div>

                    </div>
                    
                </div>
            </div>
            <div class="col-lg-3 col-xl-4">
                <h3 class="mt-2"><b>Tips</b></h3>
                <ul class="pl-3">
                    <li>gunakan "{nama_siswa}" untuk menyebutkan nama siswa di notifikasi whatsapp</li>
                    <li>nama siswa yang muncul pada tampilan hanya sebagai contoh</li>
                </ul>
            </div>

        </div>

    </div>

    <?php

    function cekData($nisn)
    {
        global $con;
        $queryCekSiswa = mysqli_query($con, "SELECT * FROM siswa WHERE nisn='$nisn'");
        $result = mysqli_num_rows($queryCekSiswa);

        if ($result > 0) {
            return true; // jika data ditemukan
        } else {
            return false;
        }
    }

    function kehadiran($kehadiran): array
    {
        $text = '';
        $color = '';
        switch ($kehadiran) {
            case 1:
                $color = 'success';
                $text = 'Hadir';
                break;
            case 2:
                $color = 'warning';
                $text = 'Sakit';
                break;
            case 3:
                $color = 'info';
                $text = 'Izin';
                break;
            case 4:
                $color = 'danger';
                $text = 'Tanpa keterangan';
                break;
            case 0:
            default:
                $color = 'disabled';
                $text = 'Belum tersedia';
                break;
        }

        return ['color' => $color, 'text' => $text];
    }
    ?>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {

        const showNavbar = (toggleId, navId, bodyId, headerId) => {
            const toggle = document.getElementById(toggleId),
                nav = document.getElementById(navId),
                bodypd = document.getElementById(bodyId),
                headerpd = document.getElementById(headerId)

            // Validate that all variables exist
            if (toggle && nav && bodypd && headerpd) {
                toggle.addEventListener('click', () => {
                    // show navbar
                    nav.classList.toggle('shows')
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

    const inputHadir = document.getElementById('inputHadir');
    const displayHadir = document.getElementById('pesan-masuk');
    const inputPulang = document.getElementById('inputPulang');
    const displayPulang = document.getElementById('pesan-pulang');
    let timeoutId;

    inputHadir.addEventListener('input', () => {
        clearTimeout(timeoutId); // Hentikan timeout sebelumnya jika ada
        timeoutId = setTimeout(() => {
            let result = inputHadir.value.replace(/{nama_siswa}/g, "Nur Khoiriah Sitompul");
            displayHadir.textContent = result; // Tampilkan isi input
        }, 200); // 500 ms
    });

    inputPulang.addEventListener('input', () => {
        clearTimeout(timeoutId); // Hentikan timeout sebelumnya jika ada
        timeoutId = setTimeout(() => {
            let result = inputPulang.value.replace(/{nama_siswa}/g, "Nur Khoiriah Sitompul");
            displayPulang.textContent = result; // Tampilkan isi input
        }, 200); // 500 ms
    });
</script>

</html>