<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class jumlah_model extends CI_Model
{

    public function jumlahAnggota()
    {
        $query = $this->db->get('tb_anggota');
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }
}
