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
class Cetakrowlaporan extends CI_Controller
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
        $pdf->Cell(200, 4, 'LAPORAN DOKUMEN', 0, 1, 'C');
        $pdf->Cell(200, 4, 'DINAS PEMBERDAYAAN MASYARAKAT DAN DESA', 0, 1, 'C');
        $pdf->Cell(200, 4, 'PERIODE TAHUN 2022', 0, 1, 'C');
        $pdf->Ln(3);

        $pdf->SetFont('Times', 'B', 9);

        $pdf->Ln(5);
// set font
        $pdf->SetFont('Times', '', 9);
        $id = $this->input->post('id');
        $this->db->select('*');
$this->db->from('laporan');
$this->db->where('id',$id);
$this->db->order_by('ringkas','asc');
$query=$this->db->get();
$data_laporan= $query->result();
// set penomoran
        $nomor = 1;
        $pdf->cell(55, 7, 'Jenis Dokumen', 1, 0, 'L');
        $pdf->cell(144, 7, ucfirst($data_laporan[0]->ringkas), 1, 1, 'L');

        $pdf->cell(55, 7, 'Nomor Polisi', 1, 0, 'L');
        $pdf->cell(144, 7, substr(ucfirst($data_laporan[0]->nomor_polisi), 0, 17), 1, 1, 'L');

        $pdf->cell(55, 7, 'Asal Dokumen', 1, 0, 'L');
        $pdf->cell(144, 7, strtoupper($data_laporan[0]->dari), 1, 1, 'L');

        $pdf->cell(55, 7, 'Tanggal Dokumen', 1, 0, 'L');
        $pdf->cell(144, 7, ucfirst(tgl_indo(date('Y-m-d', strtotime($data_laporan->tgl_masuk)))), 1, 1, 'L');

        $pdf->cell(55, 7, 'Dokumen', 1, 0, 'L');
        $pdf->cell(144, 7, 'Terlampir', 1, 1, 'L');

        $pdf->Ln(18);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(135, 7, 'Subang, ' . tgl_indo(date('Y-m-d')), 0, 0, 'C');
        $pdf->Ln(4);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(135, 7, '---------------------------', 0, 0, 'C');
        $pdf->Ln(25);

        $pdf->SetFont('Times', 'BU', 12);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(135, 7, '---------------------', 0, 0, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(135, 7, 'NIP. 1111111111111111111', 0, 0, 'C');

        $pdf->Output();
    }
}
