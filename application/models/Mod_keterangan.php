<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_keterangan extends CI_Model
{
    public $table = 'tbl_ket';
    public $column_search = array('nama', 'keterangan');
    public $column_order = array('nama', 'keterangan');
    public $order = array('id' => 'desc');
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {

        $this->db->from('tbl_ket');
        $this->db->order_by('nama');
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

    public function view_keterangan($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('tbl_ket');
    }

    public function count_all()
    {
        $this->db->from('tbl_ket');
        return $this->db->count_all_results();
    }
    public function count_all_keterangan()
    {
        $hasil = $this->db->query('SELECT COUNT(id) as total_ket FROM tbl_ket');
        return $hasil;
    }

    public function insert_barang($table, $data)
    {
        $insert = $this->db->insert($table, $data);
        return $insert;
    }

    public function update_barang($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_ket', $data);
    }
    public function getdata()
    {
        $query = $this->db->query("SELECT * FROM tbl_ket");
        return $query->result();
    }

    public function get_brg($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('tbl_ket')->row();
    }

    public function delete_brg($id, $table)
    {
        $this->db->where('id', $id);
        $this->db->delete($table);
    }

}
