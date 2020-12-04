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


    // public function index()
    // {
    //     // get buku 
    //     $buku = $this->Buku_model->group_kat_rak()->result();
    //     $kat = $this->Buku_model->get_all_kategori()->result();

    //     $tampungBuku = [];
    //     foreach ($kat as $key => $kat_item) {
    //         $tmp_buku = [];
    //         $tmp = [];
    //         foreach ($buku as $keyBook => $book_item) {
    //             if ($kat_item->id_kategori === $book_item->id_kategori) {
    //                 array_push($tmp_buku, $book_item);
    //             }
    //         }
    //         $tmp['kategori'] = $kat_item->kategori;
    //         $tmp['id_kategori'] = $kat_item->id_kategori;
    //         $tmp['data'] = $tmp_buku;

    //         array_push($tampungBuku, $tmp);
    //     }
    //     $response = [
    //         "response" => $tampungBuku
    //     ];
    //     echo json_encode($response);
    // }

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
