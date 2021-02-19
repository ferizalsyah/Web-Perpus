<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use \Firebase\JWT\JWT;

require FCPATH . 'vendor/autoload.php';


class Buku extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->token = $this->input->get_request_header('Authorization');
        $this->load->model('Buku_model');
        $this->handelAuth();
    }
    public function handelAuth()
    {
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
    }
    /* halaman depan */
    public function index()
    {
        $key = "example_key";
        header('Content-Type: application/json');
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
            die($th);
            echo json_encode([
                "response" => [
                    "msg" => 'token salah',
                ]
            ]);
        }
    }

    /* api oook halaman tampil seluruh buku  */
    public function tampilAllBook()
    {
        $id = $this->input->get('id_kategori');
        if ($id != null) {
            $buku = $this->Buku_model->getBukuBykategori($id)->result();
            $kat = $this->db->get_where('tb_kategori', ['id_kategori' => $id])->row()->kategori;
            $response = [
                "title" => $kat,
                "msg" => "menampilkan buku per kategori",
                "response" => [
                    "data"  => $buku
                ]
            ];
        } else {
            $response = [
                "title" =>  null,
                "msg" => "data buku tidak ditemukan",
                "response" => [
                    "data"  => null
                ]
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function show($id)
    {
        $key = "example_key";
        header('Content-Type: application/json');
        $data = $this->token != null ? JWT::decode($this->token, $key, array('HS256')) : null;
        $userId  = $data != null ? explode('-', $data)[1] : null;
        if ($userId != null) {
            if ($id != null) {
                $buku = $this->Buku_model->findById($id)->row();
                $response = [
                    "title" =>  null,
                    "msg" => "data buku ditemukan",
                    "response" => ["data"  => $buku]
                ];
            } else {
                $response = [
                    "title" =>  null,
                    "msg" => "data buku tidak ditemukan",
                    "response" => [
                        "data"  => null
                    ]
                ];
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
