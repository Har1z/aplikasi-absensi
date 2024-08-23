<?php

date_default_timezone_set('Asia/Bangkok');
require "../../private/function/db_init.php";

require_once('../../library/ultra-msg/ultramsg.class.php'); // if you download ultramsg.class.php
require_once('../../library/ultra-msg/ultramsg-2.class.php'); // if you download ultramsg.class.php
    
$token="rw70t1qrzrhqs9fc"; // Ultramsg.com token
$instance_id="instance92651"; // Ultramsg.com instance id
$client = new UltraMsg\WhatsAppApi($token,$instance_id);

$token_2="zuk4oh7usbxn4t7i"; // Ultramsg.com token
$instance_id_2="instance92836"; // Ultramsg.com instance id
$client_2 = new UltraMsgs\WhatsAppApi($token_2,$instance_id_2);

$todayDate = date('Y').'-'.date('m').'-'.date('d');
$telat = date('Hi') > 705;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Attendance - absen manual</title>
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
</head>

<body id="body-pd" class="bg-light">
    <?php require "navbar.php"; ?>

    <!--Container Main start-->
    <div class="container-fluid">
        <div class="row">
            <div id="refresh" hidden></div>

            <div class="col-12 col-lg-4 mb-4 mt-2">
                <div class="shadow-sm rounded bg-white overflow-scroll hide-scrollbar">
                    <div class="container-fluid mt-3">
                        <h4 class="fw-bold mb-3">Absen manual</h4>
                        <p class="fw-light"></p>
                        
                        <div class="row mb-2">

                            <div class="col-12">
                            <form id="absenform" action="" method="post">

                                <label for="inputNisn" class="form-label mt-3"><b>NISN</b></label>
                                <input type="text" name="nisn" id="inputNisn" class="form-control mb-3" required placeholder="NISN">

                                <label for="absenInput" class="form-label"><b>Absen</b></label>
                                <select class="form-select mb-3" aria-label="Default select example" id="absenInput" name="waktu" >
                                    <option value="masuk">Masuk</option>
                                    <option value="pulang">Pulang</option>
                                </select>
                                
                                <!-- <label class="form-label"><b>Kehadiran</b></label>
                                <?php
                                for($i = 1; $i <=3; $i++) {
                                    $kehadiran = kehadiran($i)
                                    ?>
                                    <div class="row">
                                        <div class="col-auto pr-1 pt-1">
                                            <input class="form-check" type="radio" name="kehadiran" id="k-<?= $i ?>" value="<?= $i ?>" >
                                        </div>
                                        <div class="col">
                                            <label class="form-check-label pl-0" for="k-<?= $i ?>">
                                                <h6 class="text-<?= $kehadiran['color']; ?>"><?= $kehadiran['text']; ?></h6>
                                            </label>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?> -->

                                <label for="inputKet" class="form-label mt-2"><b>Keterangan (opsional)</b></label>
                                <input type="text" name="keterangan" id="inputKet" class="form-control mb-4">

                                <button type="submit" class="btn btn-primary mb-3" name="submitForm">Kirim</button>
                                <a href="./?tab=absensi-siswa" type="button" class="btn btn-light border mb-3 user-select-none">cancel</a>
                            </form>

                            <?php
                                if (isset($_POST['submitForm'])) {

                                    $nisn = $_POST['nisn'];
                                    $waktu = $_POST['waktu'];
                                    $time = date('His');
                                    if (isset($_POST['keterangan'])) {
                                        $keterangan = $_POST['keterangan'];
                                    } else {
                                        $keterangan = "";
                                    }

                                    if (cekData($nisn)) {

                                        switch ($waktu){
                                            case 'masuk':
                                                $cekAbsen = mysqli_query($con, "SELECT * FROM absen WHERE nisn='$nisn' AND tgl='$todayDate'");
                                                $sudahHadir = mysqli_query($con, "SELECT * FROM absen WHERE nisn='$nisn' AND tgl='$todayDate' AND absen_masuk IS NOT NULL");

                                                if (mysqli_num_rows($sudahHadir) != 0) {
                                                    ?>
                                                    <div class="alert alert-info mt-3" role="alert">
                                                        siswa tersebut sudah absen hari ini.
                                                    </div>
                                                    <?php
                                                    break;
                                                }

                                                if ($telat && $keterangan == ""){
                                                    if (mysqli_num_rows($cekAbsen) == 0) {
                                                        $queryCreateAbsensi = mysqli_query($con, "INSERT INTO absen (`nisn`, `tgl`, `kehadiran`, `absen_masuk`, `ket`) VALUES ('$nisn','$todayDate','1','$time','terlambat datang')");
                                                        ?>
                                                        <div class="alert alert-success mt-3" role="alert">
                                                            berhasil absen siswa dengan nisn: <?= $nisn ?>.
                                                        </div>
                                                        <?php
                                
                                                        // send messages
                                                        // $nomor = "+62" . substr($data['no_orangtua'], 1);
                                                        $to="+6281284612453"; // change to $nomor and un-comment code above
                                                        $body="Anak anda ".$data['nama']." sudah sampai disekolah"; 
                                                        // $api=$client->sendChatMessage($to,$body);
                                                        break;
                                                    } else if (mysqli_num_rows($cekAbsen) == 1) {
                                                        $queryUpdateAbsensi = mysqli_query($con, "UPDATE absen SET kehadiran='1', absen_masuk='$time', ket='terlambat datang' WHERE nisn='$nisn' AND tgl='$todayDate'");
                                                        ?>
                                                        <div class="alert alert-success mt-3" role="alert">
                                                            berhasil absen siswa dengan nisn: <?= $nisn ?>.
                                                        </div>
                                                        <?php
                                
                                                        // send messages
                                                        // $nomor = "+62" . substr($data['no_orangtua'], 1);
                                                        $to="+6281284612453"; // change to $nomor and un-comment code above
                                                        $body="Anak anda ".$data['nama']." sudah sampai disekolah"; 
                                                        // $api=$client->sendChatMessage($to,$body);
                                                        break;
                                                    }
                                                }

                                                if (mysqli_num_rows($cekAbsen) == 0) {
                                                    $queryCreateAbsensi = mysqli_query($con, "INSERT INTO absen (`nisn`, `tgl`, `kehadiran`, `absen_masuk`) VALUES ('$nisn','$todayDate','1','$time')");
                                                    ?>
                                                    <div class="alert alert-success mt-3" role="alert">
                                                        berhasil absen siswa dengan nisn: <?= $nisn ?>.
                                                    </div>
                                                    <?php
                                
                                                    // send messages
                                                    // $nomor = "+62" . substr($data['no_orangtua'], 1);
                                                    $to="+6281284612453"; // change to $nomor and un-comment code above
                                                    $body="Anak anda ".$data['nama']." sudah sampai disekolah"; 
                                                    // $api=$client->sendChatMessage($to,$body);
                                                } else {
                                                    $queryUpdateAbsensi = mysqli_query($con, "UPDATE absen SET kehadiran='1', absen_masuk='$time' WHERE nisn='$nisn' AND tgl='$todayDate'");
                                                    ?>
                                                    <div class="alert alert-success mt-3" role="alert">
                                                        berhasil absen siswa dengan nisn: <?= $nisn ?>.
                                                    </div>
                                                    <?php
                                
                                                    // send messages
                                                    // $nomor = "+62" . substr($data['no_orangtua'], 1);
                                                    $to="+6281284612453"; // change to $nomor and un-comment code above
                                                    $body="Anak anda ".$data['nama']." sudah sampai disekolah"; 
                                                    // $api=$client->sendChatMessage($to,$body);
                                                }
                                                break;
                                            
                                            case 'pulang':
                                                $cekAbsen = mysqli_query($con, "SELECT * FROM absen WHERE nisn='$nisn' AND tgl='$todayDate'");
                                                $belumHadir = mysqli_query($con, "SELECT * FROM absen WHERE nisn='$nisn' AND tgl='$todayDate' AND absen_masuk IS NOT NULL");
                                                $sudahPulang = mysqli_query($con, "SELECT * FROM absen WHERE nisn='$nisn' AND tgl='$todayDate' AND absen_masuk IS NOT NULL AND absen_pulang IS NOT NULL");

                                                if (mysqli_num_rows($belumHadir) != 1) {
                                                    ?>
                                                    <div class="alert alert-warning mt-3" role="alert">
                                                        siswa dengan nisn: <?= $nisn ?> belum melakukan absen hari ini.
                                                    </div>
                                                    <?php
                                                    break;
                                                }

                                                if (mysqli_num_rows($sudahPulang) != 0) {
                                                    ?>
                                                    <div class="alert alert-warning mt-3" role="alert">
                                                        siswa dengan nisn: <?= $nisn ?> sudah melakukan absen pulang.
                                                    </div>
                                                    <?php
                                                } else if (mysqli_num_rows($sudahPulang) == 0) {
                                                    $queryUpdateAbsensi = mysqli_query($con, "UPDATE absen SET absen_pulang='$time' WHERE nisn='$nisn' AND tgl='$todayDate'");
                                                    ?>
                                                    <div class="alert alert-success mt-3" role="alert">
                                                        berhasil absen pulang siswa dengan nisn: <?= $nisn ?>.
                                                    </div>
                                                    <?php

                                                    // send messages
                                                    // $nomor = "+62" . substr($data['no_orangtua'], 1);
                                                    $to="+6281284612453"; // change to $nomor and un-comment code above
                                                    $body="Anak anda ".$data['nama']." sudah pulang dari sekolah"; 
                                                    // $api=$client_2->sendChatMessage($to,$body);
                                                } else {
                                                    ?>
                                                    <div class="alert alert-warning mt-3" role="alert">
                                                        terjadi kesalahan pada server.
                                                    </div>
                                                    <?php
                                                }
                                                break;
                                        }

                                    } else {
                                        ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            siswa dengan nisn tersebut tidak terdaftar.
                                        </div>
                                        <?php
                                    }
                                }
                            ?>

                            </div>
                            
                        </div>

                    </div>
                </div>
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
</script>

</html>