<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Buku extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();

		//$this->load->model('Buku_model');
	}

	/* halaman depan */
	public function api_book()
	{
		$rak = $this->Buku_model->get_all_rak()->result();
		$buku = $this->Buku_model->get_sampel_books()->result();

		$tampungBuku = [];
		foreach ($rak as $key => $rak_item) {
			$tmp_buku = [];
			foreach ($buku as $keyBook => $book_item) {
				if ($rak_item->no_rak === $book_item->no_rak) {
					array_push($tmp_buku, [
						'book' => $book_item,
					]);
				}
			}

			array_push($tampungBuku, [
				// 'status' => 'ok',
				// 'msg' => 'sukses menampilkan buku',
				'rak' => $rak_item,
				'buku' => $tmp_buku
			]);
		}

		echo json_encode($tampungBuku);
	}

	/* api oook halaman tampil seluruh buku  */
	public function tampilAllBook()
	{
		$buku = $this->Buku_model->get_all_book()->result();

		$allBuku = [];
		foreach ($buku as $key => $book_item) {
			if ($book_item->id_buku === $book_item->id_buku) {
				array_push($allBuku, [
					'book' => $book_item,
				]);
			}
		}
		array_push($allBuku, [
			'buku' => $book_item
		]);

		echo json_encode($buku);
	}

	/* api book tampil deskiripsi buku */
	public function api_description_book($id)
	{
		/* cari buku berdasaran id */
	}
	public function dataPengarang()
	{
		$pengarang = $this->data_pengarang->get('id');
		if ($pengarang == '') {
			$pengarang = $this->db->get('tb_pengarang')->result();
		} else {
			$this->db->where('id', $pengarang);
			$pengarang = $this->db->get('tb_pengarang')->result();
		}
		echo json_encode($pengarang);
	}

	public function login_post()
	{

		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$result = $this->input->login_post($email, $password);
		echo json_encode($result);
	}


	public function index()
	{
		$data['title'] = 'Home Perpustakaan';
		$tmp['content'] = $this->load->view('global/home', $data, TRUE);
		$this->load->view('global/layout', $tmp);
	}

	public function profile()
	{

		$data['title'] = 'Profile Sekolah';
		$tmp['content'] = $this->load->view('global/profile', $data, TRUE);
		$this->load->view('global/layout', $tmp);
	}

	//menampilkan daftar buku
	public function list_buku()
	{
		$data['title'] = 'Daftar buku';
		/*data yang ditampilkan*/
		$data['count_pengguna'] = $this->db->query("SELECT * FROM tb_anggota")->num_rows();
		$data['data_buku'] = $this->Buku_model->getAllData("tb_buku");
		$data['data_kategori'] = $this->Buku_model->getAllData("tb_kategori");
		$data['data_penerbit'] = $this->Buku_model->getAllData("tb_penerbit");
		$data['data_pengarang'] = $this->Buku_model->getAllData("tb_pengarang");
		$data['data_rak'] = $this->Buku_model->getAllData("tb_rak");
		$data['model'] = $this->Buku_model;
		/*masukan data kedalam view */
		//$data['js']=$this->load->view('admin/buku/js');
		$tmp['content'] = $this->load->view('global/R_buku', $data, TRUE);
		$this->load->view('global/layout', $tmp);
	}

	//menampilkan daftar detail stock buku
	public function detail_stok()
	{

		$id_buku = $this->input->get('id_buku', TRUE);
		/*layout*/
		$data['title'] = 'Daftar Detail Stock Buku';
		$data['pointer'] = "buku/buku/";
		$data['classicon'] = "fa fa-book";
		$data['main_bread'] = "Data Buku";
		$data['sub_bread'] = "Detail Stock Buku";
		$data['desc'] = "Data Detail Stock, Menampilkan Detail Stock Buku Perpustakaan";

		/*data yang ditampilkan*/
		$data['data_stok_buku'] = $this->Buku_model->get_detail("tb_detail_buku", 'id_buku', $id_buku);
		$data['data_kategori'] = $this->Buku_model->getAllData("tb_kategori");
		$data['data_penerbit'] = $this->Buku_model->getAllData("tb_penerbit");
		$data['data_pengarang'] = $this->Buku_model->getAllData("tb_pengarang");
		$data['data_rak'] = $this->Buku_model->getAllData("tb_rak");
		$data['id'] = $id_buku;
		$data['error'] = "";

		/*masukan data kedalam view */
		$tmp['content'] = $this->load->view('global/R_detail_stok', $data, TRUE);
		$this->load->view('global/layout', $tmp);	//}
	}
}
