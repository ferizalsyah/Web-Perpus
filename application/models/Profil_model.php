<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profil_model extends CI_Model
{
  public function getProfil($id)
  {
    $this->db->from('tb_anggota user');
    $this->db->select('user.*, agama.agama, kelas.kelas');
    $this->db->join('tb_agama agama', 'agama.id_agama=user.id_agama');
    $this->db->join('tb_kelas kelas', 'kelas.id_kelas=user.id_kelas');
    $this->db->where('user.id_anggota', $id);
    return $this->db->get();
  }
}
