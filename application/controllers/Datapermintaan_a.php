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

class Datapermintaan_a extends MY_Controller
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
        $this->template->load('layoutbackend', 'admin/datapermintaan_a', $data);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_permintaan->get_datatables_a();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pel) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $pel->username;
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
    public function ambilsetuju($id_permintaan)
    {
        $data = $this->Mod_permintaan->get_setuju($id_permintaan);
        echo json_encode($data);
    }
    public function updatesetuju()
    {
        $this->_validate();

        $id_permintaan = $this->input->post("id_permintaan");
        $alasan_verifikasi = $this->input->post("keterangan");

        $this->Mod_permintaan->update_setuju($id_permintaan, $alasan_verifikasi);
        echo json_encode(array("status" => true));
    }

    public function updatetolak()
    {
        $this->_validate();

        $id_permintaan = $this->input->post("id_permintaan");
        $alasan_verifikasi = $this->input->post("keterangan");

        $this->Mod_permintaan->update_tolak($id_permintaan, $alasan_verifikasi);
        echo json_encode(array("status" => true));
    }

    public function delete()
    {

        $id_user = $this->input->post('id_user');
        $id = $this->input->post('id_permintaan');

        $hasil = $this->Mod_permintaan->delete_cuti($id_permintaan);

        if ($hasil == false) {
            $this->session->set_flashdata('eror_hapus', 'eror_hapus');
        } else {
            $this->session->set_flashdata('hapus', 'hapus');
        }

        redirect('admin/datapermintaan_a' . $id_user);
    }
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;

        if ($this->input->post('keterangan') == '') {
            $data['inputerror'][] = 'keterangan';
            $data['error_string'][] = 'Keterangan Tidak Boleh Kosong';
            $data['status'] = false;
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }
}
