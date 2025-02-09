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

    <!-- <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body style="background-color: lightgrey;">
    <div style="height:80px; position: relative;">
        <a href="./" type="button" class="btn btn-secondary"
            style="user-select: none; position: absolute; top: 50%; right: 4%; transform: translateY(-50%);"><span
                class=""><i class='bx bx-grid-alt nav_icon'></i> Dashboard </span></a>
        <a href="./?tab=absen-manual" type="button" class="btn btn-primary"
            style="user-select: none; position: absolute; top: 50%; right: 4%; transform: translate(-120%, -50%);"><span
                class=""> Absen Manual </span></a>
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
                                <style>
                                    .text-pink-pastel {
                                        color: #ffc5d3 !important;
                                    }

                                    .hasil-scan {
                                        position: relative;
                                        /* Mengatur kontainer agar bisa menampung elemen canvas dengan posisi absolute */
                                    }

                                    .canvas-background {
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        width: 100%;
                                        height: 100%;
                                        z-index: 10;
                                        /* Pastikan canvas berada di bawah konten lainnya */
                                        background-color: transparent;
                                        /* Pastikan latar belakang canvas transparan */
                                        /* border-style: dotted; */
                                    }

                                    canvas {
                                        /* background-color: #000; */
                                        width: 100%;
                                        height: 100%;
                                    }
                                </style>
                                <div style="position: relative;">
                                    <canvas id="canvas" class="canvas-background" style="display: none;"></canvas>
                                    <div id="hasilScan" class="hasil-scan"></div>
                                </div>
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

    <!-- Firework script for her {last gift, hope so..} (13 dec 2024)-->
    <script>
        // when animating on canvas, it is best to use requestAnimationFrame instead of setTimeout or setInterval
        // not supported in all browsers though and sometimes needs a prefix, so we need a shim
        window.requestAnimFrame = (function () {
            return window.requestAnimationFrame ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame ||
                function (callback) {
                    window.setTimeout(callback, 1000 / 60);
                };
        })();

        // now we will setup our basic variables for the demo
        var canvas = document.getElementById('canvas'),
            ctx = canvas.getContext('2d'),
            // full screen dimensions
            cw = window.innerWidth,
            ch = window.innerHeight,
            // firework collection
            fireworks = [],
            // particle collection
            particles = [],
            // starting hue
            hue = 120,
            // when launching fireworks with a click, too many get launched at once without a limiter, one launch per 5 loop ticks
            limiterTotal = 5,
            limiterTick = 0,
            // this will time the auto launches of fireworks, one launch per 50 loop ticks
            timerTotal = 50,
            timerTick = 0,
            mousedown = false,
            // mouse x coordinate,
            mx,
            // mouse y coordinate
            my;

        // set canvas dimensions
        canvas.width = cw;
        canvas.height = ch;

        // now we are going to setup our function placeholders for the entire demo

        // get a random number within a range
        function random(min, max) {
            return Math.random() * (max - min) + min;
        }

        // calculate the distance between two points
        function calculateDistance(p1x, p1y, p2x, p2y) {
            var xDistance = p1x - p2x,
                yDistance = p1y - p2y;
            return Math.sqrt(Math.pow(xDistance, 2) + Math.pow(yDistance, 2));
        }

        // create firework
        function Firework(sx, sy, tx, ty) {
            // actual coordinates
            this.x = sx;
            this.y = sy;
            // starting coordinates
            this.sx = sx;
            this.sy = sy;
            // target coordinates
            this.tx = tx;
            this.ty = ty;
            // distance from starting point to target
            this.distanceToTarget = calculateDistance(sx, sy, tx, ty);
            this.distanceTraveled = 0;
            // track the past coordinates of each firework to create a trail effect, increase the coordinate count to create more prominent trails
            this.coordinates = [];
            this.coordinateCount = 3;
            // populate initial coordinate collection with the current coordinates
            while (this.coordinateCount--) {
                this.coordinates.push([this.x, this.y]);
            }
            this.angle = Math.atan2(ty - sy, tx - sx);
            this.speed = 2;
            this.acceleration = 1.05;
            this.brightness = random(50, 70);
            // circle target indicator radius
            this.targetRadius = 1;
        }

        // update firework
        Firework.prototype.update = function (index) {
            // remove last item in coordinates array
            this.coordinates.pop();
            // add current coordinates to the start of the array
            this.coordinates.unshift([this.x, this.y]);

            // cycle the circle target indicator radius
            if (this.targetRadius < 8) {
                this.targetRadius += 0.3;
            } else {
                this.targetRadius = 1;
            }

            // speed up the firework
            this.speed *= this.acceleration;

            // get the current velocities based on angle and speed
            var vx = Math.cos(this.angle) * this.speed,
                vy = Math.sin(this.angle) * this.speed;
            // how far will the firework have traveled with velocities applied?
            this.distanceTraveled = calculateDistance(this.sx, this.sy, this.x + vx, this.y + vy);

            // if the distance traveled, including velocities, is greater than the initial distance to the target, then the target has been reached
            if (this.distanceTraveled >= this.distanceToTarget) {
                createParticles(this.tx, this.ty);
                // remove the firework, use the index passed into the update function to determine which to remove
                fireworks.splice(index, 1);
            } else {
                // target not reached, keep traveling
                this.x += vx;
                this.y += vy;
            }
        }

        // draw firework
        Firework.prototype.draw = function () {
            ctx.beginPath();
            // move to the last tracked coordinate in the set, then draw a line to the current x and y
            ctx.moveTo(this.coordinates[this.coordinates.length - 1][0], this.coordinates[this.coordinates.length - 1][1]);
            ctx.lineTo(this.x, this.y);
            ctx.strokeStyle = 'hsl(' + hue + ', 100%, ' + this.brightness + '%)';
            ctx.stroke();

            ctx.beginPath();
            // draw the target for this firework with a pulsing circle
            ctx.arc(this.tx, this.ty, this.targetRadius, 0, Math.PI * 2);
            ctx.stroke();
        }

        // create particle
        function Particle(x, y) {
            this.x = x;
            this.y = y;
            // track the past coordinates of each particle to create a trail effect, increase the coordinate count to create more prominent trails
            this.coordinates = [];
            this.coordinateCount = 5;
            while (this.coordinateCount--) {
                this.coordinates.push([this.x, this.y]);
            }
            // set a random angle in all possible directions, in radians
            this.angle = random(0, Math.PI * 2);
            this.speed = random(1, 10);
            // friction will slow the particle down
            this.friction = 0.95;
            // gravity will be applied and pull the particle down
            this.gravity = 1;
            // set the hue to a random number +-50 of the overall hue variable
            this.hue = random(hue - 50, hue + 50);
            this.brightness = random(50, 80);
            this.alpha = 1;
            // set how fast the particle fades out
            this.decay = random(0.015, 0.03);
        }

        // update particle
        Particle.prototype.update = function (index) {
            // remove last item in coordinates array
            this.coordinates.pop();
            // add current coordinates to the start of the array
            this.coordinates.unshift([this.x, this.y]);
            // slow down the particle
            this.speed *= this.friction;
            // apply velocity
            this.x += Math.cos(this.angle) * this.speed;
            this.y += Math.sin(this.angle) * this.speed + this.gravity;
            // fade out the particle
            this.alpha -= this.decay;

            // remove the particle once the alpha is low enough, based on the passed in index
            if (this.alpha <= this.decay) {
                particles.splice(index, 1);
            }
        }

        // draw particle
        Particle.prototype.draw = function () {
            ctx.beginPath();
            // move to the last tracked coordinates in the set, then draw a line to the current x and y
            ctx.moveTo(this.coordinates[this.coordinates.length - 1][0], this.coordinates[this.coordinates.length - 1][1]);
            ctx.lineTo(this.x, this.y);
            ctx.strokeStyle = 'hsla(' + this.hue + ', 100%, ' + this.brightness + '%, ' + this.alpha + ')';
            ctx.stroke();
        }

        // create particle group/explosion
        function createParticles(x, y) {
            // increase the particle count for a bigger explosion, beware of the canvas performance hit with the increased particles though
            var particleCount = 30;
            while (particleCount--) {
                particles.push(new Particle(x, y));
            }
        }

        // main demo loop
        function loop() {
            // this function will run endlessly with requestAnimationFrame
            requestAnimFrame(loop);

            // increase the hue to get different colored fireworks over time
            //hue += 0.5;

            // create random color
            hue = random(0, 360);

            // normally, clearRect() would be used to clear the canvas
            // we want to create a trailing effect though
            // setting the composite operation to destination-out will allow us to clear the canvas at a specific opacity, rather than wiping it entirely
            ctx.globalCompositeOperation = 'destination-out';
            // decrease the alpha property to create more prominent trails
            ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
            ctx.fillRect(0, 0, cw, ch);
            // change the composite operation back to our main mode
            // lighter creates bright highlight points as the fireworks and particles overlap each other
            ctx.globalCompositeOperation = 'lighter';

            // loop over each firework, draw it, update it
            var i = fireworks.length;
            while (i--) {
                fireworks[i].draw();
                fireworks[i].update(i);
            }

            // loop over each particle, draw it, update it
            var i = particles.length;
            while (i--) {
                particles[i].draw();
                particles[i].update(i);
            }

            // launch fireworks automatically to random coordinates, when the mouse isn't down
            if (timerTick >= timerTotal) {
                if (!mousedown) {
                    // start the firework at the bottom middle of the screen, then set the random target coordinates, the random y coordinates will be set within the range of the top half of the screen
                    fireworks.push(new Firework(cw / 2, ch, random(0, cw), random(0, ch / 2)));
                    timerTick = 0;
                }
            } else {
                timerTick++;
            }

            // limit the rate at which fireworks get launched when mouse is down
            if (limiterTick >= limiterTotal) {
                if (mousedown) {
                    // start the firework at the bottom middle of the screen, then set the current mouse coordinates as the target
                    fireworks.push(new Firework(cw / 2, ch, mx, my));
                    limiterTick = 0;
                }
            } else {
                limiterTick++;
            }
        }

        // mouse event bindings
        // update the mouse coordinates on mousemove
        canvas.addEventListener('mousemove', function (e) {
            mx = e.pageX - canvas.offsetLeft;
            my = e.pageY - canvas.offsetTop;
        });

        // toggle mousedown state and prevent canvas from being selected
        canvas.addEventListener('mousedown', function (e) {
            e.preventDefault();
            mousedown = true;
        });

        canvas.addEventListener('mouseup', function (e) {
            e.preventDefault();
            mousedown = false;
        });

        // once the window loads, we are ready for some fireworks!
        window.onload = loop;


    </script>

    <!-- QR scanner script -->
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

        function isMobileDevice() {
            return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1);
        }

        function startScanning(cameraId) {
            const qrCodeScanner = new Html5Qrcode("previewKamera");
            const qrboxSize = isMobileDevice() ? 170 : 250;  // Lebih kecil untuk mobile

            qrCodeScanner.start(
                cameraId,
                {
                    fps: 20,    // Optional, frame per seconds for qr code scanning
                    qrbox: qrboxSize  // Optional, if you want bounded box UI
                },
                qrCodeMessage => {
                    console.log(`QR Code detected: ${qrCodeMessage}`);
                    cekData(`${qrCodeMessage}`)
                    // Handle the scanned QR code here

                    // Giving the scanner a delay between result
                    qrCodeScanner.pause();
                    if ((<?= date('dm') ?> == 2305) && (qrCodeMessage == "0089745533")) {
                        document.querySelector("#canvas").setAttribute("style", "display: block;");
                        $('html, body').animate({
                            scrollTop: $("#hasilScan").offset().top
                        }, 500);
                    } else {
                        document.querySelector("#canvas").setAttribute("style", "display: none;");
                    }
                    // Removing unwanted "paused scanner" banner on the camera when on delay
                    // document.querySelector("#previewKamera > div").removeAttribute("style");
                    // document.querySelector("#previewKamera > div").innerHTML = `${qrCodeMessage}`;
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
            const qrboxSize = isMobileDevice() ? 170 : 250;  // Lebih kecil untuk mobile

            html5QrCode.start(
                { facingMode: "environment" },
                {
                    fps: 20,
                    qrbox: qrboxSize
                },
                qrCodeMessage => {
                    console.log(`QR Code detected: ${qrCodeMessage}`);
                    cekData(`${qrCodeMessage}`)
                    // Handle the scanned QR code here

                    // Giving the scanner a delay between result
                    html5QrCode.pause();
                    if ((<?= date('dm') ?> == 2305) && (qrCodeMessage == "0089745533")) {
                        document.querySelector("#canvas").setAttribute("style", "display: block;");
                        $('html, body').animate({
                            scrollTop: $("#hasilScan").offset().top
                        }, 500);
                    } else {
                        document.querySelector("#canvas").setAttribute("style", "display: none;");
                    }
                    // Removing unwanted "paused scanner" banner on the camera when on delay
                    // document.querySelector("#previewKamera > div").removeAttribute("style");
                    // document.querySelector("#previewKamera > div").innerHTML = '';

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
                url: "./scan/cek.php",
                type: 'post',
                data: {
                    'code': code,
                    'waktu': '<?= strtolower($waktu); ?>'
                },
                success: function (response, status, xhr) {
                    // console.log(response);
                    $('#hasilScan').html(response);

                    // removing the scroll cuz it unnecessary (13 dec 2024)
                    // $('html, body').animate({
                    //     scrollTop: $("#hasilScan").offset().top
                    // }, 500);
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