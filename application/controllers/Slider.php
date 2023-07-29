<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends CI_Controller {

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

    $this->load->model('slider_model', 'slider');
  }

  public function index()
	{
		$data['group_halaman'] 		= "Slider";
		$data['nama_halaman'] 		= "Daftar Slider";
		//$data['icon_halaman'] 		= "icon-layers";
		//$data['perusahaan'] 			= $this->perusahaan->get_details();

		$this->load->view('adminx/beranda/slider', $data, FALSE);
	}

  public function slider_list()
  {
  	$list = $this->slider->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $slider) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
      $row[] = '<a href="javascript:void(0)" onclick="edit('."'".$slider->id."'".')"
									class="btn btn-info btn-sm">
									<i class="mdi mdi-pencil"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$slider->id."'".')"
                	class="btn btn-danger btn-sm">
                	<i class="mdi mdi-window-close"></i>
                </a>';
			$row[] = $slider->aktivasi == 'AKTIF' ? '<h5><span class="badge bg-success">'.strtoupper($slider->aktivasi).'</span></h5>' : '<h5><span class="badge bg-danger">'.strtoupper($slider->aktivasi).'</span></h5>';
			$row[] = $slider->urutan;
			$row[] = $slider->slider_name;
			$row[] = $slider->slider_image;
			$row[] = $slider->main_title;
			$row[] = $slider->sub_title;
			$row[] = $slider->button_text;
			$row[] = $slider->button_link;
		
			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->slider->count_all(),
			"recordsFiltered" => $this->slider->count_filtered(),
			"data" 						=> $data,
		);
		//output to json format
		echo json_encode($output);
  }

  public function slider_add() 
  {
  	$this->_validation_slider();

  	//PREPARING CONFIG FILE UPLOAD
  	$new_name                 = $_FILES['file']['name'];
    $config['file_name']      = $new_name;
    $config['upload_path'] 		= './upload/slider_images';
    $config['allowed_types'] 	= 'pdf|jpg|png';
    $config['max_size']  			= '8192';

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('file')) {
      $status = "error";
      $msg 		= $this->upload->display_errors();
    } else {

      $dataupload = $this->upload->data();
	    $data = array(
	    	'urutan'				=> $this->input->post('urutan'),
				'slider_name'		=> $this->input->post('slider_name'),
				'slider_image'	=> $dataupload['file_name'],
				'main_title'		=> $this->input->post('main_title'),
				'sub_title'			=> $this->input->post('sub_title'),
				'button_text'		=> $this->input->post('button_text'),
				'button_link'		=> $this->input->post('button_link'),
				'aktivasi'			=> $this->input->post('aktivasi'),
				'insert_date'		=> date('Y-m-d H:i:s'),
				'insert_by' 		=> $this->session->userdata('user_id')
			);
       
      $insert = $this->slider->save($data);
			echo json_encode(array("status" => "ok"));
    }
  }

	public function slider_edit($id)
	{
		$data = $this->slider->get_by_id($id);
		echo json_encode($data);
	}

	public function slider_update()
	{
		$this->_validation_slider();

		if ($_FILES['file']['name'] == '') {

			$data = array(
				'urutan'				=> $this->input->post('urutan'),
				'slider_name'		=> $this->input->post('slider_name'),
				'main_title'		=> $this->input->post('main_title'),
				'sub_title'			=> $this->input->post('sub_title'),
				'button_text'		=> $this->input->post('button_text'),
				'button_link'		=> $this->input->post('button_link'),
				'aktivasi'			=> $this->input->post('aktivasi'),
				'update_date'		=> date('Y-m-d H:i:s'),
				'update_by' 		=> $this->session->userdata('user_id')
			);
			$this->slider->update(array('id' => $this->input->post('kode')), $data);

			echo json_encode(array("status" => "ok"));
		} else {
			$id 				= $this->input->post('kode');
			$get_image 	= $this->slider->get_by_id($id);

			//print_r($data->slider_image);
			//PREPARING CONFIG FILE UPLOAD
	  	$new_name                 = $_FILES['file']['name'];
	    $config['file_name']      = $new_name;
	    $config['upload_path'] 		= './upload/slider_images';
	    $config['allowed_types'] 	= 'pdf|jpg|png';
	    $config['max_size']  			= '8192';

	    $this->load->library('upload', $config);

	    if (!$this->upload->do_upload('file')) {
	      $status = "error";
	      $msg 		= $this->upload->display_errors();
	    } else {

	      $dataupload = $this->upload->data();
		    $data = array(
		    	'urutan'				=> $this->input->post('urutan'),
					'slider_name'		=> $this->input->post('slider_name'),
					'slider_image'	=> $dataupload['file_name'],
					'main_title'		=> $this->input->post('main_title'),
					'sub_title'			=> $this->input->post('sub_title'),
					'button_text'		=> $this->input->post('button_text'),
					'button_link'		=> $this->input->post('button_link'),
					'aktivasi'			=> $this->input->post('aktivasi'),
					'update_date'		=> date('Y-m-d H:i:s'),
					'update_by' 		=> $this->session->userdata('user_id')
				);
	       
	      $update = $this->slider->update(array('id' => $this->input->post('kode')), $data);
	      if ($update) {
	      	$files 			= "./upload/slider_images/".$get_image->slider_image;
					$hapus_file = unlink($files);

					echo json_encode(array("status" => "ok"));
	      } else {
	      	echo json_encode(array("status" => "failed"));
	      }
	    }
		}
	}

	public function slider_hapus($id)
	{
		$cek_file 	= $this->slider->get_by_id($id);
		$files 			= "./upload/slider_images/".$cek_file->nama_file;
		$hapus_file = unlink($files);
		if ($hapus_file) {
			$data_delete 	= $this->slider->get_by_id($id); //DATA DELETE
			$data 				= $this->slider->delete_by_id($id);
			echo json_encode(array("status" => "ok"));
		}
	}

	private function _validation_slider(){
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if($this->input->post('urutan') == '')
		{
			$data['inputerror'][] = 'urutan';
			$data['error_string'][] = 'Urutan is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('slider_name') == '')
		{
			$data['inputerror'][] = 'slider_name';
			$data['error_string'][] = 'Slider Name is required';
			$data['status'] = FALSE;
		}

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