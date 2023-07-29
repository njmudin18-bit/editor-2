<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

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

	public function __construct() {
    parent::__construct();

    $this->load->model('auth_model', 'auth');
    if($this->auth->isNotLogin());

    $this->load->model('pelanggan_model', 'pelanggan');
  }

  public function index()
	{
		$data['group_halaman'] 		= "Pelanggan";
		$data['nama_halaman'] 		= "Daftar Pelanggan";
		//$data['icon_halaman'] 		= "icon-layers";
		//$data['perusahaan'] 			= $this->perusahaan->get_details();

		$this->load->view('adminx/tentang_kami/pelanggan', $data, FALSE);
	}

  public function pelanggan_list()
  {
  	$list = $this->pelanggan->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $pelanggan) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
      $row[] = '<a href="javascript:void(0)" onclick="edit('."'".$pelanggan->id."'".')"
									class="btn btn-info btn-sm">
									<i class="mdi mdi-pencil"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$pelanggan->id."'".')"
                	class="btn btn-danger btn-sm">
                	<i class="mdi mdi-window-close"></i>
                </a>';
			$row[] = $pelanggan->aktivasi == 'AKTIF' ? '<h5><span class="badge bg-success">'.strtoupper($pelanggan->aktivasi).'</span></h5>' : '<h5><span class="badge bg-danger">'.strtoupper($pelanggan->aktivasi).'</span></h5>';
			$row[] = $pelanggan->nama;
			$row[] = $pelanggan->logo;
			$row[] = $pelanggan->insert_date;
			$row[] = $pelanggan->insert_by;
		
			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->pelanggan->count_all(),
			"recordsFiltered" => $this->pelanggan->count_filtered(),
			"data" 						=> $data,
		);
		//output to json format
		echo json_encode($output);
  }

  public function pelanggan_add() 
  {
  	$this->_validation_pelanggan();

  	//PREPARING CONFIG FILE UPLOAD
  	$new_name                 = $_FILES['file']['name'];
    $config['file_name']      = $new_name;
    $config['upload_path'] 		= './upload/pelanggan_images';
    $config['allowed_types'] 	= 'pdf|jpg|png';
    $config['max_size']  			= '8192';

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('file')) {
      $status = "error";
      $msg 		= $this->upload->display_errors();
    } else {

      $dataupload = $this->upload->data();
	    $data = array(
				'nama'					=> $this->input->post('nama'),
				'logo'					=> $dataupload['file_name'],
				'aktivasi'			=> $this->input->post('aktivasi'),
				'insert_date'		=> date('Y-m-d H:i:s'),
				'insert_by' 		=> $this->session->userdata('user_id')
			);
       
      $insert = $this->pelanggan->save($data);
			echo json_encode(array("status" => "ok"));
    }
  }

	public function pelanggan_edit($id)
	{
		$data = $this->pelanggan->get_by_id($id);
		echo json_encode($data);
	}

	public function pelanggan_update()
	{
		$this->_validation_pelanggan();

		if ($_FILES['file']['name'] == '') {

			$data = array(
				'nama'					=> $this->input->post('nama'),
				'aktivasi'			=> $this->input->post('aktivasi'),
				'update_date'		=> date('Y-m-d H:i:s'),
				'update_by' 		=> $this->session->userdata('user_id')
			);
			$this->pelanggan->update(array('id' => $this->input->post('kode')), $data);

			echo json_encode(array("status" => "ok"));
		} else {
			$id 				= $this->input->post('kode');
			$get_image 	= $this->pelanggan->get_by_id($id);

			//print_r($data->slider_image);
			//PREPARING CONFIG FILE UPLOAD
	  	$new_name                 = $_FILES['file']['name'];
	    $config['file_name']      = $new_name;
	    $config['upload_path'] 		= './upload/pelanggan_images';
	    $config['allowed_types'] 	= 'pdf|jpg|png';
	    $config['max_size']  			= '8192';

	    $this->load->library('upload', $config);

	    if (!$this->upload->do_upload('file')) {
	      $status = "error";
	      $msg 		= $this->upload->display_errors();
	    } else {

	      $dataupload = $this->upload->data();
		    $data = array(
					'nama'					=> $this->input->post('nama'),
					'logo'					=> $dataupload['file_name'],
					'aktivasi'			=> $this->input->post('aktivasi'),
					'update_date'		=> date('Y-m-d H:i:s'),
					'update_by' 		=> $this->session->userdata('user_id')
				);
	       
	      $update = $this->pelanggan->update(array('id' => $this->input->post('kode')), $data);
	      if ($update) {
	      	$files 			= "./upload/pelanggan_images/".$get_image->logo;
					$hapus_file = unlink($files);

					echo json_encode(array("status" => "ok"));
	      } else {
	      	echo json_encode(array("status" => "failed"));
	      }
	    }
		}
	}

	public function pelanggan_deleted($id)
	{
		$cek_file 	= $this->pelanggan->get_by_id($id);
		$files 			= "./upload/pelanggan_images/".$cek_file->logo;
		$hapus_file = unlink($files);
		if ($hapus_file) {
			$data_delete 	= $this->pelanggan->get_by_id($id); //DATA DELETE
			$data 				= $this->pelanggan->delete_by_id($id);
			echo json_encode(array("status" => "ok"));
		}
	}

	private function _validation_pelanggan(){
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama Perusahaan is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('aktivasi') == '')
		{
			$data['inputerror'][] = 'aktivasi';
			$data['error_string'][] = 'Aktivasi is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}