<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuanperawatan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_pengajuanperawatan');
    }

    public function index()
    {
        $data['title'] = "Surat Perawatan";
        $data['kendaraan'] = $this->Mod_pengajuanperawatan->getdata();
        $data['tujuan'] = $this->Mod_pengajuanperawatan->gettujuan();
        $data['ketentuan'] = $this->Mod_pengajuanperawatan->getketentuan();
        $this->load->helper('url');
        $this->template->load('layoutbackend', 'pengajuanperawatan', $data);
    }
}
