<?php
defined('BASEPATH') or exit('No direct script access allowed');

function buatRupiah($angka)
{
    $hasil = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil;
}

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

class Keterangan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mod_keterangan'));
        //$this->load->model('Mod_pengajuanperawatan');
    }

    public function index()
    {
        $data['title'] = "Keterangan";
        $data['tbl_ket'] = $this->Mod_keterangan->getdata();
        $this->load->helper('url');
        $this->template->load('layoutbackend', 'admin/keterangan', $data);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_keterangan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pel) {
            $no++;
            $row = array();
            $row[] = $pel->nama;
            $row[] = $pel->keterangan;
            $row[] = $pel->id;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_keterangan->count_all(),
            "recordsFiltered" => $this->Mod_keterangan->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function insert()
    {
        $this->_validate();
        $kode = date('ymsi');
        $save = array(
            'nama' => $this->input->post('jenis'),
            'keterangan' => $this->input->post('ket'),

        );
        $this->Mod_keterangan->insert_barang("tbl_ket", $save);
        echo json_encode(array("status" => true));
    }

    public function update()
    {
        $this->_validate();
        $id = $this->input->post('id');
        $save = array(
            'nama' => $this->input->post('jenis'),
            'keterangan' => $this->input->post('ket'),
        );
        $this->Mod_keterangan->update_barang($id, $save);
        echo json_encode(array("status" => true));
    }

    public function edit_barang($id)
    {
        $data = $this->Mod_keterangan->get_brg($id);
        echo json_encode($data);
    }

    public function delete()
    {
        $id = $this->input->post('id');
        $this->Mod_keterangan->delete_brg($id, 'tbl_ket');
        echo json_encode(array("status" => true));
    }
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;

        if ($this->input->post('jenis') == '') {
            $data['inputerror'][] = 'jenis';
            $data['error_string'][] = 'Jenis Tidak Boleh Kosong';
            $data['status'] = false;
        }

        if ($this->input->post('ket') == '') {
            $data['inputerror'][] = 'ket';
            $data['error_string'][] = 'Keterangan Tidak Boleh Kosong';
            $data['status'] = false;
        }
    }
}
