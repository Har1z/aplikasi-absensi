<?php
require "../../private/function/db_init.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    if(isset($_POST['edit'])){

        //get all post request
        $tgl = $_POST['tgl'];
        $nisn = $_POST['nisn'];
        $kehadiran = $_POST['kehadiran'];
        $absenMasuk = $_POST['jam_masuk'];
        $absenPulang = $_POST['jam_pulang'];
        $keterangan = $_POST['keterangan'];
    
        if ($absenMasuk == "00:00:00"){
            $absenMasuk = "null";
        } else if ($absenMasuk == ""){
            $absenMasuk = "null";
        } else {
            $absenMasuk = "'".$_POST['jam_masuk']."'";
        }
    
        if ($absenPulang == "00:00:00"){
            $absenPulang = "null";
        } else if ($absenPulang == ""){
            $absenPulang = "null";
        } else {
            $absenPulang = "'".$_POST['jam_pulang']."'";
        }
    
        $query = mysqli_query($con, "UPDATE absen SET kehadiran='$kehadiran', absen_masuk=$absenMasuk, absen_pulang=$absenPulang, ket='$keterangan' WHERE nisn='$nisn' AND tgl='$tgl'");
        if ($query){
            // echo $tgl."<br>".$nisn."<br>".$kehadiran."<br>".$absenMasuk."<br>".$absenPulang."<br>".$keterangan;
            // echo "data berhasil disimpan";
            ?>
            <script>
                setTimeout(function() {
                    document.getElementById("filter").submit();
                }, 200);
            </script>
            <?php
        }

    } else if (isset($_POST['delete'])) {

        $tgl = $_POST['tgl'];
        $nisn = $_POST['nisn'];
        $query = mysqli_query($con, "UPDATE absen SET kehadiran='4', absen_masuk=null, absen_pulang=null, ket=null WHERE nisn='$nisn' AND tgl='$tgl'");

        if($query) {
            ?>
            <script>
                setTimeout(function() {
                    document.getElementById("filter").submit();
                }, 200);
            </script>
            <?php
        }
    }
}
?>