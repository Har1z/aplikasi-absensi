<?php

    require "../../private/function/session.php";
    // CHECK FOR PARAMETER
    if (isset($_GET['tab'])) {
        // URL parameter exists
        $url = $_GET['tab'];
    } else {
        // URL parameter does not exist
        $url = "";
    }

    $dashboard = "";
    $dataSiswa = "";
    $absensiSiswa = "";
    $dataGuru = "";
    $generateQr = "";
    $laporan = "";

    switch ($url) {
        case "absensi-siswa":
            $absensiSiswa = "active";
            require "../../private/template/guru-dashboard/absensi-siswa.php";
            // echo "absensi siswa";
            break;

        case "edit-absensi-modal":
            $absensiSiswa = "active";
            // require "../../private/template/guru-dashboard/absensi-siswa.php";
            require "../../private/template/guru-dashboard/absensi-siswa-edit-modal.php";
            break;

        case "edit-absensi":
            $absensiSiswa = "active";
            require "../../private/template/guru-dashboard/absensi-siswa-edit.php";
            break;

        case "data-siswa":
            $dataSiswa = "active";
            require "../../private/template/guru-dashboard/data-siswa.php";
            break;

        case "tambah-data-siswa":
            $dataSiswa = "active";
            require "../../private/template/guru-dashboard/data-siswa-add.php";
            break;

        case "edit-data-siswa":
            $dataSiswa = "active";
            require "../../private/template/guru-dashboard/data-siswa-edit.php";
            break;

        case "delete-siswa":
            $dataSiswa = "active";
            require "../../private/template/guru-dashboard/data-siswa-delete.php";
            break;

        case "data-guru":
            $dataGuru = "active";
            require "../../private/template/guru-dashboard/data-guru.php";
            break;

        case "tambah-data-guru":
            $dataGuru = "active";
            require "../../private/template/guru-dashboard/data-guru-add.php";
            break;

        case "edit-data-guru":
            $dataGuru = "active";
            require "../../private/template/guru-dashboard/data-guru-edit.php";
            break;

        case "delete-guru":
            $dataGuru = "active";
            require "../../private/template/guru-dashboard/data-guru-delete.php";
            break;
        
        case "generate-qr":
            $generateQr = "active";
            require "../../private/template/guru-dashboard/generate-qr.php";
            break;
        
        case "create-qr":
            $generateQr = "active";
            require "../../private/function/generate-qr.php";
            break;

        case "laporan":
            $laporan = "active";
            require "../../private/template/guru-dashboard/laporan-absensi.php";
            break;

        case "generate-laporan":
            $laporan = "active";
            require "../../private/function/generate-laporan.php";
            break;
        
        case "scan-barcode":
            require "../../private/template/guru-dashboard/scan-auto.php";
            break;
        
        case "absen-manual":
            $absensiSiswa = "active";
            require "../../private/template/guru-dashboard/absen-manual.php";
            break;
        
        case "kelola-pesan":
            $dashboard = "active";
            require "../../private/template/guru-dashboard/kelola-pesan.php";
            break;

        default:
            $dashboard = "active";
            require "../../private/template/guru-dashboard/dashboard.php";
            break;
    }
?>