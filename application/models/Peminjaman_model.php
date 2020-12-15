<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Peminjaman_model extends CI_Model
{
    public function get_data_peminjaman($id_pengguna)
    {
        $this->db->from('tb_detail_pinjam detail_pinjam');
        $this->db->select('buku.*, pinjam.*, detail_pinjam.*');
        $this->db->join('tb_pinjam pinjam', 'pinjam.id_pinjam=detail_pinjam.id_pinjam');
        $this->db->join('tb_buku buku', 'detail_pinjam.id_buku=buku.id_buku');
        $this->db->where('pinjam.id_anggota', $id_pengguna);
        return $this->db->get();
    }
}
