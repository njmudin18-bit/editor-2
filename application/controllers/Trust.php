<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trust extends CI_Controller {

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

    $this->load->model('trust_model', 'trust');
  }

  public function index()
	{
		$data['group_halaman'] 		= "Beranda";
		$data['nama_halaman'] 		= "Daftar Kepercayaan";
		//$data['icon_halaman'] 		= "icon-layers";
		//$data['perusahaan'] 			= $this->perusahaan->get_details();

		$this->load->view('adminx/beranda/trust', $data, FALSE);
	}

  public function trust_list()
  {
  	$list = $this->trust->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $trust) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
      $row[] = '<a href="javascript:void(0)" onclick="edit('."'".$trust->id."'".')"
									class="btn btn-info btn-sm">
									<i class="mdi mdi-pencil"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$trust->id."'".')"
                	class="btn btn-danger btn-sm">
                	<i class="mdi mdi-window-close"></i>
                </a>';
			$row[] = $trust->aktivasi == 'AKTIF' ? '<h5><span class="badge bg-success">'.strtoupper($trust->aktivasi).'</span></h5>' : '<h5><span class="badge bg-danger">'.strtoupper($trust->aktivasi).'</span></h5>';
			$row[] = $trust->main_title;
			$row[] = $trust->sub_title;
			$row[] = $trust->button_text;
			$row[] = $trust->button_link;
			$row[] = $trust->images;
		
			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->trust->count_all(),
			"recordsFiltered" => $this->trust->count_filtered(),
			"data" 						=> $data,
		);
		//output to json format
		echo json_encode($output);
  }

  public function trust_add() 
  {
  	$this->_validation_trust();

		//PREPARING CONFIG FILE UPLOAD
  	$new_name                 = $_FILES['file']['name'];
    $config['file_name']      = $new_name;
    $config['upload_path'] 		= './upload/trust_images';
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
				'sub_title'			=> $this->input->post('sub_title'),
				'button_text'		=> $this->input->post('button_text'),
				'button_link'		=> $this->input->post('button_link'),
				'images'				=> $dataupload['file_name'],
				'aktivasi'			=> $this->input->post('aktivasi'),
				'insert_date'		=> date('Y-m-d H:i:s'),
				'insert_by' 		=> $this->session->userdata('user_id')
			);
       
      $insert = $this->trust->save($data);
			echo json_encode(array("status" => "ok"));
    }
  }

	public function trust_edit($id)
	{
		$data = $this->trust->get_by_id($id);
		echo json_encode($data);
	}

	public function trust_update()
	{
		$this->_validation_trust();

		if ($_FILES['file']['name'] == '') {

			$data = array(
				'main_title'		=> $this->input->post('main_title'),
				'sub_title'			=> $this->input->post('sub_title'),
				'button_text'		=> $this->input->post('button_text'),
				'button_link'		=> $this->input->post('button_link'),
				'aktivasi'			=> $this->input->post('aktivasi'),
				'update_date'		=> date('Y-m-d H:i:s'),
				'update_by' 		=> $this->session->userdata('user_id')
			);
			$this->trust->update(array('id' => $this->input->post('kode')), $data);

			echo json_encode(array("status" => "ok"));
		} else {
			$id 				= $this->input->post('kode');
			$get_image 	= $this->trust->get_by_id($id);

			//PREPARING CONFIG FILE UPLOAD
	  	$new_name                 = $_FILES['file']['name'];
	    $config['file_name']      = $new_name;
	    $config['upload_path'] 		= './upload/trust_images';
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
					'sub_title'			=> $this->input->post('sub_title'),
					'button_text'		=> $this->input->post('button_text'),
					'button_link'		=> $this->input->post('button_link'),
					'images'				=> $dataupload['file_name'],
					'aktivasi'			=> $this->input->post('aktivasi'),
					'update_date'		=> date('Y-m-d H:i:s'),
					'update_by' 		=> $this->session->userdata('user_id')
				);
	       
	      $update = $this->trust->update(array('id' => $this->input->post('kode')), $data);
	      if ($update) {
	      	$files 			= "./upload/trust_images/".$get_image->images;
					$hapus_file = unlink($files);

					echo json_encode(array("status" => "ok"));
	      } else {
	      	echo json_encode(array("status" => "failed"));
	      }
	    }
		}
	}

	public function trust_deleted($id)
	{
		$cek_file 	= $this->trust->get_by_id($id);
		$files 			= "./upload/trust_images/".$cek_file->images;
		$hapus_file = unlink($files);
		if ($hapus_file) {
			$data_delete 	= $this->trust->get_by_id($id); //DATA DELETE
			$data 				= $this->trust->delete_by_id($id);
			echo json_encode(array("status" => "ok"));
		}
	}

	private function _validation_trust(){
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

		if($this->input->post('sub_title') == '')
		{
			$data['inputerror'][] = 'sub_title';
			$data['error_string'][] = 'Sub Title is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('button_text') == '')
		{
			$data['inputerror'][] = 'button_text';
			$data['error_string'][] = 'Button Text is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('button_link') == '')
		{
			$data['inputerror'][] = 'button_link';
			$data['error_string'][] = 'Button Link is required';
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