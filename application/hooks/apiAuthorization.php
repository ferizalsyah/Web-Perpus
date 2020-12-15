<?php 

use \Firebase\JWT\JWT;
require FCPATH ."vendor/autoload.php";
require FCPATH . 'vendor/autoload.php';

class apiAuthorization extends CI_Controller {
  public function __construct() {
      parent::__construct();
      $this->load->model('Auth_model');
  }
  
  public function hendler() {
    $key = "example_key";
    $headers = $this->input->request_headers();
    if($CI ->router->class != "auth"){ 
      $token = JWT::decode($headers['Authorization'], $key);
      if($token) {}
    }
  }
}