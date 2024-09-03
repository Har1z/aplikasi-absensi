<?php
//require db

//get post request month year & grade
//SELECT * FROM absen WHERE tgl BETWEEN '$variabelTahun-$variabelBulan-1' AND '$variabelTahun-$variabelBulan-31';


//SELECT kelas FROM siswa WHERE nisn='$data['nisn]'
// id $data2 == kelas ||add to file
// else skip

//save

require "../../private/function/db_init.php";

require "../../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
// use PhpOffice\PhpSpreadsheet\Style\Fill;

// Memastikan tidak ada output sebelumnya
if (ob_get_length())
    ob_end_clean();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $month = $_POST['month'];
    $kelas = $_POST['kelas'];

    switch ($kelas) {
        case "10":
            GenerateXlsx($month, $kelas);
            break;
        case "11":
            GenerateXlsx($month, $kelas);
            break;
        case "12":
            GenerateXlsx($month, $kelas);
            break;
        case "727":
            // GenerateAllXlsx($month);
            // im not getting paid coding this
            // so.. pls dont use this
            break;
    }
} else {
    // do nothing lol
}

function MonthToText($month): array {
    $tahun = substr($month, 0, -3);
    $noBulan = substr($month, 5);
    switch ($noBulan) {
        case "01":
            $bulan = "Januari";
            $nomorBulan = 1;
            break;
        case "02":
            $bulan = "Februari";
            $nomorBulan = 2;
            break;
        case "03":
            $bulan = "Maret";
            $nomorBulan = 3;
            break;
        case "04":
            $bulan = "April";
            $nomorBulan = 4;
            break;
        case "05":
            $bulan = "Mei";
            $nomorBulan = 5;
            break;
        case "06":
            $bulan = "Juni";
            $nomorBulan = 6;
            break;
        case "07":
            $bulan = "Juli";
            $nomorBulan = 7;
            break;
        case "08":
            $bulan = "Agustus";
            $nomorBulan = 8;
            break;
        case "09":
            $bulan = "September";
            $nomorBulan = 9;
            break;
        case "10":
            $bulan = "Oktober";
            $nomorBulan = 10;
            break;
        case "11":
            $bulan = "November";
            $nomorBulan = 11;
            break;
        case "12":
            $bulan = "Desember";
            $nomorBulan = 12;
            break;
    }

    return ['bulan' => $bulan, 'tahun' => $tahun, 'nomorBulan' => $nomorBulan];
}

function kehadiran($kehadiran): string {
    switch ($kehadiran) {
        case 1:
            $text = 'H';
            break;
        case 2:
            $text = 'S';
            break;
        case 3:
            $text = 'I';
            break;
        case 4:
            $text = 'A';
            break;
        case 0:
        default:
            $text = ' ';
            break;
    }

    return $text;
}

function GenerateXlsx($month, $kelas) {
    global $con;

    // Membuat Spreadsheet baru
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $bulanTahun = MonthToText($month);

    // Mengatur judul sheet
    $sheet->setTitle('Kelas ' . $kelas);

    // Mengatur judul utama
    $sheet->mergeCells('D2:AM2');
    $sheet->setCellValue('D2', 'ABSENSI SISWA KELAS ' . $kelas);
    $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Mengatur judul sub
    $sheet->mergeCells('D3:AM3');
    $sheet->setCellValue('D3', 'BULAN : ' . $bulanTahun['bulan'] . " " . $bulanTahun['tahun']);
    $sheet->getStyle('D3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Header tabel
    $sheet->mergeCells('B5:B6');
    $sheet->setCellValue('B5', 'NO');
    $sheet->mergeCells('C5:C6');
    $sheet->setCellValue('C5', 'NISN');
    $sheet->mergeCells('D5:D6');
    $sheet->setCellValue('D5', 'NAMA SISWA');
    $sheet->mergeCells('E5:AI5');
    $sheet->setCellValue('E5', 'TANGGAL');
    $sheet->mergeCells('AJ5:AM5');
    $sheet->setCellValue('AJ5', 'KETERANGAN');

    // Mengisi tanggal (1-??)
    for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $bulanTahun['nomorBulan'], $bulanTahun['tahun']); $i++) {
        if ($i <= 21) {
            $column = chr(69 + $i); // Kolom mulai dari E (ASCII 69)
            // echo $column;
            $sheet->setCellValue($column . '6', $i + 1);
        } else {
            $column = chr(65); // Kolom mulai dari A (ASCII 65)
            $column2 = chr(43 + $i); // Kolom mulai dari A (ASCII 65)
            $sheet->setCellValue($column . $column2 . '6', $i + 1);
            // echo $column.$column2." ";
        }

    }

    // Mengisi data nomor, nisn, nama
    $queryJumlahSiswa = mysqli_query($con, "SELECT * FROM siswa WHERE kelas='$kelas' ORDER BY nama ASC");
    $dataStartRow = 7;
    $counter = 0;
    while ($data = mysqli_fetch_array($queryJumlahSiswa)) {
        $sheet->setCellValue('B' . ($dataStartRow + $counter), strval($counter + 1));
        $sheet->setCellValue('C' . ($dataStartRow + $counter), $data['nisn']);
        $sheet->setCellValue('D' . ($dataStartRow + $counter), $data['nama']);

        // data absensi
        // sorry for super confusing code that i wrote
        // but still as long as it worked, it's valid :)
        $nisn = $data['nisn'];
        for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $bulanTahun['nomorBulan'], $bulanTahun['tahun']); $i++) {
            if ($i <= 21) {
                $column = chr(69 + $i); // Kolom mulai dari E (ASCII 69)
                if ($i < 9) {
                    $tanggal = $month . "-" . "0" . ($i + 1);
                } else {
                    $tanggal = $month . "-" . ($i + 1);
                }
                $queryKehadiran = mysqli_query($con, "SELECT * FROM absen WHERE tgl='$tanggal' AND nisn='$nisn'");
                $kehadiran = mysqli_fetch_array($queryKehadiran);

                if ($kehadiran) {
                    $sheet->setCellValue($column . ($dataStartRow + $counter), kehadiran($kehadiran['kehadiran']));
                } else {
                    $sheet->setCellValue($column . ($dataStartRow + $counter), " ");
                }

                $hari = date('D', strtotime($tanggal));
                if ($hari == "Sun") {
                    $sheet->setCellValue($column . ($dataStartRow + $counter), "-");
                } else if ($hari == "Sat") {
                    $sheet->setCellValue($column . ($dataStartRow + $counter), "-");
                }

            } else {
                $column = chr(65); // Kolom mulai dari A (ASCII 65)
                $column2 = chr(43 + $i); // Kolom mulai dari A (ASCII 65)
                
                $tanggal = $month . "-" . ($i + 1);
                
                $queryKehadiran = mysqli_query($con, "SELECT * FROM absen WHERE tgl='$tanggal' AND nisn='$nisn'");
                $kehadiran = mysqli_fetch_array($queryKehadiran);

                if ($kehadiran) {
                    $sheet->setCellValue($column . $column2 . ($dataStartRow + $counter), kehadiran($kehadiran['kehadiran']));
                } else {
                    $sheet->setCellValue($column . $column2 . ($dataStartRow + $counter), " ");
                }

                $hari = date('D', strtotime($tanggal));
                if ($hari == "Sun") {
                    $sheet->setCellValue($column . ($dataStartRow + $counter), "-");
                } else if ($hari == "Sat") {
                    $sheet->setCellValue($column . ($dataStartRow + $counter), "-");
                }
            }
        }

        // data total keterangan H S I A
        $sheet->setCellValue("AJ" . ($dataStartRow + $counter), '=COUNTIF(E'.($dataStartRow + $counter).':AI'.($dataStartRow + $counter).', "H")');
        $sheet->setCellValue("AK" . ($dataStartRow + $counter), '=COUNTIF(E'.($dataStartRow + $counter).':AI'.($dataStartRow + $counter).', "S")');
        $sheet->setCellValue("AL" . ($dataStartRow + $counter), '=COUNTIF(E'.($dataStartRow + $counter).':AI'.($dataStartRow + $counter).', "I")');
        $sheet->setCellValue("AM" . ($dataStartRow + $counter), '=COUNTIF(E'.($dataStartRow + $counter).':AI'.($dataStartRow + $counter).', "A")');

        $counter++;
    }


    // Keterangan
    $sheet->setCellValue('AJ6', 'H');
    $sheet->setCellValue('AK6', 'S');
    $sheet->setCellValue('AL6', 'I');
    $sheet->setCellValue('AM6', 'A');

    // Mengatur border untuk seluruh tabel
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ];

    $sheet->getStyle('B5:AM'.(6 + $counter))->applyFromArray($styleArray);

    // Mengatur lebar kolom untuk tanggal agar lebih kecil
    foreach (range('E', 'Z') as $columnID) {
        // echo $columnID;
        $sheet->getColumnDimension($columnID)->setWidth(4); // Lebar kolom tanggal diatur ke 4
    }

    foreach (range('A', 'I') as $columnID) {
        // echo 'A'.$columnID." ";
        $sheet->getColumnDimension('A' . $columnID)->setWidth(4); // Lebar kolom tanggal diatur ke 4
    }

    // Mengatur lebar kolom lainnya
    $sheet->getColumnDimension('B')->setWidth(5);
    $sheet->getColumnDimension('C')->setWidth(14);
    // $sheet->getColumnDimension('D')->setWidth(30);
    $sheet->getColumnDimension('D')->setAutoSize(true);

    $sheet->getColumnDimension('AJ')->setWidth(5);
    $sheet->getColumnDimension('AK')->setWidth(5);
    $sheet->getColumnDimension('AL')->setWidth(5);
    $sheet->getColumnDimension('AM')->setWidth(5);

    // Mengatur teks menjadi Center
    $sheet->getStyle('A:AZ')->getAlignment()->setHorizontal('center');

    $sheet->getStyle('B5:D12')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('B5:D12')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    // Mengatur header HTTP untuk download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="absensi_kelas_' . $kelas . '_' . $bulanTahun['bulan'] . '_' . $bulanTahun['tahun'] . '.xlsx"');
    header('Cache-Control: max-age=0');

    // Menyimpan file Excel ke output
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
}
function GenerateAllXlsx($month) /* PLEASE DONT USE THIS FOR A MOMENT */ {
    // Membuat Spreadsheet baru
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Mengatur judul sheet
    $sheet->setTitle('Kelas ');

    // Mengatur judul utama
    $sheet->mergeCells('D2:AN2');
    $sheet->setCellValue('D2', 'ABSENSI SISWA');
    $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Mengatur judul sub
    $sheet->mergeCells('D3:AN3');
    $sheet->setCellValue('D3', 'BULAN : SEPTEMBER 2017');
    $sheet->getStyle('D3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Header tabel
    $sheet->mergeCells('B5:B6');
    $sheet->setCellValue('B5', 'NO');
    $sheet->mergeCells('C5:C6');
    $sheet->setCellValue('C5', 'NISN');
    $sheet->mergeCells('D5:D6');
    $sheet->setCellValue('D5', 'NAMA SISWA');
    $sheet->mergeCells('E5:AI5');
    $sheet->setCellValue('E5', 'TANGGAL');
    $sheet->mergeCells('AJ5:AM5');
    $sheet->setCellValue('AJ5', 'KET');
    $sheet->setCellValue('AN5', 'TOTAL');

    // Mengisi tanggal (1-31)
    for ($i = 0; $i <= 31; $i++) {
        if ($i <= 21) {
            $column = chr(69 + $i); // Kolom mulai dari E (ASCII 69)
            // echo $column;
            $sheet->setCellValue($column . '6', $i + 1);
        } else {
            $column = chr(65); // Kolom mulai dari A (ASCII 65)
            $column2 = chr(43 + $i); // Kolom mulai dari A (ASCII 65)
            $sheet->setCellValue($column . $column2 . '6', $i + 1);
            // echo $column.$column2." ";
        }

    }

    // Keterangan
    $sheet->setCellValue('AJ6', 'H');
    $sheet->setCellValue('AK6', 'S');
    $sheet->setCellValue('AL6', 'I');
    $sheet->setCellValue('AM6', 'A');

    // Total
    $sheet->setCellValue('AN6', '% Kehadiran');


    // Mengatur border untuk seluruh tabel
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ];

    $sheet->getStyle('B5:AN12')->applyFromArray($styleArray);

    // Mengatur lebar kolom untuk tanggal agar lebih kecil
    foreach (range('E', 'Z') as $columnID) {
        // echo $columnID;
        $sheet->getColumnDimension($columnID)->setWidth(4); // Lebar kolom tanggal diatur ke 4
    }

    foreach (range('A', 'I') as $columnID) {
        // echo 'A'.$columnID." ";
        $sheet->getColumnDimension('A' . $columnID)->setWidth(4); // Lebar kolom tanggal diatur ke 4
    }

    // Mengatur lebar kolom lainnya
    $sheet->getColumnDimension('B')->setWidth(5);
    $sheet->getColumnDimension('C')->setWidth(14);
    // $sheet->getColumnDimension('D')->setWidth(30);
    $sheet->getColumnDimension('D')->setAutoSize(true);

    $sheet->getColumnDimension('AJ')->setWidth(5);
    $sheet->getColumnDimension('AK')->setWidth(5);
    $sheet->getColumnDimension('AL')->setWidth(5);
    $sheet->getColumnDimension('AM')->setWidth(5);

    $sheet->getColumnDimension('AN')->setWidth(14);

    // Mengatur teks menjadi Center
    $sheet->getStyle('A:AZ')->getAlignment()->setHorizontal('center');

    $sheet->getStyle('B5:D12')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('B5:D12')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    // Menyimpan file Excel
    // $writer = new Xlsx($spreadsheet);
    // $writer->save('laporan/absensi_siswa2.xlsx');
}

?>