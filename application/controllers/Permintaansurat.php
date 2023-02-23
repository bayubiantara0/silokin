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

class Permintaansurat extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_permintaan');
        $this->load->model('Mod_user');
    }
    public function index()
    {
        $data['title'] = "Permintaan Surat";
        $this->load->helper('url');
        $this->template->load('layoutbackend', 'permintaansurat', $data);
    }

    public function view_user()
    {
        if ($this->session->userdata('logged_in') == true and $this->session->userdata('id_level') == 4) {

            $data['pegawai_data'] = $this->Mod_user->get_pegawai_by_id($this->session->userdata('id_user'))->result_array();
            $data['pegawai'] = $this->Mod_user->get_pegawai_by_id($this->session->userdata('id_user'))->row_array();
            $this->load->view('permintaansurat', $data);
        } else {

            $this->session->set_flashdata('loggin_err', 'loggin_err');
            redirect('permintaansurat');
        }
    }

    public function proses_permintaan()
    {
        if ($this->session->userdata('logged_in') == true and $this->session->userdata('id_level') == 4) {

            $id_user = $this->input->post('id_user');
            $permintaan = $this->input->post('permintaan');
            $keterangan = $this->input->post('keterangan');
            //$id_permintaan = md5($id_user . $permintaan . $keterangan);

            $id_status_permintaan = 1;

            $hasil = $this->Mod_permintaan->insert_data_permintaan($id_user, $permintaan, $keterangan, $id_status_permintaan);

            if ($hasil == false) {
                $this->session->set_flashdata('eror_input', 'eror_input');
            } else {
                $this->session->set_flashdata('input', 'input');
            }
            redirect('permintaansurat');
        } else {

            $this->session->set_flashdata('loggin_err', 'loggin_err');
            redirect('permintaansurat');
        }
    }
}
