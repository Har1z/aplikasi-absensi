<!-- Sidebar -->
<header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i></div>


        <div> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z"></path></svg> <?= $_SESSION['email'] ?></div>
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div style="height: auto;"> 
                
                <a href="#" class="nav_logo"> 
                    <!-- <i class='bx bx-home nav_logo-icon'></i>  -->
                    <img src="../resources/images/logo.png" alt="" style="width: 20px; height: 20px; transform: translate(1px, -1.3px);">
                    <span class="nav_logo-name">Lab Attendance</span> 
                </a>
                
                <div class="nav_list"> 
                    <a href="./" class="nav_link <?php echo $dashboard ?>"> 
                        <i class='bx bx-grid-alt nav_icon'></i> 
                        <span class="nav_name">Dashboard</span> 
                    </a> 

                    <a href="?tab=absensi-siswa" class="nav_link <?php echo $absensiSiswa ?>"> 
                        <i class='bx bx-list-ul nav_icon'></i>
                        <span class="nav_name">Absensi siswa</span> 
                    </a> 

                    <a href="?tab=data-siswa" class="nav_link <?= $dataSiswa ?>"> 
                        <i class='bx bx-user nav_icon'></i> 
                        <!-- <i class='bx bx-message-square-detail nav_icon'></i>  -->
                        <span class="nav_name">Data siswa</span> 
                    </a> 

                    <a href="?tab=data-guru" class="nav_link <?= $dataGuru ?>"> 
                        <i class='bx bxs-user-rectangle nav_icon'></i>
                        <!-- <i class='bx bx-bookmark nav_icon'></i>  -->
                        <span class="nav_name">Data guru</span> 
                    </a> 

                    <a href="?tab=generate-qr" class="nav_link <?= $generateQr ?>">
                        <i class='bx bx-qr nav_icon'></i>
                        <span class="nav_name">Buat / download QR</span>
                    </a>

                    <!-- <a href="?tab=laporan" class="nav_link <?= $laporan ?>"> 
                        <i class='bx bx-folder nav_icon'></i> 
                        <span class="nav_name">Laporan absensi</span> 
                    </a> -->

                    <!-- <a href="#" class="nav_link"> 
                        <i class='bx bx-bar-chart-alt-2 nav_icon'></i> 
                        <span class="nav_name">Stats</span> 
                    </a>  -->
                </div>
                
                <a href="./logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Logout</span> </a>
            </div> 

        </nav>
    </div>