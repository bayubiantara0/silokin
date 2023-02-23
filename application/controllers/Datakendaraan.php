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

class Datakendaraan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mod_kendaraan'));
    }

    public function index()
    {
        $data['title'] = "Data Kendaraan";
        $this->load->helper('url');
        $this->template->load('layoutbackend', 'datakendaraan', $data);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_kendaraan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pel) {
            $no++;
            $row = array();
            $row[] = $pel->jenis_kendaraan;
            $row[] = $pel->merk;
            $row[] = $pel->tipe;
            $row[] = $pel->tahun_penerbitan;
            $row[] = $pel->nomor_polisi;
            $row[] = $pel->no_rangka;
            $row[] = $pel->pemilik;
            $row[] = $pel->berita;
            $row[] = $pel->stnk;
            $row[] = $pel->id;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_kendaraan->count_all(),
            "recordsFiltered" => $this->Mod_kendaraan->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function insert()
    {
        $this->_validate();
        $jenis = $this->input->post('jenis');
        $merk = $this->input->post('merk');
        $tipe = $this->input->post('type');
        $tahun = $this->input->post('tahun');
        $warna = $this->input->post('warna');
        $nomor = $this->input->post('nopol');
        $no = $this->input->post('nomor');
        $bahan = $this->input->post('bahan');
        $pemegang = $this->input->post('pemegang');
        $berita = $this->input->post('berita');
        $stnk = $this->input->post('stnk');

        $config['upload_path'] = './assets/stnk/';
        $config['allowed_types'] = 'jpg|png|jpeg|gif|docx|doc|pdf'; //mencegah upload backdor
        $config['max_size'] = '2048';
        $config['file_name'] = $stnk;

        $this->upload->initialize($config);
        if (!empty($_FILES['stnk']['name'])) {
            if ($this->upload->do_upload('stnk')) {
                $file = $this->upload->data();
                $data = array(

                    'jenis_kendaraan' => $jenis,
                    'merk' => $merk,
                    'tipe' => $tipe,
                    'tahun_penerbitan' => $tahun,
                    'warna' => $warna,
                    'nomor_polisi' => $nomor,
                    'no_rangka' => $no,
                    'bahan_bakar' => $bahan,
                    'pemilik' => $pemegang,
                    'berita' => $berita,
                    'stnk' => $file['file_name'],

                );

                $this->Mod_kendaraan->insert_barang($data);
                echo json_encode(array("status" => true));
            } else {
                die("gagal upload");
            }
        } else {
            echo "tidak masuk";
        }
    }

    public function update()
    {
        if (!empty($_FILES['stnk']['name'])) {
            $this->_validate();
            $id = $this->input->post('id');

            $jenis = $this->input->post('jenis');
            $merk = $this->input->post('merk');
            $tipe = $this->input->post('type');
            $tahun = $this->input->post('tahun');
            $warna = $this->input->post('warna');
            $nomor = $this->input->post('nopol');
            $no = $this->input->post('nomor');
            $bahan = $this->input->post('bahan');
            $pemegang = $this->input->post('pemegang');
            $berita = $this->input->post('berita');
            $stnk = $this->input->post('stnk');

            $config['upload_path']   = './assets/stnk/';
            $config['allowed_types'] = 'jpg|png|jpeg|gif|docx|doc|pdf'; //mencegah upload backdor
            $config['max_size']      = '2048';
            $config['file_name']     = $stnk;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('stnk')) {
                $file = $this->upload->data();
                $save  = array(
                    'jenis_kendaraan' => $jenis,
                    'merk' => $merk,
                    'tipe' => $tipe,
                    'tahun_penerbitan' => $tahun,
                    'warna' => $warna,
                    'nomor_polisi' => $nomor,
                    'no_rangka' => $no,
                    'bahan_bakar' => $bahan,
                    'pemilik' => $pemegang,
                    'berita' => $berita,
                    'stnk' => $file['file_name'],
                );

                $g = $this->Mod_kendaraan->get_kendaraan($id)->row_array();

                if ($g != null) {
                    //hapus gambar yg ada diserver
                    unlink('assets/stnk/' . $g['stnk']);
                }

                $this->Mod_kendaraan->update_barang($id, $save);
                echo json_encode(array("status" => TRUE));
            } else { //Apabila tidak ada gambar yang di upload
                $save  = array(
                    'jenis_kendaraan' => $jenis,
                    'merk' => $merk,
                    'tipe' => $tipe,
                    'tahun_penerbitan' => $tahun,
                    'warna' => $warna,
                    'nomor_polisi' => $nomor,
                    'no_rangka' => $no,
                    'bahan_bakar' => $bahan,
                    'pemilik' => $pemegang,
                    'berita' => $berita,
                );
                $this->Mod_kendaraan->update_barang($id, $save);
                echo json_encode(array("status" => TRUE));
            }
        } else {
            $this->_validate();
            $id = $this->input->post('id');
            $jenis = $this->input->post('jenis');
            $merk = $this->input->post('merk');
            $tipe = $this->input->post('type');
            $tahun = $this->input->post('tahun');
            $warna = $this->input->post('warna');
            $nomor = $this->input->post('nopol');
            $no = $this->input->post('nomor');
            $bahan = $this->input->post('bahan');
            $pemegang = $this->input->post('pemegang');
            $berita = $this->input->post('berita');
            $stnk = $this->input->post('stnk');

            $save  = array(
                'jenis_kendaraan' => $jenis,
                'merk' => $merk,
                'tipe' => $tipe,
                'tahun_penerbitan' => $tahun,
                'warna' => $warna,
                'nomor_polisi' => $nomor,
                'no_rangka' => $no,
                'bahan_bakar' => $bahan,
                'pemilik' => $pemegang,
                'berita' => $berita,
            );
            $this->Mod_kendaraan->update_barang($id, $save);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function viewkendaraan()
    {
        $id = $this->input->post('id');
        $table = $this->input->post('table');
        $data['table'] = $table;
        $data['data_field'] = $this->db->field_data($table);
        $data['data_table'] = $this->Mod_kendaraan->view_kendaraan($id)->result_array();
        $this->load->view('admin/view', $data);
    }

    public function edit_barang($id)
    {
        $data = $this->Mod_kendaraan->get_brg($id);
        echo json_encode($data);
    }

    public function delete()
    {

        $id = $this->input->post('id');

        $data = $this->Mod_kendaraan->get_kendaraan($id)->row();
        $nama = './assets/stnk/' . $data->stnk;

        if (is_readable($nama) && unlink($nama)) {
            $hapus = $this->Mod_kendaraan->delete_brg($id, 'kendaraan');
            echo json_encode(array("status" => true));
        } else {
            echo "Gagal";
            echo $nama;
        }
    }
    public function download()
    {
        $id = $this->input->post('id');

        $data = $this->Mod_kendaraan->get_kendaraan($id)->row();

        $dir = "./assets/stnk/";
        $filename = $data->stnk;
        $file_path = $dir . $filename;
        $ctype = "application/octet-stream";
        if (!empty($file_path) && file_exists($file_path)) { /*check keberadaan file*/
            header("Pragma:public");
            header("Expired:0");
            header("Cache-Control:must-revalidate");
            header("Content-Control:public");
            header("Content-Description: File Transfer");
            header("Content-Type: $ctype");
            header("Content-Disposition:attachment; filename=\"" . basename($file_path) . "\"");
            header("Content-Transfer-Encoding:binary");
            header("Content-Length:" . filesize($file_path));
            flush();
            readfile($file_path);
            exit();
        } else {
            echo "The File does not exist.";
        }
    }
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;

        if ($this->input->post('jenis') == '') {
            $data['inputerror'][] = 'jenis';
            $data['error_string'][] = 'Jenis Kendaraan Tidak Boleh Kosong';
            $data['status'] = false;
        }

        if ($this->input->post('merk') == '') {
            $data['inputerror'][] = 'merk';
            $data['error_string'][] = 'Merk Tidak Boleh Kosong';
            $data['status'] = false;
        }

        if ($this->input->post('type') == '') {
            $data['inputerror'][] = 'type';
            $data['error_string'][] = 'Type Tidak Boleh Kosong';
            $data['status'] = false;
        }
        if ($this->input->post('tahun') == '') {
            $data['inputerror'][] = 'tahun';
            $data['error_string'][] = 'Tahun Penerbitan Tidak Boleh Kosong';
            $data['status'] = false;
        }

        if ($this->input->post('warna') == '') {
            $data['inputerror'][] = 'warna';
            $data['error_string'][] = 'Warna Tidak Boleh Kosong';
            $data['status'] = false;
        }

        if ($this->input->post('nopol') == '') {
            $data['inputerror'][] = 'nopol';
            $data['error_string'][] = 'Nomor Polisi Tidak Boleh Kosong';
            $data['status'] = false;
        }
        if ($this->input->post('nomor') == '') {
            $data['inputerror'][] = 'nomor';
            $data['error_string'][] = 'Nomor Rangka Tidak Boleh Kosong';
            $data['status'] = false;
        }

        if ($this->input->post('bahan') == '') {
            $data['inputerror'][] = 'bahan';
            $data['error_string'][] = 'Bahan Bakar Tidak Boleh Kosong';
            $data['status'] = false;
        }

        if ($this->input->post('pemegang') == '') {
            $data['inputerror'][] = 'pemegang';
            $data['error_string'][] = 'Pemegang Tidak Boleh Kosong';
            $data['status'] = false;
        }
        if ($this->input->post('berita') == '') {
            $data['inputerror'][] = 'berita';
            $data['error_string'][] = 'No Berita Acara Tidak Boleh Kosong';
            $data['status'] = false;
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }
}
