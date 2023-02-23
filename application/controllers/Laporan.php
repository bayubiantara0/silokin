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
class Laporan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_laporan');
        $this->load->model('Mod_pengajuanperawatan');
    }

    public function index()
    {
        $data['title'] = "Laporan";
        $data['kendaraan'] = $this->Mod_pengajuanperawatan->getdata();
        $this->template->load('layoutbackend', 'admin/laporan', $data);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_laporan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $apl) {
            $no++;
            $row = array();
            $row[] = $apl->ringkas;
            $row[] = $apl->nomor_polisi;
            $row[] = $apl->dari;
            $row[] = tgl_indo(date('Y-m-d', strtotime($apl->tgl_masuk)));
            $row[] = $apl->berkas;
            $row[] = $apl->id;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_laporan->count_all(),
            "recordsFiltered" => $this->Mod_laporan->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit_laporan($id)
    {

        $data = $this->Mod_laporan->getLaporan($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate();
        $ringkas = $this->input->post('lampiran');
        $nopol = $this->input->post('nmr_polisi');
        $dari = $this->input->post('perujuk');
        $tgl_masuk = $this->input->post('masuk');
        $berkas = slug($this->input->post('berkas'));

        $config['upload_path'] = './assets/berkas/';
        $config['allowed_types'] = 'jpg|png|jpeg|gif|docx|doc|pdf'; //mencegah upload backdor
        $config['max_size'] = 2048;
        $config['file_name'] = $berkas;

        $this->upload->initialize($config);
        if (!empty($_FILES['berkas']['name'])) {
            if ($this->upload->do_upload('berkas')) {
                $file = $this->upload->data();
                $data = array(

                    'ringkas' => $ringkas,
                    'nomor_polisi' => $nopol,
                    'dari' => $dari,
                    'tgl_masuk' => $tgl_masuk,
                    'berkas' => $file['file_name'],

                );

                $this->Mod_laporan->insert_laporan($data);
                echo json_encode(array("status" => true));
            } else {
                die("gagal upload");
            }
        } else {
            echo "tidak masuk";
        }
    }
    public function download()
    {
        $id = $this->input->post('id');

        $data = $this->Mod_laporan->get_laporan($id)->row();

        $dir = "./assets/berkas/";
        $filename = $data->berkas;
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

    public function delete()
    {

        $id = $this->input->post('id');

        $data = $this->Mod_laporan->get_laporan($id)->row();
        $nama = './assets/berkas/' . $data->berkas;

        if (is_readable($nama) && unlink($nama)) {
            $hapus = $this->Mod_laporan->delete_lpr($id, 'laporan');
            echo json_encode(array("status" => true));
        } else {
            echo "Gagal";
            echo $nama;
        }
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;

        if ($this->input->post('lampiran') == '') {
            $data['inputerror'][] = 'lampiran';
            $data['error_string'][] = 'Jenis Lampiran Tidak Boleh kosong';
            $data['status'] = false;
        }
        if ($this->input->post('nmr_polisi') == '') {
            $data['inputerror'][] = 'nmr_polisi';
            $data['error_string'][] = 'Nomor Polisi Tidak Boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('perujuk') == '') {
            $data['inputerror'][] = 'perujuk';
            $data['error_string'][] = 'Perujuk Tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('masuk') == '') {
            $data['inputerror'][] = 'masuk';
            $data['error_string'][] = 'Tgl Surat Masuk Tidak boleh kosong';
            $data['status'] = false;
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }
}
