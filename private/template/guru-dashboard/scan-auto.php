<?php
require "../../private/function/time.php";

// CHECK FOR PARAMETER
if (isset($_GET['absen'])) {
    // URL parameter exists
    $abs = $_GET['absen'];
} else {
    // URL parameter does not exist
    $abs = "";
}

if ($abs == "masuk") {
    $waktu = "Masuk";
} else if ($abs == "pulang") {
    $waktu = "Pulang";
}

$waktu == 'Masuk' ? $oppBtn = 'pulang' : $oppBtn = 'masuk';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Attendance - absen <?= $waktu; ?></title>
    <link rel="icon" type="image/png" href="../resources/images/logo.png">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body style="background-color: lightgrey;">
    <div style="height:80px; position: relative;">
        <a href="./" type="button" class="btn btn-secondary"
            style="user-select: none; position: absolute; top: 50%; right: 4%; transform: translateY(-50%);"><span
                class=""><i class='bx bx-grid-alt nav_icon'></i> Dashboard </span></a>
    </div>
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <div class="row mx-auto">
                    <div class="col-lg-3 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="mt-2"><b>Tips</b></h3>
                                <ul class="pl-3">
                                    <li>Tunjukkan qr code sampai terlihat jelas di kamera</li>
                                    <li>Posisikan qr code tidak terlalu jauh maupun terlalu dekat</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4">
                        <div class="card">
                            <div class="col-10 mx-auto card-header card-header-primary rounded-lg"
                                style="margin-top:10px;">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="card-title"><b>Absen <?= $waktu; ?></b></h4>
                                        <p class="card-category">Silahkan tunjukkan QR Code anda</p>
                                    </div>
                                    <div class="col-md-auto">
                                        <a href="?tab=scan-barcode&absen=<?= $oppBtn; ?>"
                                            class="btn btn-<?= $oppBtn == 'masuk' ? 'success' : 'warning'; ?>">
                                            Absen <?= $oppBtn; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body my-auto px-5">


                                <br>

                                <div class="row">
                                    <div class="col-sm-12 mx-auto">
                                        <div class="previewParent">
                                            <div class="text-center">
                                                <h4 class="d-none w-100" id="searching"><b>Mencari...</b></h4>
                                            </div>
                                            <div id="previewKamera" height="300px" width="300px"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="hasilScan"></div>
                                <br>

                                <h4 class="d-inline">Pilih kamera</h4>

                                <select id="pilihKamera" class="custom-select w-50 ml-2"
                                    aria-label="Default select example" style="height: 35px;">
                                    <option selected>Select camera devices</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="mt-2"><b>Penggunaan</b></h3>
                                <ul class="pl-3">
                                    <li>Jika berhasil scan maka akan muncul data siswa/guru dibawah preview kamera</li>
                                    <li>Klik tombol <b><span class="text-success">Absen masuk</span> / <span
                                                class="text-warning">Absen pulang</span></b> untuk mengubah waktu
                                        absensi</li>
                                    <li>Untuk melihat data absensi, klik tombol <span class="text-primary"><i
                                                class='bx bx-grid-alt nav_icon'></i> Dashboard </span></li>
                                    <li>Untuk mengakses halaman petugas anda harus login terlebih dahulu</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="../js/plugin/zxing/zxing.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const cameraSelect = document.getElementById("pilihKamera");
        

        // Fetch cameras and populate the camera selector
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                devices.forEach(device => {
                    const option = document.createElement("option");
                    option.value = device.id;
                    option.text = device.label;
                    cameraSelect.appendChild(option);
                });

                // Start scanning with the first camera by default
                $('#previewKamera').addClass('d-none');
                $('#previewParent').addClass('unpreview');
                $('#searching').removeClass('d-none');
                setTimeout(() => {
                    // startScanning(devices[1].id);
                    autoStart();
                }, 300);
            }
        }).catch(err => {
            console.error("Error getting cameras", err);
        });

        // Start scanning when a camera is selected
        cameraSelect.addEventListener("change", (event) => {
            $('#previewKamera').addClass('d-none');
            $('#previewParent').addClass('unpreview');
            $('#searching').removeClass('d-none');
            setTimeout(() => {
                startScanning(event.target.value);
            }, 300);
        });

        function startScanning(cameraId) {
            const qrCodeScanner = new Html5Qrcode("previewKamera");

            qrCodeScanner.start(
                cameraId,
                {
                    fps: 20,    // Optional, frame per seconds for qr code scanning
                    // qrbox: 250  // Optional, if you want bounded box UI
                },
                qrCodeMessage => {
                    console.log(`QR Code detected: ${qrCodeMessage}`);
                    // Handle the scanned QR code here

                    // Giving the scanner a delay between result
                    qrCodeScanner.pause();
                    // Removing unwanted "paused scanner" banner on the camera when on delay
                    document.querySelector("#previewKamera > div").removeAttribute("style");
                    document.querySelector("#previewKamera > div").innerHTML = `${qrCodeMessage}`;
                    setTimeout(() => {
                        qrCodeScanner.resume();
                    }, 2000);
                },
                errorMessage => {
                    // Parse error, ignore it
                }
            ).catch(err => {
                console.error("Unable to start scanning", err);
            });

            $('#previewParent').removeClass('unpreview');
            $('#previewKamera').removeClass('d-none');
            $('#searching').addClass('d-none');
        }

        function autoStart() {
            const html5QrCode = new Html5Qrcode("previewKamera");

            html5QrCode.start(
                { facingMode: "environment" },
                {
                    fps: 20,
                },
                qrCodeMessage => {
                    console.log(`QR Code detected: ${qrCodeMessage}`);
                    cekData(`${qrCodeMessage}`)
                    // Handle the scanned QR code here

                    // Giving the scanner a delay between result
                    html5QrCode.pause();
                    // Removing unwanted "paused scanner" banner on the camera when on delay
                    document.querySelector("#previewKamera > div").removeAttribute("style");
                    document.querySelector("#previewKamera > div").innerHTML = '';

                    setTimeout(() => {
                        html5QrCode.resume();
                    }, 2000);
                },
                errorMessage => {
                    // Parse error, ignore it
                }).catch(err => {
                    console.error("Unable to start scanning", err);
                });

            $('#previewParent').removeClass('unpreview');
            $('#previewKamera').removeClass('d-none');
            $('#searching').addClass('d-none');
        }

        async function cekData(code) {
            jQuery.ajax({
                url: "./scan/cek",
                type: 'post',
                data: {
                    'code': code,
                    'waktu': '<?= strtolower($waktu); ?>'
                },
                success: function (response, status, xhr) {
                    // console.log(response);
                    $('#hasilScan').html(response);

                    $('html, body').animate({
                        scrollTop: $("#hasilScan").offset().top
                    }, 500);
                },
                error: function (xhr, status, thrown) {
                    console.log(thrown);
                    $('#hasilScan').html(thrown);
                }
            });
        }
    </script>
</body>

</html>