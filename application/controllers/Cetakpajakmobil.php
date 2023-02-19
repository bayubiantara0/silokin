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
class Cetakpajakmobil extends CI_Controller
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
        $pdf->Cell(200, 4, 'DAFTAR PAJAK KENDARAAN BERMOTOR', 0, 1, 'C');
        $pdf->Cell(200, 4, 'DINAS PEMBERDAYAAN MASYARAKAT DAN DESA', 0, 1, 'C');
        $pdf->Cell(200, 4, 'PERIODE TAHUN 2022', 0, 1, 'C');
        $pdf->Ln(3);

        $pdf->SetFont('Times', 'B', 9);

// header tabel
        $pdf->cell(8, 5, 'NO.', 1, 0, 'C');
        $pdf->cell(50, 5, 'Merk', 1, 0, 'C');
        $pdf->cell(50, 5, 'Type', 1, 0, 'C');
        $pdf->cell(25, 5, 'Nomor Polisi', 1, 0, 'C');
        $pdf->cell(30, 5, 'Nominal Pajak', 1, 0, 'C');
        $pdf->cell(36, 5, 'Tanggal PKB', 1, 0, 'C');

        $pdf->Ln(5);
// set font
        $pdf->SetFont('Times', '', 9);

        $this->db->select('*');
        $this->db->from('kendaraan');
        $this->db->join('pajak', 'pajak.nomor_polisi = kendaraan.nomor_polisi');
        $this->db->where('jenis_kendaraan', 'Mobil');
        $query = $this->db->get();
        $data_kendaraan = $query->result();
        // $data_kendaraan = $this->db->join('pajak', 'pajak.nomor_polisi = kendaraan.nomor_polisi')->result();
        // $data_kendaraan = $this->db->get_where('kendaraan', array('jenis_kendaraan' => 'Motor'))->result();
        // set penomoran
        $nomor = 1;

        foreach ($data_kendaraan as $kendaraan) {
            $pdf->cell(8, 5, $nomor++ . '.', 1, 0, 'C');
            $pdf->cell(50, 5, ucfirst($kendaraan->merk), 1, 0, 'S');
            $pdf->cell(50, 5, ucfirst($kendaraan->tipe), 1, 0, 'C');
            $pdf->cell(25, 5, substr(ucfirst($kendaraan->nomor_polisi), 0, 17), 1, 0, 'C');
            $pdf->cell(30, 5, substr(strtoupper($kendaraan->pajak), 0, 10), 1, 0, 'C');
            $pdf->cell(36, 5, ucfirst(tgl_indo(date('Y-m-d', strtotime($kendaraan->tgl_pkb)))), 1, 0, 'C');
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
