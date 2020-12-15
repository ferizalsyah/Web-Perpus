<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use \Firebase\JWT\JWT;

require FCPATH . 'vendor/autoload.php';


class Buku extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->token = $this->input->get_request_header('Authorization');
        if ($this->token == null) {
            echo json_encode([
                "response" => [
                    "success" => true,
                    "token" => $this->token,
                    "msg" => "token tidak valid",
                    "statuscode" => 200,

                ]
            ]);
        }

        //$this->load->model('Buku_model');
    }
    // url
    /* halaman depan */
    public function index()
    {
        $key = "example_key";
        try {
            $data = $this->token != null ? JWT::decode($this->token, $key, array('HS256')) : null;
            $userId  = $data != null ? explode('-', $data)[1] : null;

            if ($userId != null) {
                $buku = $this->Buku_model->group_kat_rak()->result();
                $kat = $this->Buku_model->get_all_kategori()->result();

                $tampungBuku = [];
                foreach ($kat as $key => $kat_item) {
                    $tmp_buku = [];
                    $tmp = [];
                    foreach ($buku as $keyBook => $book_item) {
                        if ($kat_item->id_kategori === $book_item->id_kategori) {
                            array_push($tmp_buku, $book_item);
                        }
                    }
                    $tmp['kategori'] = $kat_item->kategori;
                    $tmp['id_kategori'] = $kat_item->id_kategori;
                    $tmp['data'] = $tmp_buku;

                    array_push($tampungBuku, $tmp);
                }
                $response = [
                    "response" => $tampungBuku
                ];
                echo json_encode($response);
            } else {
                echo json_encode([
                    "response" => [
                        "msg" => 'token salah',
                    ]
                ]);
            };
        } catch (\Throwable $th) {
            echo json_encode([
                "response" => [
                    "msg" => 'token salah',
                ]
            ]);
        }


        // get buku 
    }



    /* api oook halaman tampil seluruh buku  */
    public function tampilAllBook()
    {
        $id = $this->input->get('id_kategori');

        // die($id);
        if ($id != null) {
            $buku = $this->db->get_where('tb_buku', ['id_kategori' => $id])->result();
        } else {
            $buku = $this->db->get('tb_buku')->result();
        }
        $response = [
            "response" => [
                "dataa"  => $buku
            ]
        ];
        echo json_encode($response);
    }

    public function get_data_pinjam()
    {
        $pijam = $this->Buku_model->get_data_pinjam()->result();
        // die(print_r($pijam));

        if ($pijam  != null) {
            $data = $this->db->get_where('tb_pinjam')->result();
        } else {
            $data = $this->db->get('tb_pinjam')->result();
        }
        // die(print_r($pijam));
        $response = [
            "response" => [
                "data" => $data
            ]
        ];
        echo json_encode($response);
    }

    /* api book tampil deskiripsi buku */
    public function api_description_book($id)
    {
        /* cari buku berdasaran id */
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
        $this->load->view('global/layout', $tmp);    //}
    }
}
