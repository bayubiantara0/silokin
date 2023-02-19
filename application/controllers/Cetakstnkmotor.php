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
class Cetakstnkmotor extends CI_Controller
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
            $dari_tgl = $_POST['tgl_a'];
            $sampai_tgl = $_POST['tgl_b'];
            $this->db->select('*');
            $this->db->from('kendaraan');
            $this->db->join('pajak', 'pajak.nomor_polisi = kendaraan.nomor_polisi');
            $this->db->where('jenis_kendaraan', 'Motor');
            $this->db->where('tgl_pkb BETWEEN "' . $dari_tgl . '" AND "' . $sampai_tgl . '"');
            $query = $this->db->get();
            $data_kendaraan = $query->result();
        } else {
            $this->db->query("SELECT * FROM kendaraan");
            $query = $this->db->get();
            $data_kendaraan = $query->result();
        }
        while ($row = mysqli_fetch_assoc($query)) {
            $data_kendaraan[] = $row;
        }

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

        // set font
        $pdf->SetFont('Times', '', 12);
        $pdf->cell(177, 7, ' Subang, ' . tgl_indo(date('Y-m-d')), 0, 0, 'R');
        $pdf->Ln(10);

        $pdf->cell(30, 7, 'Nomor', 0, 0, 'L');
        $pdf->cell(3, 7, ':', 0, 0, 'L');
        $pdf->cell(20, 7, 'P1.04/ ... /Sekret', 0, 0, 'L');
        $pdf->cell(96, 7, 'Kepada  :', 0, 0, 'R');
        $pdf->Ln(4);

        $pdf->cell(30, 7, 'Sifat', 0, 0, 'L');
        $pdf->cell(3, 7, ':', 0, 0, 'L');
        $pdf->cell(20, 7, 'Biasa', 0, 0, 'L');
        $pdf->Ln(4);

        $pdf->cell(30, 7, 'Lampiran', 0, 0, 'L');
        $pdf->cell(3, 7, ':', 0, 0, 'L');
        $pdf->cell(20, 7, '1 (Satu) Berkas', 0, 0, 'L');
        $pdf->cell(106, 7, 'Yth. Samsat Subang', 0, 0, 'R');
        $pdf->Ln(4);

        $pdf->cell(30, 7, 'Perihal', 0, 0, 'L');
        $pdf->cell(3, 7, ':', 0, 0, 'L');
        $pdf->cell(20, 7, 'Perpanjangan STNK Roda 2', 0, 0, 'L');
        $pdf->cell(83, 7, 'di', 0, 0, 'R');
        $pdf->Ln(4);
        $pdf->cell(30, 7, '', 0, 0, 'L');
        $pdf->cell(3, 7, '', 0, 0, 'L');
        $pdf->cell(20, 7, 'Dinas/Operasional', 0, 0, 'L');
        $pdf->cell(106, 7, 'Subang', 0, 0, 'R');
        $pdf->Ln(15);

        $pdf->cell(49, 7, '', 0, 0, 'L');
        $pdf->cell(133, 7, 'Bersama ini kami  sampaikan dengan  hormat berkas Permohonan Perpanjangan', 0, 0, 'J');
        $pdf->Ln(6);
        $pdf->cell(33, 7, '', 0, 0, 'L');
        $pdf->cell(100, 7, 'Pajak    STNK    Kendaraan    Dinas / Operasional   Roda 2  (Dua)  Dinas   Pemberdayaan', 0, 0, 'J');
        $pdf->Ln(6);
        $pdf->cell(33, 7, '', 0, 0, 'L');
        $pdf->cell(100, 7, 'Masyarakat dan Desa  (DISPEMDES) Kabupaten Subang sebagai berikut :', 0, 0, 'J');
        $pdf->Ln(12);

        $pdf->cell(33, 4, '', 0, 0, 'L');
        $pdf->cell(8, 7, 'NO.', 1, 0, 'C');
        $pdf->cell(15, 7, 'Jenis', 1, 0, 'C');
        $pdf->cell(50, 7, 'Merk', 1, 0, 'C');
        $pdf->cell(36, 7, 'Type', 1, 0, 'C');
        $pdf->cell(29, 7, 'Nomor Polisi', 1, 0, 'C');
        $pdf->cell(15, 7, 'Ket', 1, 0, 'C');

// set penomoran
        $pdf->Ln(7);
        $nomor = 1;
        foreach ($data_kendaraan as $kendaraan) {
            $pdf->cell(33, 4, '', 0, 0, 'L');
            $pdf->cell(8, 7, $nomor++ . '.', 1, 0, 'C');
            $pdf->cell(15, 7, ucfirst($kendaraan->jenis_kendaraan), 1, 0, 'C');
            $pdf->cell(50, 7, ucfirst($kendaraan->merk), 1, 0, 'C');
            $pdf->cell(36, 7, strtoupper($kendaraan->tipe), 1, 0, 'L');
            $pdf->cell(29, 7, strtoupper($kendaraan->nomor_polisi), 1, 0, 'C');
            $pdf->cell(15, 7, strtoupper(""), 1, 0, 'C');
            $pdf->Ln(7);
        }
        $pdf->Ln(5);
        $pdf->cell(49, 7, '', 0, 0, 'L');
        $pdf->cell(133, 7, 'Demikian     Permohonan     Perpanjangan   Pajak   STNK    yang    dapat   kami', 0, 0, 'J');
        $pdf->Ln(6);
        $pdf->cell(33, 7, '', 0, 0, 'L');
        $pdf->cell(100, 7, 'sampaikan,  atas perhatian dan perkenannya kami ucapkan terima kasih.', 0, 0, 'J');
        $pdf->Ln(12);

        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(100, 7, 'An. Kepala DISPEMDES Kabupaten Subang', 0, 0, 'C');
        $pdf->Ln(6);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(100, 7, 'Sekretaris', 0, 0, 'C');
        $pdf->Ln(6);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(100, 7, 'Ub.', 0, 0, 'C');
        $pdf->Ln(6);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(100, 7, 'Kasubag Keuangan dan Barang Daerah', 0, 0, 'C');
        $pdf->Ln(25);

        $pdf->SetFont('Times', 'BU', 12);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(100, 7, 'AEP SEPTIYANDI, S.Hut, M.AP', 0, 0, 'C');
        $pdf->Ln(4);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->cell(93, 7, '', 0, 0, 'L');
        $pdf->cell(100, 7, 'NIP. 19770930 200801 1 002', 0, 0, 'C');
        $pdf->Output();

    }
}
