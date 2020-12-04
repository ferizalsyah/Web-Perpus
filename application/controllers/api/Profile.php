<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Buku extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    /* halaman depan */
    public function index()
    {
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
    }
}
