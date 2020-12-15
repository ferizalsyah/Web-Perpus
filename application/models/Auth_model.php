<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function login($email, $password)
    {
        $this->db->select('email,id_anggota');
        $this->db->where(array('email' => $email, 'password' => $password));
        $query = $this->db->get('tb_anggota');
        return $query;
    }
}
