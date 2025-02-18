<?php
include "../../library/phpqrcode/qrlib.php";
include "../../private/function/db_init.php";

$tempdir = "../resources/images/QRcode/"; //Nama folder tempat menyimpan file qrcode
if (!file_exists($tempdir)) {
    mkdir($tempdir);
}//Buat folder 

//ambil logo
$logopath = "../resources/images/logo.png";

// check if generate request were accepted
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    if (isset($_POST['create'])) {
        $query = "SELECT * FROM siswa";
        if (isset($_POST['kelas'])){
            // change the data with WHERE filter
            $kelas = $_POST['kelas'];
            $query = "SELECT * FROM siswa WHERE kelas='$kelas'";
        }
        // generate qr
        $queryData = mysqli_query($con, $query);

        while ($data = mysqli_fetch_array($queryData)){
            generateQr($data['nisn'], $data['nama']);
        }
        
        sleep(1);


        // if (isset($_POST['kelas'])){
        //     // create zip or rewrite
        //     generateZip("QR_code_kelas_", $_POST['kelas']);
        // } else {
        // }
        //create zip or rewrite
        generateZip("QR_code", null);

        ?>
        <meta http-equiv="refresh" content="0.2; url=./?tab=generate-qr" />
        <?php
    }

    if (isset($_POST['downloadKelas'])){

        echo "asaaa";

    }

} else {
    // dont.
}


function generateQr($nisn, $namaSiswa) {

    global $tempdir, $logopath;

    // isi qrcode jika di scan (jika bisa pakai yang 10 digit / huruf)
    $codeContents = $nisn;

    // untuk nama file qr agar mempermudah pembagian
    $namaFile = $namaSiswa;

    // simpan file qrcode
    QRcode::png($codeContents, $tempdir . $namaFile . '-QR.png', QR_ECLEVEL_H, 10, 4);

    // ambil file qrcode
    $QR = imagecreatefrompng($tempdir . $namaFile . '-QR.png');

    // memulai menggambar logo dalam file qrcode
    $logo = imagecreatefromstring(file_get_contents($logopath));

    imagecolortransparent($logo, imagecolorallocatealpha($logo, 0, 0, 0, 127));
    imagealphablending($logo, false);
    imagesavealpha($logo, true);

    $QR_width = imagesx($QR);
    $QR_height = imagesy($QR);

    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);

    // Scale logo to fit in the QR Code
    $logo_qr_width = $QR_width / 4;
    $scale = $logo_width / $logo_qr_width;
    $logo_qr_height = $logo_height / $scale;

    imagecopyresampled($QR, $logo, $QR_width / 2.65, $QR_height / 2.65, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

    // Simpan kode QR lagi, dengan logo di atasnya
    imagepng($QR, $tempdir . $namaFile . '-QR.png');
    
};

function generateZip($namaZip, $kelas) {

    global $query,$con;

    $queryData = mysqli_query($con, $query);

    $zip = new ZipArchive;
    $path = "../resources/images/QRcode/".$namaZip.".zip";

    if ($kelas != NULL) {
        $path = "../resources/images/QRcode/QR-zip/".$namaZip.$kelas.".zip";
    }
    
    if (file_exists($path)) {
        // Hapus file ZIP lama
        unlink($path);
    }


    if ($zip->open($path, ZipArchive::CREATE) === TRUE)
    {
        // // Add files to the zip file inside demo_folder
        while ($data = mysqli_fetch_array($queryData)) {
            echo "success added file";
            $zip->addFile('../resources/images/QRcode/'.$data['nama'].'-QR.png', $data['nama'].'_'.$data['kelas'].'-'.$data['jurusan'].'.png');
        }
    
        // All files are added, so close the zip file.
        $zip->close();
    }
}

?>