<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_pengajuanperawatan extends CI_Model
{
    public function getdata()
    {
        $query = $this->db->query("SELECT * FROM kendaraan");
        return $query->result();
    }

    public function gettujuan()
    {
        $query = $this->db->query("SELECT * FROM tbl_ket WHERE nama='Tujuan Service'");
        return $query->result();
    }

    public function getketentuan()
    {
        $query = $this->db->query("SELECT * FROM tbl_ket WHERE nama='No Ketentuan'");
        return $query->result();
    }
}
