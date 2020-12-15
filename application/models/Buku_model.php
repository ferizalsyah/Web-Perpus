<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Buku_model extends CI_Model
{

	public function search($q)
	{
		$this->qq = explode(' ', $q);
	}
	public function kategori($q)
	{
		if ($q == "a.id_buku") {
			$concat = " " . $q . "=" . ((int)addslashes(trim(implode(" ", $this->qq))));
		} else {
			$concat = "";
			foreach ($this->qq as $zx) {
				$concat .= ' ' . ($q) . ' LIKE \'%' . addslashes(strtolower(trim($zx))) . '%\' OR';
			}
		}

		$this->wheree = ' WHERE' . rtrim($concat, 'OR');
	}
	//query pengambilan semua data
	public function getAllData1()
	{
		return $this->db->query('SELECT a.id_buku,a.ISBN,a.judul,b.kategori,c.nama_penerbit,d.nama_pengarang,e.nama_rak,a.thn_terbit,a.stok,a.ket FROM tb_buku AS a INNER JOIN tb_kategori AS b ON a.id_kategori=b.id_kategori INNER JOIN tb_penerbit AS c ON a.id_penerbit=c.id_penerbit INNER JOIN tb_pengarang AS d ON a.id_pengarang=d.id_pengarang INNER JOIN tb_rak AS e ON a.no_rak=e.no_rak' . (isset($this->wheree) ? $this->wheree : ''));
	}

	public function get_all_rak()
	{
		return $this->db->get('tb_rak');
	}

	public function get_all_kategori()
	{
		return $this->db->get('tb_kategori');
	}

	public function getBukuBykategori($id) {
		$this->db->from('tb_buku buku');
		$this->db->select('buku.*, rak.nama_rak');
		$this->db->join('tb_rak rak', 'rak.no_rak=buku.no_rak');
		$this->db->where('buku.id_kategori', $id);
		return $this->db->get();
	}

	public function group_kat_rak()
	{
		$this->db->select('buku.judul , buku.id_buku , buku.id_kategori, buku.foto, buku.no_rak, buku.thn_terbit, buku.ket, rak.nama_rak, kat.kategori');
		$this->db->from('tb_buku buku');
		$this->db->join('tb_kategori kat', 'buku.id_kategori=kat.id_kategori');
		$this->db->join('tb_rak rak', 'rak.no_rak=buku.no_rak');
		$this->db->group_by('kat.id_kategori');
		return $this->db->get();
	}

	public function get_data_pinjam()
	{
		return $this->db->get('tb_pinjam');
	}
	public function get_data_kembali()
	{
		return $this->db->get('tb_kembali');
	}



	public function get_sampel_books($limit = 10)
	{
		return $this->db->get('tb_buku', $limit);
	}

	public function get_rak_and_books()
	{
		$this->db->from('tb_rak rak');
		$this->db->join('tb_buku buku', 'buku.no_rak=rak.no_rak');
		$this->db->group_by('rak.no_rak');
		return $this->db->get();
	}

	public function get_books_by_rak_id($id)
	{
		$this->db->from('tbl_rak rak');
		$this->db->join('tb_buku buku', 'buku.no_rak=rak.no_rak');
		$this->db->where('rak.no_rak', $id);
		return $this->db->get();
	}
	public function get_all_book()
	{
		$this->db->from('tb_buku buku');
		return $this->db->get();
	}


	//query pengambilan semua data
	public function getAllData($table)
	{
		return $this->db->get($table);
	}
	//menghapus data dalam tabel
	function deleteData($table, $data)
	{
		$this->db->delete($table, $data);
	}
	function deletedetData($table, $col, $id_det_buku)
	{
		$this->db->where($col, $id_det_buku);
		$aks = $this->db->delete($table);
		return $aks;
	}

	//memasukan data - insert
	function insertData($table, $data)
	{
		$this->db->insert($table, $data);
	}

	//query untuk mengambil detail by id
	function get_detail($table, $id_table, $id)
	{
		$query = $this->db->get_where($table, array($id_table => $id));
		return $query;
	}
	function get_detail12($table, $col1, $col2, $id, $tgl)
	{
		$query = $this->db->get_where($table, array(
			$col1 => $id,
			$col2 => $tgl
		));
		return $query;
	}
	function get_detail1($table, $id_table, $id)
	{
		$this->db->where($id_table, $id);
		$query = $this->db->get($table);
		$isi = $query->row_array();
		return $isi;
	}
	function get_detail123($table, $id_table, $id)
	{
		$this->db->where($id_table, $id);
		$p = $this->db->get($table);
		return $p;
	}

	function updateData1($table, $data, $field, $id)
	{
		$this->db->where($field, $id);
		$this->db->update($table, $data);
	}

	function updateData($table, $data, $field, $key)
	{
		$this->db->where($key, $field);
		$this->db->update($table, $data);
	}


	public function get_stok($id_buku)
	{
		$query = $this->db->where('id_buku', $id_buku)
			->limit(1)
			->get('tb_buku');
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return array();
		}
	}
	function Delete($table, $field, $id)
	{
		$this->db->where($field, $id);
		$this->db->delete($table);
	}

	//*last edited 10 April 2017
	//batch insert
	function insertData_batch($table, $data)
	{
		$this->db->insert_batch($table, $data);
	}

	public function countRow($status, $id_buku)
	{
		$query = $this->db->query("SELECT status FROM tb_detail_buku WHERE status='" . $status . "' AND id_buku='" . $id_buku . "'");
		echo $query->num_rows();
	}

	public function countRow_pinjam($status, $id_pinjam)
	{
		$query = $this->db->query("SELECT status FROM tb_detail_pinjam WHERE status='" . $status . "' AND id_pinjam='" . $id_pinjam . "'");
		$query->num_rows();
	}

	public function update_status($table, $data, $field1, $key1, $field2, $key2)
	{
		$this->db->where($field1, $key1);
		$this->db->where($field2, $key2);
		$this->db->update($table, $data);
	}

	public function update_status2($no_buku, $id_buku, $data)
	{
		$this->db->where('no_buku', $no_buku);
		$this->db->where('id_buku', $id_buku);
		$this->db->update('tb_detail_buku', $data);
	}

	function get_detail2($table, $id_table, $id)
	{
		$this->db->where($id_table, $id);
		$this->db->where('status', '1');
		$query = $this->db->get($table);
		return $query;
	}

	public function get_total($id_pinjam)
	{
		$query = $this->db->where('id_pinjam', $id_pinjam)
			->limit(1)
			->get('tb_pinjam');
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return array();
		}
	}
	/*update tgl 5/5 2017 */
	/*keperluan chart */
	public function get_jml_peminjaman($first_date, $second_date)
	{
		$this->db->select('id_pinjam, COUNT(id_pinjam) as total');
		$this->db->where('tgl_pinjam >=', $first_date);
		$this->db->where('tgl_pinjam <=', $second_date);
		$query = $this->db->get('tb_pinjam');
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return array();
		}
	}

	public function buku_pinjam()
	{
		$query = $this->db->query("SELECT tb_buku.id_buku, tb_buku.judul, count(tb_detail_pinjam.id_buku) AS total FROM `tb_buku` JOIN tb_detail_pinjam on tb_buku.id_buku=tb_detail_pinjam.id_buku GROUP BY tb_detail_pinjam.id_buku ORDER BY total DESC LIMIT 10");
		return $query->result_array();
	}


	public function kategori_pinjam()
	{
		$query = $this->db->query("SELECT tb_kategori.id_kategori, tb_kategori.kategori, count(tb_detail_pinjam.id_buku) AS total FROM `tb_kategori` JOIN tb_buku on tb_buku.id_kategori=tb_kategori.id_kategori JOIN tb_detail_pinjam on tb_detail_pinjam.id_buku=tb_buku.id_buku GROUP BY tb_kategori.id_kategori ORDER BY total DESC LIMIT 10");
		return $query->result_array();
	}

	public function kelas_pinjam()
	{
		$query = $this->db->query("SELECT tb_kelas.id_kelas, tb_kelas.kelas, count(tb_pinjam.id_anggota) AS total FROM `tb_kelas` JOIN tb_anggota on tb_kelas.id_kelas=tb_anggota.id_kelas JOIN tb_pinjam on tb_pinjam.id_anggota=tb_anggota.id_anggota GROUP BY tb_kelas.id_kelas ORDER BY total DESC LIMIT 10");
		return $query->result_array();
	}
}

/* End of file Perpus_model.php */
/* Location: ./application/models/Perpus_model.php */