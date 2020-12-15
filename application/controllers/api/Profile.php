<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use \Firebase\JWT\JWT;

require FCPATH . 'vendor/autoload.php';

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->token = $this->input->get_request_header('Authorization');
        if ($this->token == null) {
            echo json_encode([
                "response" => true,
                "token" => $this,
                "msg" => "token valid",
                "statuscode" => 200,
            ]);
        };
    }
    /* halaman depan */
    public function index()
    {
        $key = "example_key";
        try {
            $data = $this->token != null ? JWT::decode($this->token, $key, array('HS256')) : null;
            $userId  = $data != null ? explode('-', $data)[1] : null;

            if ($userId != null) {
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
    }
}
