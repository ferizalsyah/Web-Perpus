<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use \Firebase\JWT\JWT;

require FCPATH . 'vendor/autoload.php';

class Transaksi extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->token = $this->input->get_request_header('Authorization');
        $this->load->model('Peminjaman_model');
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


    public function get_data_pinjam()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        $key = "example_key";
        $data = $this->token != null ? JWT::decode($this->token, $key, array('HS256')) : null;
        $userId  = $data != null ? explode('-', $data)[1] : null;

        if ($userId != null) {
            /* user ditemukan  */
            $res = $this->Peminjaman_model->get_data_peminjaman($userId)->result();
            $response = [
                "response" => [
                    "data" => $res,
                ]
            ];
        } else {
            /* user tidak ditemukan  */
            $response = [
                "response" => [
                    "data" => null,
                ]
            ];
        }
        echo json_encode($response);
    }
    public function index()
    {
        $status = $this->input->get('status');
        $status = $status != null ? $status : 0;
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        $key = "example_key";
        $data = $this->token != null ? JWT::decode($this->token, $key, array('HS256')) : null;
        $userId  = $data != null ? explode('-', $data)[1] : null;
        if ($userId != null) {
            $res = $this->Peminjaman_model->get_data_peminjaman($userId, $status)->result();

            // die(print_r($res));
            $response = [
                "response" => [
                    "data" => $res
                ]
            ];
        } else {
            $response = [
                "response" => [
                    "data" => null,
                ]
            ];
        }
        echo json_encode($response);
    }

    /**
     * post peminjaman baru dari android
     */

    public function pinjam_buku()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        $key = "example_key";
        $data = $this->token != null ? JWT::decode($this->token, $key, array('HS256')) : null;
        $userId  = $data != null ? explode('-', $data)[1] : null;

        if ($userId != null) {
            /* user ditemukan  */
            $data = [
                'tgl_pinjam' => date("y-m-d"),
                'id_anggota' => $userId,
                'tgl_kembali' => date('y-m-d', strtotime('+7 days', strtotime(date('y-m-d')))),
                'total_buku' => 1,
                'status' => 0,
            ];

            $res = $this->db->insert('tb_pinjam', $data);
            /* insert to detail pinjam  */
            $detail_pinjam = [
                'id_pinjam' => $this->db->insert_id(),
                'id_buku' => $input["id_buku"],
                'no_buku' => 10,
                "flag" => 0,
            ];

            $res = $this->db->insert('tb_detail_pinjam', $detail_pinjam);

            $response = [
                "response" => [
                    'status' => 'sucess meminjam data',
                    "data" => $res,
                ]
            ];
        } else {
            /* user tidak ditemukan  */
            $response = [
                "response" => [
                    "data" => null,
                ]
            ];
        }
        echo json_encode($response);
    }
}
