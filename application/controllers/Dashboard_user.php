<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_user extends MY_Controller
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
        // backButtonHandle();
    }

    public function index()
    {
        $logged_in = $this->session->userdata('id_level') == 4;
        if ($logged_in != true || empty($logged_in)) {
            redirect('login');
        } else {
            $data['permintaan'] = $this->Mod_permintaan->count_all_permintaan_by_id($this->session->userdata('id_user'))->row_array();
            $data['permintaan_acc'] = $this->Mod_permintaan->count_all_permintaan_acc_by_id($this->session->userdata('id_user'))->row_array();
            $data['permintaan_confirm'] = $this->Mod_permintaan->count_all_permintaan_confirm_by_id($this->session->userdata('id_user'))->row_array();
            $data['permintaan_reject'] = $this->Mod_permintaan->count_all_permintaan_reject_by_id($this->session->userdata('id_user'))->row_array();
            $this->template->load('layoutbackend', 'dashboard/dashboard_user', $data);
        }

    }

}
/* End of file Controllername.php */
