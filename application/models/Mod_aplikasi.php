<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_aplikasi extends CI_Model
{
    public $table = 'aplikasi';
    public $column_order = array('nama_owner', 'title', 'nama_aplikasi', 'logo', 'copy_right', 'versi');
    public $column_search = array('nama_owner', 'title', 'nama_aplikasi', 'copy_right');
    public $order = array('id' => 'desc'); // default order
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->from($this->table);
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

    public function count_all()
    {

        $this->db->from('aplikasi');
        return $this->db->count_all_results();
    }

    public function getAll()
    {
        return $this->db->get("aplikasi");
    }
    public function getAplikasi($id)
    {
        $this->db->where("id", $id);
        return $this->db->get("aplikasi")->row();
    }

    public function updateAplikasi($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('aplikasi', $data);
    }

    public function getImage($id)
    {
        $this->db->select('logo');
        $this->db->from('aplikasi');
        $this->db->where('id', $id);
        return $this->db->get();
    }
}
