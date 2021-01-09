<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Peminjaman_model extends CI_Model
{
    public function get_data_peminjaman($id_pengguna, $status = 0)
    {
        $this->db->from('tb_detail_pinjam detail_pinjam');
        $this->db->select('buku.*, pinjam.*, detail_pinjam.*, kembali.*');
        $this->db->join('tb_pinjam pinjam', 'pinjam.id_pinjam=detail_pinjam.id_pinjam');
        $this->db->join('tb_buku buku', 'detail_pinjam.id_buku=buku.id_buku');
        $this->db->join('tb_kembali kembali', 'pinjam.id_pinjam=kembali.id_pinjam', 'left');
        $this->db->where('pinjam.status', $status);
        $this->db->where('pinjam.id_anggota', $id_pengguna)->group_by('detail_pinjam.id_buku');
        return $this->db->get();
    }

    public function getDataPinjam($id_pengguna)
    {
        $this->db->from('tb_pinjam pinjam');
        $this->db->select('buku.*, pinjam.*, detail_pinjam.*');
        $this->db->join('tb_detail_pinjam detail_pinjam', 'detail_pinjam.id_pinjam=pinjam.id_pinjam');
        $this->db->join('tb_buku buku', 'detail_pinjam.id_buku=buku.id_buku');
        $this->db->where('pinjam.id_anggota', $id_pengguna);
        return $this->db->get();
    }

    public function getPinjam($id_pengguna = null, $where = ['pinjam.status' => 0])
    {
        if ($id_pengguna) {
            $this->db->from('tb_pinjam pinjam');
            $this->db->select('pinjam.*, detail.*, kembali.terlambat as terlambat, kembali.denda, buku.foto, buku.judul, buku.foto');
            $this->db->join('tb_detail_pinjam detail', 'detail.id_pinjam=pinjam.id_pinjam');
            $this->db->join('tb_buku buku', 'buku.id_buku=detail.id_buku');
            $this->db->join('tb_kembali kembali', 'kembali.id_pinjam=pinjam.id_pinjam', 'left');
            $this->db->where($where);
            $this->db->where('pinjam.id_anggota', $id_pengguna);
            return $this->db->get('tb_pinjam');
        }
        return $this->db->get('tb_pinjam');
    }
}
