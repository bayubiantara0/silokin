<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('fungsi');
        $this->load->library('user_agent');
        $this->load->helper('myfunction_helper');
        $this->load->model('Mod_permintaan');
        $this->load->model('Mod_kendaraan');
        $this->load->model('Mod_pajak');
        $this->load->model('Mod_laporan');
        // backButtonHandle();
    }

    public function index()
    {
        $logged_in = $this->session->userdata('id_level') == 1;
        if ($logged_in != true || empty($logged_in)) {
            redirect('login');
        } else {
            $data['title'] = "Dasboard";
            $data['permintaan'] = $this->Mod_permintaan->count_all_permintaan()->row_array();
            $data['permintaan_acc'] = $this->Mod_permintaan->count_all_permintaan_acc()->row_array();
            $data['permintaan_confirm'] = $this->Mod_permintaan->count_all_permintaan_confirm()->row_array();
            $data['permintaan_reject'] = $this->Mod_permintaan->count_all_permintaan_reject()->row_array();
            $data['datakendaraan'] = $this->Mod_kendaraan->count_all_kendaraan()->row_array();
            $data['datapajak'] = $this->Mod_pajak->count_all_pajak()->row_array();
            $data['laporan'] = $this->Mod_laporan->count_all_laporan()->row_array();
            $this->template->load('layoutbackend', 'dashboard/dashboard_data', $data);
        }
    }
}
/* End of file Controllername.php */
