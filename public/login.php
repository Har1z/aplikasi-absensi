<?php
session_start();
ob_start();

// if(isset($_SESSION['login'])){
//     if ($_SESSION['role'] == "admin") {
//         header("location: ./admin");
//         ob_end_flush();
//         die();
//     } else if ($_SESSION['role'] == "guru") {
//         header("location: ./guru");
//         ob_end_flush();
//         die();
//     } else if ($_SESSION['role'] == "siswa") {
//         header("location: ./siswa");
//         ob_end_flush();
//         die();
//     }
//     die();
// }

require "../private/function/db_init.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="./resources/images/logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./resources/css/login.css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<body>
    <section class="vh-100" style="background-color: #2b7523;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <!-- IMAGE ON LEFT SECTION -->
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <!-- Background Images -->
                                <img src="./resources/images/sekolah-login.jpeg" alt="login form" class="img-fluid"
                                    style="border-radius: 1rem 0 0 1rem; filter: blur(4px) brightness(.65);;" />

                                <!-- Clock & date -->
                                <div class="a-clock" style="">
                                    <?php include "../private/template/analog-clock.php"; ?>
                                </div>
                                <div id="d-clock"></div>
                                <div class="display-date">
                                    <span id="day">day</span>,
                                    <span id="daynum">00</span>
                                    <span id="month">month</span>
                                    <span id="year">0000</span>
                                </div>

                            </div>
                            <!-- END -->

                            <!-- LOGIN FORM -->
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form action=" " method="post">

                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <!-- <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i> -->
                                            <img src="resources/images/logo.png" alt=""
                                                style="height: auto; width: 80px; margin-right: 15px;">
                                            <span class="h1 fw-bold mb-0">Lab Attendance</span>
                                        </div>
                                        <br>

                                        <h5 class="fw-normal mb-2 pb-3" style="letter-spacing: 1px;">Sign into your
                                            account</h5>

                                        <div data-mdb-input-init class="form-outline">
                                            <input name="email" type="email" id="form2Example17"
                                                class="form-control form-control-lg" required/>
                                            <label class="form-label" for="form2Example17">Email address</label>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-2">
                                            <input name="password" type="password" id="form2Example27"
                                                class="form-control form-control-lg" required/>
                                            <label class="form-label" for="form2Example27">Password</label>
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-dark btn-lg btn-block" type="submit"
                                                name="login">Login</button>
                                        </div>

                                        <!-- <a class="small text-muted" href="#!">Forgot password?</a> -->
                                        <!-- <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a
                                                href="#!" style="color: #393f81;">Register here</a></p> -->
                                        <div class="mt-3" style="width: auto;">
                                            <?php
                                            if (isset($_POST['login'])) {
                                                $email = htmlspecialchars($_POST['email']);
                                                $password = htmlspecialchars($_POST['password']);

                                                $roles = ['admin', 'guru', 'siswa'];
                                                $roleFound = false;

                                                foreach ($roles as $role) {
                                                    $query = mysqli_query($con, "SELECT * FROM $role WHERE email='$email'");
                                                    $countdata = mysqli_num_rows($query);

                                                    if ($countdata > 0) {
                                                        $roleFound = true;
                                                        $data = mysqli_fetch_array($query);
                                                        break;
                                                    }
                                                }

                                                if ($roleFound) {
                                                    if (password_verify($password, $data['password'])) {
                                                        $_SESSION['email'] = $data['email'];
                                                        $_SESSION['role'] = $role;
                                                        $_SESSION['login'] = true;
                                                        echo $role; // you get the role exactly where you stop
                                                        if ($role == "admin") {
                                                            header("location: ./admin");
                                                            ob_end_flush();
                                                            die();
                                                        } else if ($role == "guru") {
                                                            header("location: ./guru");
                                                            ob_end_flush();
                                                            die();
                                                        } else if ($role == "siswa") {
                                                            header("location: ./siswa");
                                                            ob_end_flush();
                                                            die();
                                                        }
                                                        // header('location: ./dashboard/');
                                                    } else {
                                                        ?>
                                                        <div class="alert alert-danger" role="alert">
                                                            Password salah!
                                                        </div>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <div class="alert alert-warning" role="alert">
                                                        Akun tidak ditemukan.
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </form>

                                    <strong class="small text-muted">&copy; 2023-<?php echo date("Y");?></strong>

                                </div>
                            </div>
                            <!-- LOGIN FORM END -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
<script>
    const displayTime = document.querySelector(".display-date");
    // Date
    function updateDate() {
        let today = new Date();

        // return number
        let dayName = today.getDay(),
            dayNum = today.getDate(),
            month = today.getMonth(),
            year = today.getFullYear();

        const months = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ];
        const dayWeek = [
            "Minggu",
            "Senin",
            "Selasa",
            "Rabu",
            "Kamis",
            "Jumat",
            "Sabtu",
        ];
        // value -> ID of the html element
        const IDCollection = ["day", "daynum", "month", "year"];
        // return value array with number as a index
        const val = [dayWeek[dayName], dayNum, months[month], year];
        for (let i = 0; i < IDCollection.length; i++) {
            document.getElementById(IDCollection[i]).firstChild.nodeValue = val[i];
        }
    }

    updateDate();

    function updateClock() {
        var currentTime = new Date();
        // Operating System Clock Hours for 24h clock
        var currentHours = currentTime.getHours();
        // Operating System Clock Minutes
        var currentMinutes = currentTime.getMinutes();
        // Operating System Clock Seconds
        var currentSeconds = currentTime.getSeconds();
        // Adding 0 if Minutes & Seconds is More or Less than 10
        currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
        currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;
        // display first 24h clock and after line break 12h version
        var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds;
        // print clock js in div #clock.
        $("#d-clock").html(currentTimeString);
    }

    $(document).ready(function () {
        setInterval(updateClock, 1000);
    });
</script>

</html>