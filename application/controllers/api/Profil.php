<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use \Firebase\JWT\JWT;

require FCPATH . 'vendor/autoload.php';


class Profil extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->token = $this->input->get_request_header('Authorization');
        $this->load->model('Profil_model');
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
                $user = $this->Profil_model->getProfil($userId)->row();
                $response = [
                    "response" => [
                        "data" => $user,
                    ]
                ];

                echo json_encode($response);
            } else {
                echo json_encode([
                    "response" => [
                        "msg" => 'token sala    h',
                    ]
                ]);
            };
        } catch (\Throwable $th) {
            print($th);
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
            $buku = $this->db->get_where('tb_buku', ['id_kategori' => $id])->result();
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
}
