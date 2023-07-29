<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

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

    $this->load->model('profile_model', 'profile');
  }

  public function index()
	{
		$data['group_halaman'] 		= "Tentang Kami";
		$data['nama_halaman'] 		= "Profile";

		$this->load->view('adminx/tentang_kami/profile', $data, FALSE);
	}

  public function profile_list()
  {
  	$list = $this->profile->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $profile) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
      $row[] = '<a href="javascript:void(0)" onclick="edit('."'".$profile->id."'".')"
									class="btn btn-info btn-sm">
									<i class="mdi mdi-pencil"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$profile->id."'".')"
                	class="btn btn-danger btn-sm">
                	<i class="mdi mdi-window-close"></i>
                </a>';
			$row[] = $profile->aktivasi == 'AKTIF' ? '<h5><span class="badge bg-success">'.strtoupper($profile->aktivasi).'</span></h5>' : '<h5><span class="badge bg-danger">'.strtoupper($profile->aktivasi).'</span></h5>';
			$row[] = $profile->main_title;
			$row[] = $profile->contents;
			$row[] = '<div class="conversation-list">
									<div class="chat-avatar">
										<img src="'.base_url().'upload/profile_images/'.$profile->images.'" class="rounded" alt="'.$profile->main_title.'">
									</div>
								</div>';
			//$row[] = $profile->images;
		
			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->profile->count_all(),
			"recordsFiltered" => $this->profile->count_filtered(),
			"data" 						=> $data,
		);
		//output to json format
		echo json_encode($output);
  }

  public function profile_add() 
  {
  	$this->_validation_profile();

		//PREPARING CONFIG FILE UPLOAD
  	$new_name                 = $_FILES['file']['name'];
    $config['file_name']      = $new_name;
    $config['upload_path'] 		= './upload/profile_images';
    $config['allowed_types'] 	= 'pdf|jpg|png';
    $config['max_size']  			= '8192';

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('file')) {
      $status = "error";
      $msg 		= $this->upload->display_errors();
    } else {

      $dataupload = $this->upload->data();
	    $data = array(
				'main_title'		=> $this->input->post('main_title'),
				'contents'			=> $this->input->post('contents'),
				'images'				=> $dataupload['file_name'],
				'aktivasi'			=> $this->input->post('aktivasi'),
				'insert_date'		=> date('Y-m-d H:i:s'),
				'insert_by' 		=> $this->session->userdata('user_id')
			);
       
      $insert = $this->profile->save($data);
			echo json_encode(array("status" => "ok"));
    }
  }

	public function profile_edit($id)
	{
		$data = $this->profile->get_by_id($id);
		echo json_encode($data);
	}

	public function profile_update()
	{
		$this->_validation_profile();

		if ($_FILES['file']['name'] == '') {

			$data = array(
				'main_title'		=> $this->input->post('main_title'),
				'contents'			=> $this->input->post('contents'),
				'aktivasi'			=> $this->input->post('aktivasi'),
				'update_date'		=> date('Y-m-d H:i:s'),
				'update_by' 		=> $this->session->userdata('user_id')
			);
			$this->profile->update(array('id' => $this->input->post('kode')), $data);

			echo json_encode(array("status" => "ok"));
		} else {
			$id 				= $this->input->post('kode');
			$get_image 	= $this->profile->get_by_id($id);
      

			//PREPARING CONFIG FILE UPLOAD
	  	$new_name                 = $_FILES['files']['name'];
	    $config['file_name']      = $new_name;
	    $config['upload_path'] 		= './upload/profile_images';
	    $config['allowed_types'] 	= 'png|jpg';
	    $config['max_size']  			= '8192';

	    $this->load->library('upload', $config);

	    if (!$this->upload->do_upload('file')) {
	      $status = "error";
	      $msg 		= $this->upload->display_errors();
        print_r($msg); exit;
	    } else {

	      $dataupload = $this->upload->data();
		    $data = array(
					'main_title'		=> $this->input->post('main_title'),
					'contents'			=> $this->input->post('contents'),
					'images'				=> $dataupload['file_name'],
					'aktivasi'			=> $this->input->post('aktivasi'),
					'update_date'		=> date('Y-m-d H:i:s'),
					'update_by' 		=> $this->session->userdata('user_id')
				);
	       
	      $update = $this->profile->update(array('id' => $this->input->post('kode')), $data);
	      if ($update) {
	      	$files 			= "./upload/profile_images/".$get_image->images;
					$hapus_file = unlink($files);

					echo json_encode(array("status" => "ok"));
	      } else {
	      	echo json_encode(array("status" => "failed"));
	      }
	    }
		}
	}

	public function profile_deleted($id)
	{
		$cek_file 	= $this->profile->get_by_id($id);
		$files 			= "./upload/profile_images/".$cek_file->images;
		$hapus_file = unlink($files);
		if ($hapus_file) {
			$data_delete 	= $this->profile->get_by_id($id); //DATA DELETE
			$data 				= $this->profile->delete_by_id($id);
			echo json_encode(array("status" => "ok"));
		}
	}

	private function _validation_profile(){
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if($this->input->post('main_title') == '')
		{
			$data['inputerror'][] = 'main_title';
			$data['error_string'][] = 'Main Title is required';
			$data['status'] = FALSE;
		}

		/*if($this->input->post('sub_title') == '')
		{
			$data['inputerror'][] = 'sub_title';
			$data['error_string'][] = 'Sub Title is required';
			$data['status'] = FALSE;
		}*/

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