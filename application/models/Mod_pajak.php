<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_pajak extends CI_Model
{
    public $table = 'pajak';
    public $column_search = array('pajak', 'tgl_pkb', 'nomor_polisi');
    public $column_order = array('pajak', 'tgl_pkb', 'nomor_polisi');
    public $order = array('id' => 'desc');
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {

        $this->db->from('pajak');
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

    public function view_pajak($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('pajak');
    }

    public function count_all()
    {
        $this->db->from('pajak');
        return $this->db->count_all_results();
    }
    public function count_all_pajak()
    {
        $hasil = $this->db->query('SELECT COUNT(id) as total_pajak FROM pajak');
        return $hasil;
    }

    public function notif()
    {
        $tgl = date("Y-m-d");
        $data=$this->db->query("SELECT COUNT(id) AS notif FROM pajak WHERE (tgl_pkb<'$tgl' OR tgl_pkb='$tgl' OR DATEDIFF(tgl_pkb,'$tgl')=30)");
        return $data;
    }

    public function insert_barang($table, $data)
    {
        $insert = $this->db->insert($table, $data);
        return $insert;
    }

    public function update_barang($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('pajak', $data);
    }

    public function get_brg($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('pajak')->row();
    }

    public function delete_brg($id, $table)
    {
        $this->db->where('id', $id);
        $this->db->delete($table);
    }

}
