<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function __construct() {
    parent::__construct();
    
		$this->load->model('auth_model', 'auth');
  }


	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function login_proses()
	{
		$recaptchaResponse  = trim($this->input->post('g-recaptcha-response'));
    $userIp             = $this->input->ip_address();
    $secret             = $this->config->item('secret_key');

    $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;

    $ch     = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);

    $status = json_decode($output, true);

    if ($status['success']) {
    	//CEK DATA APAKAH ADA
      $data['username'] = htmlspecialchars($this->input->post('username'));
      $data['password'] = htmlspecialchars($this->input->post('password'));
      $res 		= $this->auth->islogin($data);
      $params = array();
      
      if ($res == 0) {
      	$params = array(
					"status_code" => 404,
					"status" 			=> "not found",
					"message" 		=> "Username tidak ditemukan!",
					"url"					=> null
				);

      	echo json_encode($params);
      }elseif ($res == 10) {
      	$params = array(
					"status_code" => 400,
					"status" 			=> "error",
					"message" 		=> "Username atau password salah!",
					"url"					=> null
				);

      	echo json_encode($params);
      }elseif ($res == 20) {
      	$params = array(
					"status_code" => 401,
					"status" 			=> "error",
					"message" 		=> "Username anda di block!",
					"url"					=> null
				);

      	echo json_encode($params);
      }elseif ($res == 30) {
      	$params = array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Login sukses",
					"url"					=> base_url()."adminx"
				);

      	echo json_encode($params);
      };
    } else {
    	$params = array(
				"status_code" => 400,
				"status" 			=> "error",
				"message" 		=> "Harap centang captcha",
				"url"					=> null
			);

    	echo json_encode($params);
    }
  }

  public function not_found()
  {
  	$login = $this->session->userdata('user_valid');

  	if ($login == 1 || $login == true) {
  		$data['nama_halaman'] = "404 Error";
  		
  		$this->load->view('not_found_login', $data, FALSE);
  	} else {
  		$this->load->view('not_found');
  	}
  }
}
