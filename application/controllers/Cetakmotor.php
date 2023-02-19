<?php
defined('BASEPATH') or exit('No direct script access allowed');

function tgl_indo($tanggal)
{
    $bulan = array(
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
}
class Cetakmotor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Pdf'); // MEMANGGIL LIBRARY YANG KITA BUAT TADI
    }
    public function index()
    {
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();

// Logo
        $pdf->Image('assets/foto/logo.PNG', 20, 10);

// Arial bold 15
        $pdf->SetFont('Times', 'B', 15);
// Move to the right
        // $this->Cell(60);
        // Title
        $pdf->Cell(200, 8, 'PEMERINTAHAN DAERAH KABUPATEN SUBANG', 0, 1, 'C');
        $pdf->Cell(200, 8, 'DINAS PEMBERDAYAAN MASYARAKAT DAN DESA', 0, 1, 'C');
        $pdf->SetFont('Times', '', 13);
        $pdf->Cell(200, 8, 'Jalan Darmodiharjo Nomor 03 Telp. (0260) 411015 - Subang', 0, 1, 'C');
// Line break
        $pdf->Ln(5);

        $pdf->SetLineWidth(1);
        $pdf->Line(10, 36, 210, 36);
        $pdf->SetLineWidth(0);
        $pdf->Line(10, 37, 210, 37);

        $pdf->Ln(5);
        $pdf->SetFont('Times', 'B', 11);
        $pdf->Cell(200, 4, 'DAFTAR KENDARAAN BERMOTOR', 0, 1, 'C');
        $pdf->Cell(200, 4, 'DINAS PEMBERDAYAAN MASYARAKAT DAN DESA', 0, 1, 'C');
        $pdf->Cell(200, 4, 'PERIODE TAHUN 2022', 0, 1, 'C');
        $pdf->Ln(3);

        $pdf->SetFont('Times', 'B', 9);

// header tabel
        $pdf->cell(8, 5, 'No', 1, 0, 'C');
        $pdf->cell(14, 5, 'Jenis', 1, 0, 'C');
        $pdf->cell(26, 5, 'Merk', 1, 0, 'C');
        $pdf->cell(28, 5, 'Type', 1, 0, 'C');
        $pdf->cell(28, 5, 'Tahun Pembuatan', 1, 0, 'C');
        $pdf->cell(21, 5, 'Nomor Polisi', 1, 0, 'C');
        $pdf->cell(38, 5, 'No Rangka', 1, 0, 'C');
        $pdf->cell(36, 5, 'No Berita Acara', 1, 0, 'C');

        $pdf->Ln(5);
// set font
        $pdf->SetFont('Times', '', 9);
        $data_kendaraan = $this->db->get_where('kendaraan', array('jenis_kendaraan' => 'Motor'))->result();
// set penomoran
        $nomor = 1;

        foreach ($data_kendaraan as $kendaraan) {
            $pdf->cell(8, 5, $nomor++ . '.', 1, 0, 'C');
            $pdf->cell(14, 5, ucfirst($kendaraan->jenis_kendaraan), 1, 0, 'L');
            $pdf->cell(26, 5, substr(ucfirst($kendaraan->merk), 0, 17), 1, 0, 'L');
            $pdf->cell(28, 5, substr(ucfirst($kendaraan->tipe), 0, 17), 1, 0, 'L');
            $pdf->cell(28, 5, strtoupper($kendaraan->tahun_penerbitan), 1, 0, 'C');
            $pdf->cell(21, 5, substr(strtoupper($kendaraan->nomor_polisi), 0, 10), 1, 0, 'C');
            $pdf->cell(38, 5, strtoupper($kendaraan->no_rangka), 1, 0, 'C');
            $pdf->cell(36, 5, strtoupper($kendaraan->berita), 1, 0, 'C');
            $pdf->Ln(5);
        }
        $pdf->SetFont('Times', '', 11);
        $pdf->Ln(2);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(100, 7, 'Subang, ' . tgl_indo(date('Y-m-d')), 0, 0, 'C');
        $pdf->Ln(4);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(100, 7, 'KEPALA DISPEMDES KABUPATEN SUBANG', 0, 0, 'C');
        $pdf->Ln(25);

        $pdf->SetFont('Times', 'B', 11);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(100, 7, 'DADAN DWIYANA, A.P., M.Si', 0, 0, 'C');
        $pdf->Ln(4);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(100, 7, 'NIP. 19761021 199603 1 003', 0, 0, 'C');

        $pdf->Output();
    }
}
