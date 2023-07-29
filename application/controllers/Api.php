<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

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
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();

		$this->load->model('api_model', 'api_model');
		$this->load->model('callback_model', 'callback_model');
	}

	public function test()
	{
		$username = $this->input->server('PHP_AUTH_USER');
		$password = $this->input->server('PHP_AUTH_PW');

		if ($username == 'njmudin@omas-mfg.com' && $password == '58afecadb41d76b68e567c189c1a8e80') {
			# code...
		} else {
			echo json_encode(
				array(
					"status_code" => 401,
					"status" 			=> "Unauthorized",
					"message" 		=> "Restricted data",
					"data" 				=> array()
				)
			);
		}
	}

	/***** GENERAL SETTING *****/
	//1.1. PROFILE HEADER
	public function get_profile_headers()
	{
		$this->_validation_profile_headers();

		$nama_halaman = $this->input->post('nama_halaman');
		$data 				= $this->api_model->get_profile_headers($nama_halaman);

		$cek 	= count(get_object_vars($data));
		if ($cek > 1) {
			echo json_encode(
				array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Nama header ditemukan",
					"data" 				=> $data
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 404,
					"status" 			=> "error",
					"message" 		=> "Nama header tidak ditemukan",
					"data" 				=> null
				)
			);
		}
	}

	//1.2. COMPANY PROPERTY
	public function get_company_details()
	{
		$data 	= $this->api_model->get_company_details();

		echo json_encode(
			array(
				"status_code" => 200,
				"status" 			=> "success",
				"message" 		=> "Perusahaan ditemukan",
				"data" 				=> $data
			)
		);
	}

	/***** BERANDA *****/
	//1.1. SLIDER
	public function get_all_sliders()
	{
		$data 	= $this->api_model->get_all_sliders();
		$cek 		= count($data);
		if ($cek > 0) {
			echo json_encode(
				array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Slider ditemukan",
					"data" 				=> $data
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 404,
					"status" 			=> "error",
					"message" 		=> "Slider tidak ditemukan",
					"data" 				=> array()
				)
			);
		}
	}

	//1.2. SINOPSIS PRODUK
	public function get_all_sinopsis()
	{
		$data 	= $this->api_model->get_all_sinopsis();
		$cek 		= count($data);
		if ($cek > 0) {
			echo json_encode(
				array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Sinopsis ditemukan",
					"data" 				=> $data
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 404,
					"status" 			=> "error",
					"message" 		=> "Sinopsis tidak ditemukan",
					"data" 				=> array()
				)
			);
		}
	}

	//1.3. SERTIFIKASI
	public function get_all_sertified()
	{
		$data 	= $this->api_model->get_all_sertified();
		$cek 		= count($data);
		if ($cek > 0) {
			echo json_encode(
				array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Sertifiksi oleh ditemukan",
					"data" 				=> $data
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 404,
					"status" 			=> "error",
					"message" 		=> "Sertifiksi oleh tidak ditemukan",
					"data" 				=> array()
				)
			);
		}
	}

	//1.4. LAYANAN
	public function get_all_tags()
	{
		$data 	= $this->api_model->get_all_tags();
		$cek 		= count($data);
		if ($cek > 0) {
			echo json_encode(
				array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Produk Tags ditemukan",
					"data" 				=> $data
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 404,
					"status" 			=> "error",
					"message" 		=> "Produk Tags tidak ditemukan",
					"data" 				=> array()
				)
			);
		}
	}

	//1.5. KEPERCAYAAN
	public function get_all_trusted()
	{
		$username = $this->input->server('PHP_AUTH_USER');
		$password = $this->input->server('PHP_AUTH_PW');
		// password md5(202304) + XXX

		if ($username == 'njmudin@omas-mfg.com' && $password == '58afecadb41d76b68e567c189c1a8e80XXX') {
			$data 	= $this->api_model->get_all_trusted();

			echo json_encode(
				array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Produk kepercayaan ditemukan",
					"data" 				=> $data
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 401,
					"status" 			=> "Unauthorized",
					"message" 		=> "Restricted data",
					"data" 				=> array()
				)
			);
		}
	}

	/***** TENTANG KAMI *****/
	//1.1. PROFILE PERUSAHAAN
	public function get_company_profile()
	{
		$data 	= $this->api_model->get_company_profile();

		echo json_encode(
			array(
				"status_code" => 200,
				"status" 			=> "success",
				"message" 		=> "Profile ditemukan",
				"data" 				=> $data
			)
		);
	}

	//1.2. VISI
	public function get_all_visi()
	{
		$data 	= $this->api_model->get_all_visi();

		echo json_encode(
			array(
				"status_code" => 200,
				"status" 			=> "success",
				"message" 		=> "Visi ditemukan",
				"data" 				=> $data
			)
		);
	}

	//1.3. MISI
	public function get_all_misi()
	{
		$data 	= $this->api_model->get_all_misi();

		$cek 		= count($data);
		if ($cek > 0) {
			echo json_encode(
				array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Misi oleh ditemukan",
					"data" 				=> $data
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 404,
					"status" 			=> "error",
					"message" 		=> "Misi oleh tidak ditemukan",
					"data" 				=> array()
				)
			);
		}
	}

	//1.4. METODE
	public function get_all_metode()
	{
		$data 	= $this->api_model->get_all_metode();

		$cek 		= count($data);
		if ($cek > 0) {
			echo json_encode(
				array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Metode ditemukan",
					"data" 				=> $data
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 404,
					"status" 			=> "error",
					"message" 		=> "Metode tidak ditemukan",
					"data" 				=> array()
				)
			);
		}
	}

	//1.5. PELANGGAN KAMI 
	public function get_all_customers()
	{
		$data 	= $this->api_model->get_all_customers();

		$cek 		= count($data);
		if ($cek > 0) {
			echo json_encode(
				array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Customer ditemukan",
					"data" 				=> $data
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 404,
					"status" 			=> "error",
					"message" 		=> "Customer tidak ditemukan",
					"data" 				=> array()
				)
			);
		}
	}

	//1.6. FASILITAS UJI 
	public function get_all_test_kit()
	{
		$data 	= $this->api_model->get_all_test_kit();

		$cek 		= count($data);
		if ($cek > 0) {
			echo json_encode(
				array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Fasilitas Uji ditemukan",
					"data" 				=> $data
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 404,
					"status" 			=> "error",
					"message" 		=> "Fasilitas Uji tidak ditemukan",
					"data" 				=> array()
				)
			);
		}
	}

	/***** PRODUK *****/
	//1.1. PRODUK
	public function get_all_products()
	{
		$this->_validation_produk_jenis();

		$jenis 	 = $this->input->post('jenis');
		//echo $id;
		//$token = $this->input->get_request_header('Authorization');

		$data 	= $this->api_model->get_all_products($jenis);
		$cek 		= count($data);
		if ($cek > 0) {
			echo json_encode(
				array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Produk ditemukan",
					"data" 				=> $data
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 404,
					"status" 			=> "error",
					"message" 		=> "Produk tidak ditemukan",
					"data" 				=> array()
				)
			);
		}
	}

  public function get_all_products_new()
	{
		$data 	= $this->api_model->get_all_products_new();
		$cek 		= count($data);
		if ($cek > 0) {
			echo json_encode(
				array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Produk ditemukan",
					"data" 				=> $data
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 404,
					"status" 			=> "error",
					"message" 		=> "Produk tidak ditemukan",
					"data" 				=> array()
				)
			);
		}
	}

	public function get_all_products_mix()
	{
		$data 	= $this->api_model->get_all_products_mix();
		$cek 		= count($data);
		if ($cek > 0) {
			echo json_encode(
				array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Produk ditemukan",
					"data" 				=> $data
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 404,
					"status" 			=> "error",
					"message" 		=> "Produk tidak ditemukan",
					"data" 				=> array()
				)
			);
		}
	}

	public function get_mix_top_ten_products()
	{
		$data 	= $this->api_model->get_mix_top_ten_products();
		$cek 		= count($data);
		if ($cek > 0) {
			echo json_encode(
				array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Produk ditemukan",
					"data" 				=> $data
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 404,
					"status" 			=> "error",
					"message" 		=> "Produk tidak ditemukan",
					"data" 				=> array()
				)
			);
		}
	}

	//1.4. PRODUK DETAIL
	public function get_product_details()
	{
		$this->_validation_produk_details();

		$slug = strtolower($this->input->post('slug'));
		$data = $this->api_model->get_product_details($slug);

		$cek 	= count(get_object_vars($data));
		if ($cek > 1) {
			echo json_encode(
				array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Produk details ditemukan",
					"data" 				=> $data
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 404,
					"status" 			=> "error",
					"message" 		=> "Produk details tidak ditemukan",
					"data" 				=> null
				)
			);
		}
	}

	//1.5. JENIS PRODUK
	public function get_all_product_types()
	{
		$data 	= $this->api_model->get_all_product_types();
		$cek 		= count($data);
		if ($cek > 0) {
			echo json_encode(
				array(
					"status_code" => 200,
					"status" 			=> "success",
					"message" 		=> "Jenis Produk ditemukan",
					"data" 				=> $data
				)
			);
		} else {
			echo json_encode(
				array(
					"status_code" => 404,
					"status" 			=> "error",
					"message" 		=> "Jenis Produk tidak ditemukan",
					"data" 				=> array()
				)
			);
		}
	}

	//1.6. COUNT MASING2 JENIS PRODUK
	public function get_count_product_types()
	{
		$id 		= $this->input->post('id');
		$data 	= $this->api_model->get_count_product_types($id);

		echo json_encode(floatval($data->jumlah_produk));
	}

	/***** KONTAK KAMI *****/
	//1.1. CALL BACK
	public function save_call_back()
	{
		$data = array(
			'pengirim'			=> $this->input->post('name_cb'),
			'phone'					=> $this->input->post('phone_cb'),
			'type' 					=> 'CALL BACK',
			'judul' 				=> $this->input->post('pertanyaan_cb'),
			'create_date'		=> date('Y-m-d H:i:s')
		);

		$insert = $this->callback_model->save($data);
		if ($insert) {
			echo json_encode(array("status" => "ok"));
		} else {
			echo json_encode(array("status" => "error"));
		}
	}

	//1.1. PERTANYAAN
	public function save_pertanyaan()
	{
		$data = array(
			'pengirim'			=> $this->input->post('name'),
			'email'					=> $this->input->post('email'),
			'judul' 				=> $this->input->post('subject'),
			'isi' 					=> $this->input->post('message'),
			'create_date'		=> date('Y-m-d H:i:s')
		);

		$insert = $this->callback_model->save($data);
		if ($insert) {
			echo json_encode(array("status" => "ok"));
		} else {
			echo json_encode(array("status" => "error"));
		}
	}

	//VALIDATION
	//1.2. GET PROFILE HEADER
	public function _validation_profile_headers()
	{
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if ($this->input->post('nama_halaman') == '') {
			$data['inputerror'][] = 'nama_halaman';
			$data['error_string'][] = 'Nama Halaman is required';
			$data['status'] = FALSE;
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}

	//1.1. GET PRODUK DETAILS
	private function _validation_produk_details()
	{
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if ($this->input->post('slug') == '') {
			$data['inputerror'][] = 'slug';
			$data['error_string'][] = 'Slug is required';
			$data['status'] = FALSE;
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}

	//1.3. GET PRODUK
	private function _validation_produk_jenis()
	{
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if ($this->input->post('jenis') == '') {
			$data['inputerror'][] = 'jenis';
			$data['error_string'][] = 'Jenis Produk is required';
			$data['status'] = FALSE;
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}
}
