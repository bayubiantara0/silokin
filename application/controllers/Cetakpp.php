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
class Cetakpp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Pdf'); // MEMANGGIL LIBRARY YANG KITA BUAT TADI
    }

    public function index()
    {
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
        // ambil dari database
        if (isset($_POST['surat'])) {
            $nopol = $_POST['nmr_polisi'];
            $service = $_POST['service'];
            $perawatan = $_POST['perawatan'];
            $no = $_POST['no'];
        } else {
            die("Error. No Selected!");
        }

        $data_kendaraan = $this->db->get_where('kendaraan', array('nomor_polisi' => $nopol))->result();
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
        $pdf->SetFont('Times', '', 12);
        $pdf->cell(150, 7, 'Kepada yth :', 0, 0, 'R');
        $pdf->cell(20, 7, ($service), 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->cell(156, 7, 'Di', 0, 0, 'R');
        $pdf->Ln(5);
        $pdf->cell(164, 7, 'Subang', 0, 0, 'R');
        $pdf->Ln(12);
        $pdf->SetFont('Times', 'U', 12);
        $pdf->cell(200, 7, 'SURAT PENGANTAR', 0, 0, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('Times', '', 12);

        $pdf->cell(200, 7, 'No : PL.07/  .  .  .  /Service-DPMD/2022', 0, 0, 'C');
        $pdf->Ln(8);
        $pdf->cell(55, 7, 'Mohon   dilakukan   pemeriksaan   pada   kendaraan   berikut   ini   :', 0, 0, 'L');
        $pdf->Ln(4);

        $pdf->Ln(6);
// set font
        $pdf->SetFont('Times', '', 12);

// set penomoran

        $nomor = 1;
        $pdf->cell(55, 7, 'Jenis Kendaraan', 1, 0, 'L');
        $pdf->cell(144, 7, ucfirst($data_kendaraan[0]->merk . ' ' . $data_kendaraan[0]->tipe), 1, 1, 'L');

        $pdf->cell(55, 7, 'Warna', 1, 0, 'L');
        $pdf->cell(144, 7, substr(ucfirst($data_kendaraan[0]->warna), 0, 17), 1, 1, 'L');

        $pdf->cell(55, 7, 'Tahun Pembuatan / Perakitan', 1, 0, 'L');
        $pdf->cell(144, 7, strtoupper($data_kendaraan[0]->tahun_penerbitan), 1, 1, 'L');

        $pdf->cell(55, 7, 'Plat Nomor', 1, 0, 'L');
        $pdf->cell(144, 7, substr(strtoupper($data_kendaraan[0]->nomor_polisi), 0, 10), 1, 1, 'L');

        $pdf->cell(55, 7, 'Jenis Perawatan / Perbaikan', 'LR', 0, 'L');
        $pdf->cell(144, 7, '', 'LR', 0, 'L');
        $pdf->ln();

        foreach ($perawatan as $pilih) {
            $pdf->cell(55, 7, '', 'LR', 0, 'L');
            $pdf->cell(144, 7, substr(ucfirst('- ' . $pilih), 0, 100), 'LR', 0, 'L');
            $pdf->ln();
        }

        $pdf->cell(55, 7, '', 'LR', 0, 'L');
        $pdf->cell(144, 7, '', 'LR', 0, 'L');
        $pdf->ln();
        $pdf->cell(55, 7, '', 'LR', 0, 'L');
        $pdf->cell(144, 7, '', 'LR', 0, 'L');
        $pdf->ln();

        $pdf->cell(55, 7, 'Stnk', 1, 0, 'L');
        $pdf->cell(144, 7, 'Fotocopy Terlampir', 1, 1, 'L');

        $pdf->SetFont('Times', '', 12);
        $pdf->Ln(4);
        $pdf->cell(55, 7, 'Semua     biaya     perbaikan,    penggantian    sparepart,     dan     jasa     service    mohon     ditagihkan     ke    Dinas', 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->cell(55, 7, 'Pemberdayaan   Masyarakat   dan   Desa   Kab.   Subang   sesuai   ketentuan   dalam   Kontrak    Kerjasama   Service', 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->cell(55, 7, 'No. ' . $no, 0, 0, 'L');
        $pdf->Ln(8);
        $pdf->cell(55, 7, 'Atas   kerjasamanya   kami   ucapkan   terima   kasih.', 0, 0, 'L');

        $pdf->Ln(18);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(135, 7, 'Subang, ' . tgl_indo(date('Y-m-d')), 0, 0, 'C');
        $pdf->Ln(4);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(135, 7, 'Kasubag Umum dan Kepegawaian', 0, 0, 'C');
        $pdf->Ln(25);

        $pdf->SetFont('Times', 'BU', 12);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(135, 7, 'Iif Arif Rosyidi, S.Sos', 0, 0, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(135, 7, 'NIP. 19790427 201001 1 009', 0, 0, 'C');

        $pdf->Output();

    }
}
