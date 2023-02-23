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

class Datapajak extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mod_pajak'));
        $this->load->model('Mod_pengajuanperawatan');
    }

    public function index()
    {
        $data['title'] = "Data Pajak";
        $data['kendaraan'] = $this->Mod_pengajuanperawatan->getdata();
        $data['notif'] = $this->Mod_pajak->notif();
        $this->load->helper('url');
        $this->template->load('layoutbackend', 'datapajak', $data);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_pajak->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pel) {
            $no++;
            $row = array();
            $row[] = $pel->nomor_polisi;
            $row[] = buatRupiah($pel->pajak);
            $row[] = tgl_indo(date('Y-m-d', strtotime($pel->tgl_pkb)));
            $row[] = $pel->id;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_pajak->count_all(),
            "recordsFiltered" => $this->Mod_pajak->count_filtered(),
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
            'nomor_polisi' => $this->input->post('nmr_polisi'),
            'pajak' => $this->input->post('pajak'),
            'tgl_pkb' => $this->input->post('tgl'),

        );
        $this->Mod_pajak->insert_barang("pajak", $save);
        echo json_encode(array("status" => true));
    }

    public function update()
    {
        $this->_validate();
        $id = $this->input->post('id');
        $save = array(
            'nomor_polisi' => $this->input->post('nmr_polisi'),
            'pajak' => $this->input->post('pajak'),
            'tgl_pkb' => $this->input->post('tgl'),
        );
        $this->Mod_pajak->update_barang($id, $save);
        echo json_encode(array("status" => true));
    }

    public function viewpajak()
    {
        $id = $this->input->post('id');
        $table = $this->input->post('table');
        $data['table'] = $table;
        $data['data_field'] = $this->db->field_data($table);
        $data['data_table'] = $this->Mod_pajak->view_pajak($id)->result_array();
        $this->load->view('admin/view', $data);
    }

    public function edit_barang($id)
    {
        $data = $this->Mod_pajak->get_brg($id);
        echo json_encode($data);
    }

    public function delete()
    {
        $id = $this->input->post('id');
        $this->Mod_pajak->delete_brg($id, 'pajak');
        echo json_encode(array("status" => true));
    }
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;

        if ($this->input->post('nmr_polisi') == '') {
            $data['inputerror'][] = 'nmr_polisi';
            $data['error_string'][] = 'Nomor Polisi Tidak Boleh Kosong';
            $data['status'] = false;
        }

        if ($this->input->post('pajak') == '') {
            $data['inputerror'][] = 'pajak';
            $data['error_string'][] = 'Pajak Tidak Boleh Kosong';
            $data['status'] = false;
        }

        if ($this->input->post('tgl') == '') {
            $data['inputerror'][] = 'tgl';
            $data['error_string'][] = 'Tanggal Akhir PKB Tidak Boleh Kosong';
            $data['status'] = false;
        }
    }
}
