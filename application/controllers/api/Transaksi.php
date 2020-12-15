<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();

        //$this->load->model('Buku_model');
    }

    /* halaman depan */
    public function index()
    {
        $pijam = $this->Buku_model->get_data_pinjam()->result();

        if ($pijam  != null) {
            $data = $this->db->get_where('tb_pinjam')->result();
        } else {
            return false;
        }
        $response = [
            "response" => [
                "data" => $data
            ]
        ];
        echo json_encode($response);
    }

    public function get_data_kembali()
    {
        $kembali = $this->Buku_model->get_data_kembali()->result();

        if ($kembali  != null) {
            $data = $this->db->get_where('tb_kembali')->result();
        } else {
            return false;
        }
        $response = [
            "response" => [
                "data" => $data
            ]
        ];
        echo json_encode($response);
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

    /* api book tampil deskiripsi buku */
    public function api_description_book($id)
    {
        /* cari buku berdasaran id */
    }

    public function login_post()
    {

        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $result = $this->input->login_post($email, $password);
        echo json_encode($result);
    }



    public function profile()
    {

        $data['title'] = 'Profile Sekolah';
        $tmp['content'] = $this->load->view('global/profile', $data, TRUE);
        $this->load->view('global/layout', $tmp);
    }
}
