<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_header extends CI_Controller {

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

    $this->load->model('profile_header_model', 'profile_header');
  }

  public function index()
	{
		$data['group_halaman'] 		= "General Settings";
		$data['nama_halaman'] 		= "Profile Header";
		//$data['icon_halaman'] 		= "icon-layers";
		//$data['perusahaan'] 			= $this->perusahaan->get_details();

		$this->load->view('adminx/general_seetings/profile_header', $data, FALSE);
	}

  public function profile_header_list()
  {
  	$list = $this->profile_header->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $profile_header) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
      $row[] = '<a href="javascript:void(0)" onclick="edit('."'".$profile_header->id."'".')"
									class="btn btn-info btn-sm">
									<i class="mdi mdi-pencil"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$profile_header->id."'".')"
                	class="btn btn-danger btn-sm">
                	<i class="mdi mdi-window-close"></i>
                </a>';
			$row[] = $profile_header->aktivasi == 'AKTIF' ? '<h5><span class="badge bg-success">'.strtoupper($profile_header->aktivasi).'</span></h5>' : '<h5><span class="badge bg-danger">'.strtoupper($profile_header->aktivasi).'</span></h5>';
			$row[] = $profile_header->nama;
			$row[] = $profile_header->url;
			$row[] = $profile_header->images;
		
			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->profile_header->count_all(),
			"recordsFiltered" => $this->profile_header->count_filtered(),
			"data" 						=> $data,
		);
		//output to json format
		echo json_encode($output);
  }

  public function profile_header_add() 
  {
  	$this->_validation_profile_header();

		//PREPARING CONFIG FILE UPLOAD
  	$new_name                 = $_FILES['file']['name'];
    $config['file_name']      = $new_name;
    $config['upload_path'] 		= './upload/profile_header_images';
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
				'url'					  => $this->input->post('url'),
				'images'				=> $dataupload['file_name'],
				'aktivasi'			=> $this->input->post('aktivasi'),
				'insert_date'		=> date('Y-m-d H:i:s'),
				'insert_by' 		=> $this->session->userdata('user_id')
			);
       
      $insert = $this->profile_header->save($data);
			echo json_encode(array("status" => "ok"));
    }
  }

	public function profile_header_edit($id)
	{
		$data = $this->profile_header->get_by_id($id);
		echo json_encode($data);
	}

	public function profile_header_update()
	{
		$this->_validation_profile_header();

		if ($_FILES['file']['name'] == '') {

			$data = array(
				'nama'					=> $this->input->post('nama'),
        'url'					  => $this->input->post('url'),
				'aktivasi'			=> $this->input->post('aktivasi'),
				'update_date'		=> date('Y-m-d H:i:s'),
				'update_by' 		=> $this->session->userdata('user_id')
			);
			$this->profile_header->update(array('id' => $this->input->post('kode')), $data);

			echo json_encode(array("status" => "ok"));
		} else {
			$id 				= $this->input->post('kode');
			$get_image 	= $this->profile_header->get_by_id($id);

			//print_r($data->slider_image);
			//PREPARING CONFIG FILE UPLOAD
	  	$new_name                 = $_FILES['file']['name'];
	    $config['file_name']      = $new_name;
	    $config['upload_path'] 		= './upload/profile_header_images';
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
          'url'					  => $this->input->post('url'),
					'images'				=> $dataupload['file_name'],
					'aktivasi'			=> $this->input->post('aktivasi'),
					'update_date'		=> date('Y-m-d H:i:s'),
					'update_by' 		=> $this->session->userdata('user_id')
				);
	       
	      $update = $this->profile_header->update(array('id' => $this->input->post('kode')), $data);
	      if ($update) {
	      	$files 			= "./upload/profile_header_images/".$get_image->images;
					$hapus_file = unlink($files);

					echo json_encode(array("status" => "ok"));
	      } else {
	      	echo json_encode(array("status" => "failed"));
	      }
	    }
		}
	}

	public function profile_header_deleted($id)
	{
		$cek_file 	= $this->profile_header->get_by_id($id);
		$files 			= "./upload/profile_header_images/".$cek_file->images;
		$hapus_file = unlink($files);
		if ($hapus_file) {
			$data_delete 	= $this->profile_header->get_by_id($id); //DATA DELETE
			$data 				= $this->profile_header->delete_by_id($id);
			echo json_encode(array("status" => "ok"));
		}
	}

	private function _validation_profile_header(){
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama Profile is required';
			$data['status'] = FALSE;
		}

    if($this->input->post('url') == '')
		{
			$data['inputerror'][] = 'url';
			$data['error_string'][] = 'URL is required';
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