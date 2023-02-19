<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_kendaraan extends CI_Model
{
    public $table = 'kendaraan';
    public $column_search = array('jenis_kendaraan', 'merk', 'tipe', 'tahun_penerbitan', 'warna', 'nomor_polisi', 'no_rangka', 'bahan_bakar', 'pemilik', 'berita', 'stnk');
    public $column_order = array('jenis_kendaraan', 'merk', 'tipe', 'tahun_penerbitan', 'warna', 'nomor_polisi', 'no_rangka', 'bahan_bakar', 'pemilik', 'berita', 'stnk');
    public $order = array('id' => 'desc');
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {

        $this->db->from('kendaraan');
        $this->db->order_by('jenis_kendaraan','asc');
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
    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function view_kendaraan($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('kendaraan');
    }

    public function count_all()
    {
        $this->db->from('kendaraan');
        return $this->db->count_all_results();
    }

    public function count_all_kendaraan()
    {
        $hasil = $this->db->query('SELECT COUNT(id) as total_kendaraan FROM kendaraan');
        return $hasil;
    }

    public function insert_barang($data)
    {
        $insert = $this->db->insert('kendaraan', $data);
        return $insert;
    }
    public function get_kendaraan($id)
    {
        $this->db->select('stnk');
        $this->db->from('kendaraan');
        $this->db->where('id', $id);
        return $this->db->get();
    }

    public function update_barang($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('kendaraan', $data);
    }

    public function get_brg($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('kendaraan')->row();
    }

    public function delete_brg($id, $table)
    {
        $this->db->where('id', $id);
        $this->db->delete($table);
    }

}
