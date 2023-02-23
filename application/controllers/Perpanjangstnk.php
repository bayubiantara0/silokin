<?php defined('BASEPATH') or exit('No direct script access allowed');

class Perpanjangstnk extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_pengajuanperawatan');
    }

    public function index()
    {
        $data['title'] = "Surat Pajak dan STNK";
        $data['kendaraan'] = $this->Mod_pengajuanperawatan->getdata();
        $this->load->helper('url');
        $this->template->load('layoutbackend', 'perpanjangstnk', $data);
    }
}
