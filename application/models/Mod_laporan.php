<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_laporan extends CI_Model
{
    public $table = 'laporan';
    public $column_order = array('ringkas', 'nomor_polisi', 'dari', 'tgl_masuk', 'berkas');
    public $column_search = array('ringkas', 'nomor_polisi', 'dari', 'tgl_masuk', 'berkas');
    public $order = array('id' => 'desc'); // default order
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->from('laporan');
        $this->db->order_by('tgl_masuk', 'desc');
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

        $this->db->from('laporan');
        return $this->db->count_all_results();
    }

    public function getAll()
    {
        return $this->db->get("laporan");
    }
    public function getLaporan($id)
    {
        $this->db->where("id", $id);
        return $this->db->get("laporan")->row();
    }

    public function count_all_laporan()
    {
        $hasil = $this->db->query('SELECT COUNT(id) as total_laporan FROM laporan');
        return $hasil;
    }
    public function get_laporan($id)
    {
        $this->db->select('berkas');
        $this->db->from('laporan');
        $this->db->where('id', $id);
        return $this->db->get();
    }

    public function insert_laporan($data)
    {
        $insert = $this->db->insert('laporan', $data);
        return $insert;
    }

    public function updateLaporan($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('laporan', $data);
    }

    public function getImage($id)
    {
        $this->db->select('berkas');
        $this->db->from('laporan');
        $this->db->where('id', $id);
        return $this->db->get();
    }
    public function delete_lpr($id, $table)
    {
        $this->db->where('id', $id);
        $this->db->delete($table);
    }
}
