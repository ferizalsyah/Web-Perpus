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
    public function getPinjam()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        $key = "example_key";
        $data = $this->token != null ? JWT::decode($this->token, $key, array('HS256')) : null;
        $userId  = $data != null ? explode('-', $data)[1] : null;
        if ($userId != null) {
            $res = $this->Peminjaman_model->get_data_pinjam($userId)->result();
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
            $res = $this->Peminjaman_model->get_data_peminjaman($userId)->result();
            $tampung_pinjam = [];
            foreach ($res as $key => $all_Pinjam) {
                $pinjam = [];
                $tmp = [];
                $tmp['image'] = $all_Pinjam->image;
                $tmp['judul'] = $all_Pinjam->judul;
                $tmp['tgl_kembali'] = $all_Pinjam->tgl_kembali;
                $tmp['data'] = $pinjam;

                array_push($tampung_pinjam, $tmp);
            }
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
}
