<?php

date_default_timezone_set('Asia/Bangkok');
require "../../private/function/db_init.php";

if (isset($_POST['kelas'])) {
    $filterKelas = $_POST['kelas'];
    
} else {
    $filterKelas = '0';
}

$todayDate = date('Y').'-'.date('m').'-'.date('d');
$filterTanggal = $_POST['tanggal'] ?? date('Y').'-'.date('m').'-'.date('d');

switch($filterKelas){

    case '10' :
        $querySiswa = mysqli_query($con, "SELECT nisn, nama, kelas, jurusan FROM siswa WHERE kelas='10' ORDER BY nama ASC");
        break;

    case '11' :
        $querySiswa = mysqli_query($con, "SELECT nisn, nama, kelas, jurusan FROM siswa WHERE kelas='11' ORDER BY nama ASC");
        break;

    case '12' :
        $querySiswa = mysqli_query($con, "SELECT nisn, nama, kelas, jurusan FROM siswa WHERE kelas='12' ORDER BY nama ASC");
        break;

    case '0' :
    default :
        $querySiswa = mysqli_query($con, "SELECT nisn, nama, kelas, jurusan FROM siswa ORDER BY nama ASC");
        break;
    }

$telat = date('Hi') > 705;

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

            <!-- <div class="col-12 mb-2">
                <div>
                    <h4 class="fw-bold">DATA SISWA</h4>
                </div>
            </div> -->

            <div class="col-12 mb-4 mt-2">
                <div class="shadow-sm rounded bg-white overflow-scroll hide-scrollbar">
                    <div class="container-fluid mt-3">
                        <h4 class="fw-bold mb-1">Daftar Kelas</h4>
                        <p class="fw-light">Silahkan pilih kelas</p>
                        
                        <form id="filter" action="" method="post">
                        <div class="row mb-4">

                            <div class="col-12 col-lg-2 mb-2">
                                <button type="submit" id="kelas-0" class="btn <?php if ($filterKelas == '0') {echo "btn-success";} else{ echo "btn-primary"; }?> form-control" onclick="getSiswa(0);" >Semua Kelas</button>
                            </div>

                            <div class="col-12 col-lg-2 mb-2">
                                <button type="submit" id="kelas-10" class="btn <?php if ($filterKelas == '10') {echo "btn-success";} else{ echo "btn-primary"; }?> form-control" onclick="getSiswa(10);">10 (Sepuluh)</button>
                            </div>

                            <div class="col-12 col-lg-2 mb-2">
                                <button type="submit" id="kelas-11" class="btn <?php if ($filterKelas == '11') {echo "btn-success";} else{ echo "btn-primary"; }?> form-control" onclick="getSiswa(11);">11 (Sebelas)</button>
                            </div>

                            <div class="col-12 col-lg-2 mb-2">
                                <button type="submit" id="kelas-12" class="btn <?php if ($filterKelas == '12') {echo "btn-success";} else{ echo "btn-primary"; }?> form-control" onclick="getSiswa(12);">12 (Dua belas)</button>
                            </div>
                        </div>

                            <h6><b>Tanggal</b></h6>
                            <input class="form-control mb-2" style="width: 200px;" value="<?= $filterTanggal ?>" type="date"
                                name="tanggal"><!-- value = yyyy-mm-dd -->
                            <i class="fw-light fs-0 text-muted" >*mohon untuk menekan tombol refresh setelah memilih tanggal.</i>
                            <input type="text" name="kelas" id="kelasfil" value="0" hidden>
                            <!-- <?= $_POST['tanggal'] ?>
                            <?= $_POST['kelas'] ?> -->

                    </div>
                </div>
            </div>


            <div class="col-12 mb-4">
                <!-- box data -->
                <div class="shadow-sm rounded bg-white overflow-scroll hide-scrollbar">
                    <div class="container-fluid">
                        <!-- table -->
                        <div class="row">

                            <div class="col-8 col-lg-3 mb-1 mt-4">
                                <div>
                                    <h5 class="fw-bold fw-light mb-0">Absen Siswa</h5>
                                    <p>Absen siswa akan muncul disini.</p>
                                </div>
                            </div>

                            <div class="col-4 col-lg-3 pl-0 mb-1 mt-4">
                                <button type="submit" class="btn btn-primary mb-3" name="submitForm"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="1.2 1.2 24 24"
                                        style="fill: rgba(255, 255, 255, 1);"> <!-- css value expected error (so i removed = transform: ; msFilter:;) -->
                                        <path
                                            d="M10 11H7.101l.001-.009a4.956 4.956 0 0 1 .752-1.787 5.054 5.054 0 0 1 2.2-1.811c.302-.128.617-.226.938-.291a5.078 5.078 0 0 1 2.018 0 4.978 4.978 0 0 1 2.525 1.361l1.416-1.412a7.036 7.036 0 0 0-2.224-1.501 6.921 6.921 0 0 0-1.315-.408 7.079 7.079 0 0 0-2.819 0 6.94 6.94 0 0 0-1.316.409 7.04 7.04 0 0 0-3.08 2.534 6.978 6.978 0 0 0-1.054 2.505c-.028.135-.043.273-.063.41H2l4 4 4-4zm4 2h2.899l-.001.008a4.976 4.976 0 0 1-2.103 3.138 4.943 4.943 0 0 1-1.787.752 5.073 5.073 0 0 1-2.017 0 4.956 4.956 0 0 1-1.787-.752 5.072 5.072 0 0 1-.74-.61L7.05 16.95a7.032 7.032 0 0 0 2.225 1.5c.424.18.867.317 1.315.408a7.07 7.07 0 0 0 2.818 0 7.031 7.031 0 0 0 4.395-2.945 6.974 6.974 0 0 0 1.053-2.503c.027-.135.043-.273.063-.41H22l-4-4-4 4z">
                                        </path>
                                    </svg> Refresh</button>
                                </form>
                                <a href="./?tab=absen-manual" type="button" class="btn btn-primary mb-3" style="user-select: none;"><span class=""> Absen Manual </span></a>
                            </div>

                            <div class="col-12">
                                <div class=" p-1">
                                    <table class="table">
                                        <thead>
                                            <tr class="user-select-none">
                                                <th scope="col">#</th>
                                                <th scope="col">NISN</th>
                                                <th scope="col">Nama Siswa</th>
                                                <th scope="col">kelas / Jurusan</th>
                                                <th scope="col" class="text-center">Kehadiran</th>
                                                <th scope="col" class="text-center">Jam masuk</th>
                                                <th scope="col" class="text-center">Jam pulang</th>
                                                <th scope="col" class="text-center">Keterangan</th>
                                                <th scope="col" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $jumlahSiswa = mysqli_num_rows($querySiswa);
                                            // echo "$jumlahSiswa";
                                            $jumlahKategori = 0;

                                            if ($jumlahSiswa == 0) {
                                                echo '<tr>
                                                        <td colspan=8 class="text-center">data siswa tidak tersedia</td>
                                                    </tr>';
                                            } else {
                                                $nomor = 1;

                                                while ($data = mysqli_fetch_array($querySiswa)) {
                                                    
                                                    $nisn = $data['nisn'];
                                                    $queryAbsensi = mysqli_query($con, "SELECT * FROM absen WHERE nisn='$nisn' AND tgl='$filterTanggal'");
                                                    $queryPresensi = mysqli_query($con, "SELECT * FROM absen WHERE nisn='$nisn' AND tgl='$filterTanggal' AND kehadiran BETWEEN '1' AND '3'");
                                                    $presensi = mysqli_num_rows($queryPresensi);
                                                    $check = mysqli_num_rows($queryAbsensi);
                                                    $absensi = mysqli_fetch_array($queryAbsensi);
                                                    
                                                    if ($check == 0) {
                                                        $queryCreateAbsensi = mysqli_query($con, "INSERT INTO absen (`nisn`, `tgl`) VALUES ('$nisn','$filterTanggal')");
                                                        ?>
                                                        <script>
                                                            setTimeout(function() {
                                                                document.getElementById("filter").submit();
                                                            }, 1000);
                                                        </script>
                                                        <?php
                                                    }

                                                    $kehadiran = kehadiran($absensi['kehadiran'] ?? '0');

                                                    if ($telat) {
                                                        $queryTanpaKeterangan = mysqli_query($con, "UPDATE absen SET kehadiran='4' WHERE nisn='$nisn' AND kehadiran='0' AND tgl='$todayDate' ");
                                                    }

                                                    if (date('Hi') >= 1200) {
                                                        $presensi = 1;
                                                    } else if ($filterTanggal != $todayDate) {
                                                        $presensi = 1;
                                                    }

                                                    if ($presensi != 0){

                                                    ?>
                                                    <tr>
                                                        <th scope="row"> <?= $nomor ?> </th>
                                                        <td><?= $data['nisn'] ?></td>
                                                        <td><?= $data['nama'] ?></td>
                                                        <td><?= $data['kelas'] ?> / <?= $data['jurusan'] ?></td>
                                                        <td>
                                                            <p class="p-2 w-100 btn btn-<?= $kehadiran['color']; ?> text-center">
                                                                <b><?= $kehadiran['text']; ?></b>
                                                            </p>
                                                        </td>
                                                        <td class="text-center"><?= $absensi['absen_masuk'] ?? '-' ?></td>
                                                        <td class="text-center"><?= $absensi['absen_pulang'] ?? '-' ?></td>
                                                        <td class="text-center"><?= $absensi['ket'] ?? '-' ?></td>
                                                        <td class="user-select-none text-center">
                                                        <button data-bs-toggle="modal" data-bs-target="#ubahModal" onclick="getDataKehadiran('<?= $data['nisn']; ?>', '<?= $filterTanggal ?>')" class="btn btn-primary p-2" id="<?= $absensi['nisn']; ?>">Edit</button>
                                                        <button onclick="if (confirm('Yakin ingin menghapus data kehadiran?')) { hapusKehadiran('<?= $data['nisn']; ?>'); } return false;" class="btn btn-danger p-2" id="<?= $absensi['nisn']; ?>">Delete</button>
                                                        </td>
                                                    </tr>
                                                    <?php

                                                    }
                                                    $nomor++;


                                                }
                                                ;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- table -->
                        <?php
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
                    </div>
                </div>
                <!-- box data end -->
            </div>
        </div>
        
        <div class="modal fade" id="ubahModal" tabindex="-1" aria-labelledby="modalUbahKehadiran" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="modalUbahKehadiran">Ubah kehadiran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                    </div>
                    <div id="modalFormUbahSiswa"></div>
                    
                </div>
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

    function getSiswa(kelas) {
        for (let index = 0; index <= 12; index++) {
            if (index != kelas) {
                $('input[name=kelas]').val(kelas);
            }
        }
    }

    function getDataKehadiran(nisnSiswa, date) {
        jQuery.ajax({
            url: "./?tab=edit-absensi-modal",
            type: 'post',
            data: {
                'nisn_siswa': nisnSiswa,
                'date': date
            },
            success: function(response, status, xhr) {
                // console.log(status);
                $('#modalFormUbahSiswa').html(response);
            },
            error: function(xhr, status, thrown) {
                console.log(thrown);
                $('#modalFormUbahSiswa').html(thrown);
            }
        });
    }

    function ubahKehadiran() {
        var form = $('#formUbah').serializeArray()

        jQuery.ajax({
            url: "./?tab=edit-absensi",
            type: 'post',
            data: {
                'edit': true,
                'tgl': '<?= $filterTanggal ?>',
                'nisn': form[0]['value'],
                'kehadiran': form[1]['value'],
                'jam_masuk': form[2]['value'],
                'jam_pulang': form[3]['value'],
                'keterangan': form[4]['value']
            },
            success: function(response, status, xhr) {
                // console.log(status);
                alert('Berhasil ubah kehadiran');
                $('#refresh').html(response);
            },
            error: function(xhr, status, thrown) {
                console.log(thrown);
            }
        });
    }

    function hapusKehadiran(nisn) {

        jQuery.ajax({
            url: "./?tab=edit-absensi",
            type: 'post',
            data: {
                'delete': true,
                'tgl': '<?= $filterTanggal ?>',
                'nisn': nisn
            },
            success: function(response, status, xhr) {
                // console.log(status);
                alert('Data berhasil dihapus');
                $('#refresh').html(response);
            },
            error: function(xhr, status, thrown) {
                console.log(thrown);
            }
        });
    }

</script>

</html>