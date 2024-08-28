<?php
    date_default_timezone_set('Asia/Bangkok');

    require "../../private/function/db_init.php";

    $querySiswa = mysqli_query($con, "SELECT * FROM siswa");
    $jumlahSiswa = mysqli_num_rows($querySiswa);

    $todayDate = date('Y').'-'.date('m').'-'.date('d');
    $queryKehadiran = mysqli_query($con, "SELECT * FROM absen WHERE tgl='$todayDate' AND kehadiran > 0 AND kehadiran < 4 ");
    $jumlahKehadiran = mysqli_num_rows($queryKehadiran)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Attendance - Dashboard</title>
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
            --z-fixed: 100;
        }

        *,
        ::before,
        ::after {
            box-sizing: border-box;
        }

        body {
            position: relative;
            margin: var(--header-height) 0 0 0;
            padding: 0 1rem;
            font-family: var(--body-font);
            font-size: var(--normal-font-size);
            transition: .5s;
        }

        a {
            text-decoration: none;
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
            transition: .5s;
        }

        .header_toggle {
            color: var(--first-color);
            font-size: 1.5rem;
            cursor: pointer;
        }

        .header_img {
            width: 35px;
            height: 35px;
            display: flex;
            justify-content: center;
            border-radius: 50%;
            overflow: hidden;
        }

        .header_img img {
            width: 40px;
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
            z-index: var(--z-fixed);
        }

        .nav {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        .nav_logo,
        .nav_link {
            display: grid;
            grid-template-columns: max-content max-content;
            align-items: center;
            column-gap: 1rem;
            padding: .5rem 0 .5rem 1.5rem;
        }

        .nav_logo {
            margin-bottom: 2rem;
        }

        .nav_logo-icon {
            font-size: 1.25rem;
            color: var(--white-color);
        }

        .nav_logo-name {
            color: var(--white-color);
            font-weight: 700;
        }

        .nav_link {
            position: relative;
            color: var(--first-color-light);
            margin-bottom: 1.5rem;
            transition: .3s;
        }

        .nav_link:hover {
            color: var(--white-color);
        }

        .nav_icon {
            font-size: 1.25rem;
        }

        .show {
            left: 0;
        }

        .body-pd {
            padding-left: calc(var(--nav-width) + 1rem);
        }

        .active {
            color: var(--white-color);
        }

        .active::before {
            content: '';
            position: absolute;
            left: 0;
            width: 2px;
            height: 32px;
            background-color: var(--white-color);
        }

        .height-100 {
            height: 100vh;
        }

        .card {
            width: 100%;
            margin: 10px 0;
            /* Adjust margin for spacing */
            border-color: white;
            overflow: hidden;
            /* Prevent overflow within card */
        }

        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .card-title {
            font-weight: bolder;
            font-size: 1.5rem;
            /* Adjust font size for better readability */
            color: #fff;
        }

        .card-subtitle {
            color: #f6f6f6;
            font-size: 1rem;
            /* Adjust font size for better readability */
        }

        .total-siswa {
            background-color: #19a7ff;
        }

        .total-siswa-icon {
            width: 80px;
            /* Adjust icon size for better fit */
            height: 80px;
        }

        .total-absen {
            background-color: #50C878;
        }

        .total-absen-icon {
            width: 80px;
            /* Adjust icon size for better fit */
            height: 80px;
        }

        .scan-barcode {
            background-color: #FFBF00;
        }

        .scan-barcode-icon {
            width: 80px;
            /* Adjust icon size for better fit */
            height: 80px;
        }

        @media (min-width: 768px) {
            body {
                margin: calc(var(--header-height) + 1rem) 0 0 0;
                padding-left: calc(var(--nav-width) + 2rem);
            }

            .header {
                height: calc(var(--header-height) + 1rem);
                padding: 0 2rem 0 calc(var(--nav-width) + 2rem);
            }

            .header_img {
                width: 40px;
                height: 40px;
            }

            .header_img img {
                width: 45px;
            }

            .l-navbar {
                left: 0;
                padding: 1rem 1rem 0 0;
            }

            .show {
                width: calc(var(--nav-width) + 156px);
            }

            .body-pd {
                padding-left: calc(var(--nav-width) + 188px);
            }
        }

        @media (max-width: 1024px) {
            .card {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .card {
                width: 100%;
            }
        }
    </style>
</head>

<body id="body-pd" class="bg-light">
    <?php require "../../private/template/guru-dashboard/navbar.php"; ?>

    <!--Container Main start-->
    <div class="container-fluid text-center">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col">
                <div class="card" style="user-select: none;">
                    <a href="?tab=data-siswa">
                        <div class="card-body total-siswa">
                            <svg xmlns="http://www.w3.org/2000/svg" class="total-siswa-icon" viewBox="0 0 24 24"
                                style="fill: rgba(255, 255, 255, 1);">
                                <path
                                    d="M9.5 12c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm1.5 1H8c-3.309 0-6 2.691-6 6v1h15v-1c0-3.309-2.691-6-6-6z">
                                </path>
                                <path
                                    d="M16.604 11.048a5.67 5.67 0 0 0 .751-3.44c-.179-1.784-1.175-3.361-2.803-4.44l-1.105 1.666c1.119.742 1.8 1.799 1.918 2.974a3.693 3.693 0 0 1-1.072 2.986l-1.192 1.192 1.618.475C18.951 13.701 19 17.957 19 18h2c0-1.789-.956-5.285-4.396-6.952z">
                                </path>
                            </svg>
                            <h5 class="card-title">Jumlah siswa</h5>
                            <h6 class="card-subtitle mb-2"><?= $jumlahSiswa ?> siswa</h6>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="card" style="user-select: none;">
                    <a href="?tab=absensi-siswa">
                        <div class="card-body total-absen">
                            <svg xmlns="http://www.w3.org/2000/svg" class="total-absen-icon" viewBox="0 0 24 24"
                                style="fill: rgba(255, 255, 255, 1);">
                                <path
                                    d="M8 12.052c1.995 0 3.5-1.505 3.5-3.5s-1.505-3.5-3.5-3.5-3.5 1.505-3.5 3.5 1.505 3.5 3.5 3.5zM9 13H7c-2.757 0-5 2.243-5 5v1h12v-1c0-2.757-2.243-5-5-5zm11.294-4.708-4.3 4.292-1.292-1.292-1.414 1.414 2.706 2.704 5.712-5.702z">
                                </path>
                            </svg>
                            <h5 class="card-title">Absensi</h5>
                            <h6 class="card-subtitle mb-2"><?= $jumlahKehadiran ?> / <?= $jumlahSiswa ?> siswa sudah absen</h6>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="card" style="user-select: none;">
                    <a href="?tab=scan-barcode">
                        <div class="card-body scan-barcode" onclick="click()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="scan-barcode-icon" viewBox="0 0 24 24"
                                style="fill: rgba(255, 255, 255, 1);">
                                <path
                                    d="M4 4h4.01V2H2v6h2V4zm0 12H2v6h6.01v-2H4v-4zm16 4h-4v2h6v-6h-2v4zM16 4h4v4h2V2h-6v2z">
                                </path>
                                <path
                                    d="M5 11h6V5H5zm2-4h2v2H7zM5 19h6v-6H5zm2-4h2v2H7zM19 5h-6v6h6zm-2 4h-2V7h2zm-3.99 4h2v2h-2zm2 2h2v2h-2zm2 2h2v2h-2zm0-4h2v2h-2z">
                                </path>
                            </svg>
                            <h5 class="card-title">Scan kode</h5>
                            <h6 class="card-subtitle mb-2">Absen hadir / pulang</h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
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

            /*===== LINK ACTIVE =====*/
            // const linkColor = document.querySelectorAll('.nav_link')

            // function colorLink() {
            //     if (linkColor) {
            //         linkColor.forEach(l => l.classList.remove('active'))
            //         this.classList.add('active')
            //     }
            // }
            // linkColor.forEach(l => l.addEventListener('click', colorLink))

            // Your code to run since DOM is loaded and ready
        });
    </script>
</body>

</html>