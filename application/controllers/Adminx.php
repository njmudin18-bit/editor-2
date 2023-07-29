<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminx extends CI_Controller {

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
    if($this->auth->isNotLogin());

    $this->load->model('dashboard_model', 'dashboard');
    $this->load->model('users_model', 'users');
  }


	public function index()
	{
		$data['nama_halaman'] 			= "Dashboard";
		$data['jumlah_user'] 				= $this->dashboard->jumlah_user();
		$data['jumlah_produk'] 			= $this->dashboard->jumlah_produk();
		$data['recent_activities'] 	= $this->dashboard->recent_activities();

		//CALLBACK
		$data['jumlah_call_back_data'] 			= $this->dashboard->jumlah_call_back_data();
		$data['jumlah_call_back_all'] 			= $this->dashboard->jumlah_call_back_all();
		$data['jumlah_call_back_proses'] 		= $this->dashboard->jumlah_call_back_proses();
		$data['jumlah_call_back_lengkap'] 	= $this->dashboard->jumlah_call_back_lengkap();

		//PERTANYAAN
		$data['jumlah_pertanyaan_data'] 		= $this->dashboard->jumlah_pertanyaan_data();
		$data['jumlah_pertanyaan_all'] 			= $this->dashboard->jumlah_pertanyaan_all();
		$data['jumlah_pertanyaan_lengkap'] 	= $this->dashboard->jumlah_pertanyaan_lengkap();
		$data['jumlah_pertanyaan_proses'] 	= $this->dashboard->jumlah_pertanyaan_proses();

		//print_r($data['jumlah_pertanyaan_proses']); exit();

		$this->load->view('adminx/dashboard', $data, FALSE);
	}

	public function update_password()
	{
		$data['nama_halaman'] 			= "Update Password";

		$this->load->view('adminx/update_password', $data, FALSE);
	}

	public function update_password_action()
	{
		$data = array(
			'password' 					=> $this->hash_password($this->input->post('confirm_new_password')),
			'update_date'				=> date('Y-m-d H:i:s'),
			'update_by' 				=> $this->session->userdata('user_id')
		);
		$this->users->update(array('id' => $this->session->userdata('user_id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function logout()
	{
		$this->session->sess_destroy();  
    
    redirect(base_url());
	}

	private function hash_password($password){
  	return password_hash($password, PASSWORD_DEFAULT);
	}
}
