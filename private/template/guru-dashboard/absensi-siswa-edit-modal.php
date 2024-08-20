<?php
require "../../private/function/db_init.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nisn = $_POST['nisn_siswa'];
    $date = $_POST['date'];
    // echo $nisn.'<br>';
    // echo $date;

    $queryAbsen = mysqli_query($con, "SELECT * FROM absen WHERE nisn='$nisn' AND tgl='$date'");
    $data = mysqli_fetch_array($queryAbsen);

    $statusKehadiran = kehadiran($data['kehadiran']);

} else {
    echo "Terjadi error.";
    return;
}
?>

<div class="modal-body">
    <div class="container-fluid">
        <form id="formUbah">

        <input type="hidden" name="nisn" value="<?= $nisn ?>">

            <label for="kehadiran">Kehadiran</label>
            <div class="form-check" id="kehadiran">

            <?php
            for($i = 1; $i <=4; $i++) {
                $kehadiran = kehadiran($i)
                ?>
                <div class="row">
                    <div class="col-auto pr-1 pt-1">
                        <input class="form-check" type="radio" name="kehadiran" id="k" value="<?= $i ?>" <?= ($data['kehadiran'] == $i) ? 'checked' : '' ?> >
                    </div>
                    <div class="col">
                        <label class="form-check-label pl-0" for="k">
                            <h6 class="text-<?= $kehadiran['color']; ?>"><?= $kehadiran['text']; ?></h6>
                        </label>
                    </div>
                </div>
                <?php
            }
            ?>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <label for="jamMasuk">Jam masuk</label>
                    <input class="form-control" type="time" name="jam_masuk" id="jamMasuk"
                        value="<?= $data['absen_masuk'] ?? ''; ?>">
                </div>
                <div class="col">
                    <label for="jamKeluar">Jam pulang</label>
                    <input class="form-control" type="time" name="jam_keluar" id="jamKeluar"
                        value="<?= $data['absen_pulang'] ?? ''; ?>">
                </div>
            </div>
            <label for="keterangan">Keterangan</label>
            <textarea id="keterangan" name="keterangan" class="custom-select form-control"><?= $data['ket'] ?? '' ?></textarea>
        </form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
    <button type="button" onclick="ubahKehadiran()" class="btn btn-primary" data-bs-dismiss="modal">Ubah</button>
</div>

<!-- <script>
    function ubahKehadiran() {
        form = $('#formUbah').serializeArray()
        console.log(form)
        console.log(form[0]['value'])
        console.log(form[1]['value'])
        console.log(form[2]['value'])
        console.log(form[3]['value'])
        console.log(form[4]['value'])
    }
</script> -->

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