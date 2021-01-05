<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use \Firebase\JWT\JWT;

require FCPATH . 'vendor/autoload.php';

class Notifikasi extends CI_Controller
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
		public function index() {
				$key = "example_key";
        header('Content-Type: application/json');
        try {
            $data = $this->token != null ? JWT::decode($this->token, $key, array('HS256')) : null;
            $userId  = $data != null ? explode('-', $data)[1] : null;
            if ($userId != null) {
								$temp = [];
								$result = $this->Peminjaman_model->getPinjam($userId)->result();


								
								if(count($result) > 0) {
									foreach($result as $item) {
										$today=date ("Y-m-d");
										$tgl_kembali = strtotime($item->tgl_kembali);

										if($today > $tgl_kembali) {
											$tanggal = new DateTime($item->tgl_kembali); 
											
											$sekarang = new DateTime();
											
											$perbedaan = $tanggal->diff($sekarang);
											if($perbedaan->y >= 0 && $perbedaan->m >= 0 && $perbedaan->d > 2) {
												array_push($temp, $item);
											}
										} else {
											$tanggal = new DateTime($item->tgl_kembali); 
											$sekarang = new DateTime();
											$perbedaan = $tanggal->diff($sekarang);
											if($perbedaan->y >= 0 && $perbedaan->m >= 0 && $perbedaan->d <= 2) {
												array_push($temp, $item);
											}
										}
									}
								}
								echo json_encode([
                    "response" => [
												"data" => $temp,
												"count" => count($temp)
                    ]
                ]);
						} else {
							print($userId);
						}
				}catch(Exception $e) {
					print($e);
				}
		}
}
