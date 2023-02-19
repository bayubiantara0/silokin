<?php

class Mod_useer extends CI_Model
{

    public function get_all_pegawai()
    {
        $hasil = $this->db->query('SELECT * FROM tbl_user WHERE id_level = 4 ORDER BY user.username ASC');
        return $hasil;
    }

    public function count_all_pegawai()
    {
        $hasil = $this->db->query('SELECT COUNT(id_user) as total_user FROM tbl_user WHERE id_level = 4');
        return $hasil;
    }

    public function count_all_admin()
    {
        $hasil = $this->db->query('SELECT COUNT(id_user) as total_user FROM tbl_user
        WHERE id_level = 1');
        return $hasil;
    }

    public function get_all_admin()
    {
        $hasil = $this->db->query('SELECT * FROM tbl_user
        WHERE id_level = 1');
        return $hasil;
    }

    public function get_pegawai_by_id($id_user)
    {
        $hasil = $this->db->query("SELECT * FROM tbl_user WHERE id_user='$id_user'");
        return $hasil;
    }

    public function cek_login($username)
    {

        $hasil = $this->db->query("SELECT * FROM tbl_user WHERE username='$username'");
        return $hasil;

    }

}
