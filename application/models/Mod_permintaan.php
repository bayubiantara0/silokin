<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_permintaan extends CI_Model
{
    public $table = 'permintaan';
    public $column_search = array('id_user', 'permintaansurat', 'tgl_diajukan', 'keterangan', 'id_status_permintaan', 'alasan_verifikasi', 'username', 'id_level');
    public $column_order = array('id_user', 'permintaansurat', 'tgl_diajukan', 'keterangan', 'id_status_permintaan', 'alasan_verifikasi', 'username', 'id_level');
    public $order = array('id_permintaan' => 'desc');
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $id = $this->session->userdata('id_user');

        $this->db->select('*');
        $this->db->from('permintaan');
        $this->db->join('tbl_user', 'tbl_user.id_user = permintaan.id_user');
        $this->db->where('tbl_user.id_user', $id);
        $this->db->order_by('username', 'desc');
        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                {
                    $this->db->group_end();
                }
                //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    private function _get_datatables_query_a()
    {
        $id = $this->session->userdata('id_user');

        $this->db->select('*');
        $this->db->from('permintaan');
        $this->db->join('tbl_user', 'tbl_user.id_user = permintaan.id_user');
        $this->db->order_by('tgl_diajukan', 'desc');
        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                {
                    $this->db->group_end();
                }
                //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }
    public function get_datatables_a()
    {
        $this->_get_datatables_query_a();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function view_kendaraan($id)
    {
        $this->db->where('id_permintaan', $id);
        return $this->db->get('permintaan');
    }

    public function count_all()
    {
        $this->db->select('*');
        $this->db->from('permintaan');
        $this->db->join('tbl_user', 'tbl_user.id_user = permintaan.id_user');
        return $this->db->count_all_results();
    }

    public function insert_barang($table, $data)
    {
        $insert = $this->db->insert($table, $data);
        return $insert;
    }

    public function update_setuju($id_permintaan, $alasan_verifikasi)
    {

        $this->db->query("UPDATE permintaan SET id_status_permintaan='2', alasan_verifikasi='$alasan_verifikasi' WHERE id_permintaan='$id_permintaan'");

    }

    public function update_tolak($id_permintaan, $alasan_verifikasi)
    {

        $this->db->query("UPDATE permintaan SET id_status_permintaan='3', alasan_verifikasi='$alasan_verifikasi' WHERE id_permintaan='$id_permintaan'");

    }

    public function get_setuju($id)
    {
        $this->db->where('id_permintaan', $id);
        return $this->db->get('permintaan')->row();
    }

    public function delete_pn($id, $table)
    {
        $this->db->where('id_permintaan', $id);
        $this->db->delete($table);
    }

    public function get_all_permintaan()
    {
        $hasil = $this->db->query('SELECT * FROM permintaan JOIN tbl_user ON permintaan.id_user = tbl_user.id_user ORDER BY tbl_user.username ASC');
        return $hasil;
    }

    public function get_all_permintaan_by_id_user($id_user)
    {
        $hasil = $this->db->query("SELECT * FROM permintaan JOIN tbl_user ON permintaan.id_user = tbl_user.id_user WHERE permintaan.id_user='$id_user'");
        return $hasil;
    }

    public function get_all_permintaan_first_by_id_user($id_user)
    {
        $hasil = $this->db->query("SELECT * FROM permintaan JOIN tbl_user ON permintaan.id_user = tbl_user.id_user WHERE permintaan.id_user='$id_user' AND permintaan.id_status_permintaan='2' ORDER BY permintaan.tgl_diajukan DESC LIMIT 1");
        return $hasil;
    }

    public function get_all_permintaan_by_id_permintaan($id_permintaan)
    {
        $hasil = $this->db->query("SELECT * FROM permintaan JOIN tbl_user ON permintaan.id_user = tbl_user.id_user WHERE permintaan.id_permintaan='$id_permintaan'");
        return $hasil;
    }

    public function insert_data_permintaan($id_user, $permintaan, $keterangan, $id_status_permintaan)
    {
        $this->db->trans_start();
        $this->db->query("INSERT INTO permintaan(id_user, permintaansurat, tgl_diajukan, keterangan, id_status_permintaan) VALUES ('$id_user','$permintaan',NOW(),'$keterangan', '$id_status_permintaan')");
        $this->db->trans_complete();
        if ($this->db->trans_status() == true) {
            return true;
        } else {
            return false;
        }

    }
    public function count_all_permintaan()
    {
        $hasil = $this->db->query('SELECT COUNT(id_permintaan) as total_permintaan FROM permintaan JOIN tbl_user ON permintaan.id_user = tbl_user.id_user');
        return $hasil;
    }

    public function count_all_permintaan_by_id($id_user)
    {
        $hasil = $this->db->query("SELECT COUNT(id_permintaan) as total_permintaan FROM permintaan JOIN tbl_user ON permintaan.id_user = tbl_user.id_user WHERE permintaan.id_user='$id_user'");
        return $hasil;
    }

    public function count_all_permintaan_acc()
    {
        $hasil = $this->db->query('SELECT COUNT(id_permintaan) as total_permintaan FROM permintaan JOIN tbl_user ON permintaan.id_user = tbl_user.id_user WHERE id_status_permintaan=2');
        return $hasil;
    }

    public function count_all_permintaan_acc_by_id($id_user)
    {
        $hasil = $this->db->query("SELECT COUNT(id_permintaan) as total_permintaan FROM permintaan JOIN tbl_user ON permintaan.id_user = tbl_user.id_user WHERE id_status_permintaan=2 AND permintaan.id_user='$id_user'");
        return $hasil;
    }

    public function count_all_permintaan_confirm()
    {
        $hasil = $this->db->query('SELECT COUNT(id_permintaan) as total_permintaan FROM permintaan JOIN tbl_user ON permintaan.id_user = tbl_user.id_user WHERE id_status_permintaan=1');
        return $hasil;
    }

    public function count_all_permintaan_confirm_by_id($id_user)
    {
        $hasil = $this->db->query("SELECT COUNT(id_permintaan) as total_permintaan FROM permintaan JOIN tbl_user ON permintaan.id_user = tbl_user.id_user WHERE id_status_permintaan=1 AND permintaan.id_user='$id_user'");
        return $hasil;
    }

    public function count_all_permintaan_reject()
    {
        $hasil = $this->db->query('SELECT COUNT(id_permintaan) as total_permintaan FROM permintaan JOIN tbl_user ON permintaan.id_user = tbl_user.id_user WHERE id_status_permintaan=3');
        return $hasil;
    }

    public function count_all_permintaan_reject_by_id($id_user)
    {
        $hasil = $this->db->query("SELECT COUNT(id_permintaan) as total_permintaan FROM permintaan JOIN tbl_user ON permintaan.id_user = tbl_user.id_user WHERE id_status_permintaan=3 AND permintaan.id_user='$id_user'");
        return $hasil;
    }

}
