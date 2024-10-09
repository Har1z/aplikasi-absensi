<?php
require "../../../private/function/db_init.php";

require_once('../../../library/ultra-msg/ultramsg.class.php'); // if you download ultramsg.class.php
require_once('../../../library/ultra-msg/ultramsg-2.class.php'); // if you download ultramsg.class.php
    
$token="ylmjx9vj6zqbczb4"; // Ultramsg.com token
$instance_id="instance95029"; // Ultramsg.com instance id
$client = new UltraMsg\WhatsAppApi($token,$instance_id);

// $token_2="zuk4oh7usbxn4t7i"; // Ultramsg.com token
// $instance_id_2="instance92836"; // Ultramsg.com instance id
// $client_2 = new UltraMsgs\WhatsAppApi($token_2,$instance_id_2);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $code = $_POST['code'];
    $waktu = $_POST['waktu'];
    date_default_timezone_set('Asia/Bangkok');
    $time = date('His');
    $telat = date('Hi') > 705;

    $date = date('Y').'-'.date('m').'-'.date('d');
    $query = mysqli_query($con, "SELECT * FROM siswa WHERE nisn='$code'");
    $data = mysqli_fetch_array($query);
    // echo $data['nama'];
    // echo $waktu;

    if (cekData($con, $code)) {
        switch ($waktu) {
            case 'masuk':
                $cekAbsen = mysqli_query($con, "SELECT * FROM absen WHERE nisn='$code' AND tgl='$date'");
                $sudahHadir = mysqli_query($con, "SELECT * FROM absen WHERE nisn='$code' AND tgl='$date' AND absen_masuk IS NOT NULL");
                $pesanMasuk = "Assalamualaikum Wr.Wb, ayah/bunda Ananda ".$data['nama']." sudah hadir di sekolah, mari kita doakan Ananda menjadi anak yang soleh/solehah. Aamin, wassalamualaikum.";

                if (mysqli_num_rows($sudahHadir) != 0) {
                    showErrorView('Anda sudah absen hari ini', $data, mysqli_fetch_array($cekAbsen));
                    break;
                }

                if ($telat){
                    if (mysqli_num_rows($cekAbsen) == 0) {
                        $queryCreateAbsensi = mysqli_query($con, "INSERT INTO absen (`nisn`, `tgl`, `kehadiran`, `absen_masuk`, `ket`) VALUES ('$code','$date','1','$time','terlambat datang')");
                        resultView($waktu, $data,mysqli_fetch_array($cekAbsen));

                        // send messages
                        $nomor = "+62" . substr($data['no_orangtua'], 1);
                        $api=$client->sendChatMessage($nomor,$pesanMasuk);
                        break;
                    } else {
                        $queryUpdateAbsensi = mysqli_query($con, "UPDATE absen SET kehadiran='1', absen_masuk='$time', ket='terlambat datang' WHERE nisn='$code' AND tgl='$date'");
                        resultView($waktu, $data,mysqli_fetch_array($cekAbsen));

                        // send messages
                        $nomor = "+62" . substr($data['no_orangtua'], 1);
                        $api=$client->sendChatMessage($nomor,$pesanMasuk);
                        break;
                    }
                }

                
                break;

            case 'pulang':
                $cekAbsen = mysqli_query($con, "SELECT * FROM absen WHERE nisn='$code' AND tgl='$date'");
                $belumHadir = mysqli_query($con, "SELECT * FROM absen WHERE nisn='$code' AND tgl='$date' AND absen_masuk IS NOT NULL");
                $sudahPulang = mysqli_query($con, "SELECT * FROM absen WHERE nisn='$code' AND tgl='$date' AND absen_masuk IS NOT NULL AND absen_pulang IS NOT NULL");
                $pesanPulang = "Assalamualaikum Wr.Wb, ayah/bunda Ananda ".$data['nama']." sudah pulang dari sekolah, semoga ilmu yang diterima dapat bermanfaat untuk keberhasilan Ananda ".$data['nama'].". Aamin, wassalamualaikum.";

                if (mysqli_num_rows($belumHadir) != 1) {
                    $randomize = "6".rand(34,57);
                    if (mysqli_num_rows($cekAbsen) != 0) {
                        $queryUpdateAbsensi = mysqli_query($con, "UPDATE absen SET kehadiran='1' absen_masuk='$randomize' absen_pulang='$time' WHERE nisn='$code' AND tgl='$date'");
                        resultView($waktu, $data,mysqli_fetch_array($cekAbsen));
                    } else if (mysqli_num_rows($cekAbsen) == 0) {
                        $queryCreateAbsensi = mysqli_query($con, "INSERT INTO absen (`nisn`, `tgl`, `kehadiran`, `absen_masuk`, `absen_pulang`) VALUES ('$code','$date','1','$randomize','$time')");
                        resultView($waktu, $data,mysqli_fetch_array($cekAbsen));
                    }
                    break;
                }

                if ((mysqli_num_rows($sudahPulang) != 0) && (mysqli_num_rows($cekAbsen) != 0)) {
                    showErrorView('Anda sudah pulang hari ini', $data, mysqli_fetch_array($cekAbsen));
                } else if (mysqli_num_rows($sudahPulang) == 0) {
                    $queryUpdateAbsensi = mysqli_query($con, "UPDATE absen SET absen_pulang='$time' WHERE nisn='$code' AND tgl='$date'");
                    resultView($waktu, $data,mysqli_fetch_array($cekAbsen));

                    // send messages
                    $nomor = "+62" . substr($data['no_orangtua'], 1);
                    $api=$client->sendChatMessage($nomor,$pesanPulang);
                } else {
                    showErrorView('Terjadi kesalahan');
                }
                break;

            default:
                break;
        }
    } else {
        showErrorView('Data tidak valid');
    }
} else {
    echo "No POST request received.";
}


function cekData($con, $nisn)
{
    $queryCekSiswa = mysqli_query($con, "SELECT * FROM siswa WHERE nisn='$nisn'");
    $result = mysqli_num_rows($queryCekSiswa);

    if ($result > 0) {
        return true; // jika data ditemukan
    } else {
        return false;
    }
}

function absenMasuk()
{

}

function showErrorView(string $msg = 'no error message', $data = NULL, $presensi = NULL)
{
    $errdata = $data ?? [];
    $errdata['msg'] = $msg;

    ?>
    <h3 class="text-danger"><?= $msg; ?></h3>

    <div class="row w-100">
        <div class="col">
            <p>Nama : <b><?= $data['nama'] ?? '-'; ?></b></p>
            <p>NISN : <b><?= $data['nisn'] ?? '-'; ?></b></p>
            <p>Kelas : <b><?= ($data['kelas'] ?? '') . ' - ' . ($data['jurusan'] ?? ''); ?></b></p>
        </div>
        <div class="col">
            <?= jam($presensi ?? []); ?>
        </div>
    </div>
    <?php


}

function resultView($waktu, $data, $presensi) 
{
    ?>
    <h3 class="text-success">Absen <?= $waktu; ?> berhasil</h3>
    <div class="row w-100">
        <div class="col">
            <p>Nama : <b><?= $data['nama']; ?></b></p>
            <p>NISN : <b><?= $data['nisn']; ?></b></p>
            <p>Kelas : <b><?= $data['kelas']  . ' - ' . $data['jurusan']; ?></b></p>
        </div>
        <div class="col">
            <?= jam($presensi); ?>
        </div>
    </div>
    
    <?php
}

function jam($presensi)
{
    ?>
    <p>Jam masuk : <b class="text-info"><?= $presensi['absen_masuk'] ?? '-'; ?></b></p>
    <p>Jam pulang : <b class="text-info"><?= $presensi['absen_pulang'] ?? '-'; ?></b></p>
    <?php
}
?>
