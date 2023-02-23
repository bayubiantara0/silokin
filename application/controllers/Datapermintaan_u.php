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

class Datapermintaan_u extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mod_permintaan'));
    }

    public function index()
    {
        $data['title'] = "Data Permintaan";
        $this->load->helper('url');
        $this->template->load('layoutbackend', 'datapermintaan_u', $data);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_permintaan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pel) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $pel->full_name;
            $row[] = $pel->permintaansurat;
            $row[] = $pel->keterangan;
            $row[] = tgl_indo(date('Y-m-d', strtotime($pel->tgl_diajukan)));
            $row[] = $pel->id_status_permintaan;
            $row[] = $pel->alasan_verifikasi;
            $row[] = $pel->id_permintaan;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_permintaan->count_all(),
            "recordsFiltered" => $this->Mod_permintaan->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete()
    {

        $id = $this->input->post('id_permintaan');
        $this->Mod_permintaan->delete_pn($id, 'permintaan');
        echo json_encode(array("status" => true));
    }
}
