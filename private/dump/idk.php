<?php
require "../../private/controller/time.php";
$oppBtn = '';
$waktu == 'Masuk' ? $oppBtn = 'pulang' : $oppBtn = 'masuk';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Attendance - absen <?= $oppBtn; ?></title>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <div style="height:80px;">

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
                            <div class="col-10 mx-auto card-header card-header-primary">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="card-title"><b>Absen <?= $waktu; ?></b></h4>
                                        <p class="card-category">Silahkan tunjukkan QR Code anda</p>
                                    </div>
                                    <div class="col-md-auto">
                                        <a href="scan/<?= $oppBtn; ?>"
                                            class="btn btn-<?= $oppBtn == 'masuk' ? 'success' : 'warning'; ?>">
                                            Absen <?= $oppBtn; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body my-auto px-5">
                                <h4 class="d-inline">Pilih kamera</h4>

                                <select id="pilihKamera" class="custom-select w-50 ml-2"
                                    aria-label="Default select example" style="height: 35px;">
                                    <option selected>Select camera devices</option>
                                </select>

                                <br>

                                <div class="row">
                                    <div class="col-sm-12 mx-auto">
                                        <div class="previewParent">
                                            <div class="text-center">
                                                <h4 class="d-none w-100" id="searching"><b>Mencari...</b></h4>
                                            </div>
                                            <div id="previewKamera" style="background-color: red; color: red;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="hasilScan"></div>
                                <br>
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
                                                class="material-icons" style="font-size: 16px;">dashboard</i> Dashboard
                                            Petugas</span></li>
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
    <script type="text/javascript">
        let selectedDeviceId = null;
        const html5QrCode = new Html5Qrcode("previewKamera");
        const sourceSelect = $('#pilihKamera');

        $(document).on('change', '#pilihKamera', function () {
            selectedDeviceId = $(this).val();
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    initScanner();
                }).catch(err => console.error("Failed to stop QR Code scanner", err));
            }
        });

        const previewParent = document.getElementById('previewParent');
        const preview = document.getElementById('previewKamera');

        function initScanner() {
            Html5Qrcode.getCameras().then(cameras => {
                if (cameras.length < 1) {
                    alert("Camera not found!");
                    return;
                }

                if (selectedDeviceId == null) {
                    if (cameras.length <= 1) {
                        selectedDeviceId = cameras[0].id;
                    } else {
                        selectedDeviceId = cameras[1].id;
                    }
                }

                if (cameras.length >= 1) {
                    sourceSelect.html('');
                    cameras.forEach((camera) => {
                        const sourceOption = document.createElement('option');
                        sourceOption.text = camera.label;
                        sourceOption.value = camera.id;
                        if (camera.id == selectedDeviceId) {
                            sourceOption.selected = 'selected';
                        }
                        sourceSelect.append(sourceOption);
                    });
                }

                

                $('#previewParent').removeClass('unpreview');
                $('#previewKamera').removeClass('d-none');
                $('#searching').addClass('d-none');

                html5QrCode.start(
                    { facingMode: { exact: selectedDeviceId } },
                    {
                        fps: 10, // Optional, set the FPS for scanning
                        qrbox: 250 // Optional, set the size of scanning box
                    },
                    (decodedText, decodedResult) => {
                        console.log(decodedText);
                        cekData(decodedText);

                        $('#previewKamera').addClass('d-none');
                        $('#previewParent').addClass('unpreview');
                        $('#searching').removeClass('d-none');

                        // Stop scanning after successful scan and restart after delay
                        html5QrCode.stop().then(() => {
                            setTimeout(() => {
                                initScanner();
                            }, 2500);
                        }).catch(err => console.error("Failed to stop QR Code scanner", err));
                    },
                    (errorMessage) => {
                        console.error(errorMessage);
                    }
                ).catch(err => console.error("Failed to start QR Code scanner", err));

            }).catch(err => console.error(err));
        }

        if (navigator.mediaDevices) {
            initScanner();
        } else {
            alert('Cannot access camera.');
        }

        async function cekData(code) {
            jQuery.ajax({
                url: "<?= base_url('scan/cek'); ?>",
                type: 'post',
                data: {
                    'unique_code': code,
                    'waktu': '<?= strtolower($waktu); ?>'
                },
                success: function (response, status, xhr) {
                    audio.play();
                    console.log(response);
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

        function clearData() {
            $('#hasilScan').html('');
        }
    </script>
</body>

</html>