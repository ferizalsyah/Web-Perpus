<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use \Firebase\JWT\JWT;
require FCPATH ."vendor/autoload.php";
require FCPATH . 'vendor/autoload.php';

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $this->Auth_model->login($data['email'], $data['password'])->row();
        if ($result != null) {
            /* jika ditemukan maka generate token kemudian response token  */

            $key = "example_key";
            $token = JWT::encode(($result->email . "-" . $result->id_anggota), $key);

            /* implementasi resposne token */
            $response = [
                "response" => [
                    "success" => true,
                    "token" => $token,
                    "msg" => "login berhasil",
                    "statuscode" => 200,

                ]
            ];
        } else {
            /* jika email atau password tidak ditemukan  */
            $response = [
                "response" => [
                    "token" => null,
                    "success" => false,
                    "msg" => "email atau password tidak ditemukan",
                    "statuscode" => 200,

                ]
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
