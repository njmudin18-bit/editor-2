<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
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

		$this->load->model('auth_model', 'auth');
		if ($this->auth->isNotLogin());

		$this->load->model('jenis_produk_model', 'jenis_produk');
		$this->load->model('produk_model', 'produk_model');
	}

	public function index()
	{
		$data['group_halaman'] 		= "Produk";
		$data['nama_halaman'] 		= "Daftar Produk";
		$data['jenis_produk'] 		= $this->jenis_produk->get_alls();
		//$data['icon_halaman'] 		= "icon-layers";
		//$data['perusahaan'] 			= $this->perusahaan->get_details();

		$this->load->view('adminx/produk/produk', $data, FALSE);
	}

	public function produk_list()
	{
		$list 			= $this->produk_model->get_datatables();
		$data 			= array();
		$no 				= $_POST['start'];
		$noUrut 		= 0;
		foreach ($list as $produk_model) {

			$no++;
			$noUrut++;
			$row 	 = array();
			$row[] = $no;
			//add html for action
			$row[] = '<a href="javascript:void(0)" onclick="edit(' . "'" . $produk_model->id . "'" . ')"
									class="btn btn-info btn-sm">
									<i class="mdi mdi-pencil"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete(' . "'" . $produk_model->id . "'" . ')"
                	class="btn btn-danger btn-sm">
                	<i class="mdi mdi-window-close"></i>
                </a>';
			$row[] = $produk_model->aktivasi == 'AKTIF' ? '<h5><span class="badge bg-success">' . strtoupper($produk_model->aktivasi) . '</span></h5>' : '<h5><span class="badge bg-danger">' . strtoupper($produk_model->aktivasi) . '</span></h5>';
			$row[] = $produk_model->jenis_produk;
			$row[] = $produk_model->nama_produk;
			$row[] = $produk_model->nominal_voltage;
			//$row[] = $produk_model->id;
			$row[] = $this->produk_available($produk_model->id);
			$row[] = '<div class="conversation-list">
									<div class="chat-avatar">
										<img src="' . base_url() . 'upload/produk_images/' . $produk_model->images . '" class="rounded" alt="' . $produk_model->nama_produk . '">
									</div>
								</div>';
			//$row[] = $produk_model->images;

			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->produk_model->count_all(),
			"recordsFiltered" => $this->produk_model->count_filtered(),
			"data" 						=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function produk_available($id)
	{
		$sql 	= $this->db->query("SELECT * FROM table_produk WHERE id = '$id'");
		$data = $sql->row();
		$list_types = explode(';', $data->available_types); //print_r($list_types); exit;

		$available 	= "";
		$available .= "<ol>";
		foreach ($list_types as $key => $value) {
			$available .= "<li class='mb-1'>" . $value . "</li>";
		}
		$available .= "<ol>";

		return $available;
	}

	public function produk_add()
	{
		$this->_validation_produk();

		//PREPARING CONFIG FILE UPLOAD
		$new_name                 = $_FILES['file']['name'];
		$config['file_name']      = $new_name;
		$config['upload_path'] 		= './upload/produk_images';
		$config['allowed_types'] 	= 'pdf|jpg|png';
		$config['max_size']  			= '8192';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file')) {
			$status = "error";
			$msg 		= $this->upload->display_errors();
		} else {

			$dataupload = $this->upload->data();
			$data = array(
				'id_jenis'					=> $this->input->post('id_jenis'),
				'nama_produk'				=> $this->input->post('nama_produk'),
				'slug'							=> slug($this->input->post('nama_produk')),
				'images'						=> $dataupload['file_name'],
				'nominal_voltage'		=> $this->input->post('nominal_voltage'),
				'available_types'		=> $this->input->post('available_types'),
				'aktivasi'					=> $this->input->post('aktivasi'),
				'insert_date'				=> date('Y-m-d H:i:s'),
				'insert_by' 				=> $this->session->userdata('user_id')
			);

			$insert = $this->produk_model->save($data);
			echo json_encode(array("status" => "ok"));
		}
	}

	public function produk_edit($id)
	{
		$data = $this->produk_model->get_by_id($id);
		echo json_encode($data);
	}

	public function produk_update()
	{
		$this->_validation_produk();

		if ($_FILES['file']['name'] == '') {

			$data = array(
				'id_jenis'					=> $this->input->post('id_jenis'),
				'nama_produk'				=> $this->input->post('nama_produk'),
				'slug'							=> slug($this->input->post('nama_produk')),
				'nominal_voltage'		=> $this->input->post('nominal_voltage'),
				'available_types'		=> $this->input->post('available_types'),
				'aktivasi'					=> $this->input->post('aktivasi'),
				'update_date'				=> date('Y-m-d H:i:s'),
				'update_by' 				=> $this->session->userdata('user_id')
			);
			$this->produk_model->update(array('id' => $this->input->post('kode')), $data);

			echo json_encode(array("status" => "ok"));
		} else {
			$id 				= $this->input->post('kode');
			$get_image 	= $this->produk_model->get_by_id($id);

			//PREPARING CONFIG FILE UPLOAD
			$new_name                 = $_FILES['file']['name'];
			$config['file_name']      = $new_name;
			$config['upload_path'] 		= './upload/produk_images';
			$config['allowed_types'] 	= 'pdf|jpg|png';
			$config['max_size']  			= '8192';

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file')) {
				$status = "error";
				$msg 		= $this->upload->display_errors();
			} else {

				$dataupload = $this->upload->data();
				$data = array(
					'id_jenis'					=> $this->input->post('id_jenis'),
					'nama_produk'				=> $this->input->post('nama_produk'),
					'slug'							=> slug($this->input->post('nama_produk')),
					'images'						=> $dataupload['file_name'],
					'nominal_voltage'		=> $this->input->post('nominal_voltage'),
					'available_types'		=> $this->input->post('available_types'),
					'aktivasi'					=> $this->input->post('aktivasi'),
					'update_date'				=> date('Y-m-d H:i:s'),
					'update_by' 				=> $this->session->userdata('user_id')
				);

				$update = $this->produk_model->update(array('id' => $this->input->post('kode')), $data);
				if ($update) {
					$files 			= "./upload/produk_images/" . $get_image->images;
					$hapus_file = unlink($files);

					echo json_encode(array("status" => "ok"));
				} else {
					echo json_encode(array("status" => "failed"));
				}
			}
		}
	}

	public function produk_deleted($id)
	{
		$cek_file 	= $this->produk_model->get_by_id($id);
		$files 			= "./upload/produk_images/" . $cek_file->images;
		$hapus_file = unlink($files);
		if ($hapus_file) {
			$data_delete 	= $this->produk_model->get_by_id($id); //DATA DELETE
			$data 				= $this->produk_model->delete_by_id($id);
			echo json_encode(array("status" => "ok"));
		}
	}

	private function _validation_produk()
	{
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if ($this->input->post('id_jenis') == '') {
			$data['inputerror'][] 	= 'id_jenis';
			$data['error_string'][] = 'Jenis Produk is required';
			$data['status'] 				= FALSE;
		}

		if ($this->input->post('nama_produk') == '') {
			$data['inputerror'][] 	= 'nama_produk';
			$data['error_string'][] = 'Nama Produk is required';
			$data['status'] 				= FALSE;
		}

		if ($this->input->post('nominal_voltage') == '') {
			$data['inputerror'][] 	= 'nominal_voltage';
			$data['error_string'][] = 'Nominal Voltage is required';
			$data['status'] 				= FALSE;
		}

		if ($this->input->post('available_types') == '') {
			$data['inputerror'][] 	= 'available_types';
			$data['error_string'][] = 'Available Types is required';
			$data['status'] 				= FALSE;
		}

		if ($this->input->post('aktivasi') == '') {
			$data['inputerror'][] 	= 'aktivasi';
			$data['error_string'][] = 'Aktivasi is required';
			$data['status'] 				= FALSE;
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}
}
