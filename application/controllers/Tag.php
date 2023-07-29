<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag extends CI_Controller {

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

    $this->load->model('tag_model', 'tag');
  }

  public function index()
	{
		$data['group_halaman'] 		= "Beranda";
		$data['nama_halaman'] 		= "Daftar Tag";
		//$data['icon_halaman'] 		= "icon-layers";
		//$data['perusahaan'] 			= $this->perusahaan->get_details();

		$this->load->view('adminx/beranda/tag', $data, FALSE);
	}

  public function tag_list()
  {
  	$list = $this->tag->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $tag) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
      $row[] = '<a href="javascript:void(0)" onclick="edit('."'".$tag->id."'".')"
									class="btn btn-info btn-sm">
									<i class="mdi mdi-pencil"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$tag->id."'".')"
                	class="btn btn-danger btn-sm">
                	<i class="mdi mdi-window-close"></i>
                </a>';
			$row[] = $tag->aktivasi == 'AKTIF' ? '<h5><span class="badge bg-success">'.strtoupper($tag->aktivasi).'</span></h5>' : '<h5><span class="badge bg-danger">'.strtoupper($tag->aktivasi).'</span></h5>';
			$row[] = $tag->urutan;
			$row[] = $tag->main_title;
			$row[] = $tag->sub_title;
			$row[] = $tag->icon;
		
			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->tag->count_all(),
			"recordsFiltered" => $this->tag->count_filtered(),
			"data" 						=> $data,
		);
		//output to json format
		echo json_encode($output);
  }

  public function tag_add_OLD() 
  {
  	$this->_validation_tag();

		$data = array(
			'urutan'			=> $this->input->post('urutan'),
			'main_title'	=> $this->input->post('main_title'),
			'sub_title'		=> $this->input->post('sub_title'),
			'icon'				=> $this->input->post('icon'),
			'aktivasi'		=> $this->input->post('aktivasi'),
			'insert_date'	=> date('Y-m-d H:i:s'),
			'insert_by' 	=> $this->session->userdata('user_id')
		);
     
    $insert = $this->tag->save($data);
		echo json_encode(array("status" => "ok"));
  }

  public function tag_add()
	{
		$this->_validation_tag();

		//PREPARING CONFIG FILE UPLOAD
		$new_name                 = $_FILES['file']['name'];
		$config['file_name']      = $new_name;
		$config['upload_path'] 		= './upload/tag_images';
		$config['allowed_types'] 	= 'pdf|jpg|png';
		$config['max_size']  			= '8192';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file')) {
			$status = "error";
			$msg 		= $this->upload->display_errors();
		} else {

			$dataupload = $this->upload->data();
			$data = array(
        'urutan'			=> $this->input->post('urutan'),
        'main_title'	=> $this->input->post('main_title'),
        'sub_title'		=> $this->input->post('sub_title'),
        'icon'				=> $dataupload['file_name'],
        'aktivasi'		=> $this->input->post('aktivasi'),
        'insert_date'	=> date('Y-m-d H:i:s'),
        'insert_by' 	=> $this->session->userdata('user_id')
			);

			$insert = $this->tag->save($data);
			echo json_encode(array("status" => "ok"));
		}
	}

	public function tag_edit($id)
	{
		$data = $this->tag->get_by_id($id);
		echo json_encode($data);
	}

  public function tag_update()
	{
		$this->_validation_tag();

		if ($_FILES['file']['name'] == '') {

			$data = array(
				'urutan'				=> $this->input->post('urutan'),
        'main_title'		=> $this->input->post('main_title'),
        'sub_title'			=> $this->input->post('sub_title'),
        'aktivasi'			=> $this->input->post('aktivasi'),
        'update_date'		=> date('Y-m-d H:i:s'),
        'update_by' 		=> $this->session->userdata('user_id')
			);
			$this->tag->update(array('id' => $this->input->post('kode')), $data);

			echo json_encode(array("status" => "ok"));
		} else {
			$id 				= $this->input->post('kode');
			$get_image 	= $this->tag->get_by_id($id);

			//PREPARING CONFIG FILE UPLOAD
			$new_name                 = $_FILES['file']['name'];
			$config['file_name']      = $new_name;
			$config['upload_path'] 		= './upload/tag_images';
			$config['allowed_types'] 	= 'pdf|jpg|png';
			$config['max_size']  			= '8192';

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file')) {
				$status = "error";
				$msg 		= $this->upload->display_errors();
			} else {

				$dataupload = $this->upload->data();
				$data = array(
					'urutan'			=> $this->input->post('urutan'),
          'main_title'	=> $this->input->post('main_title'),
          'sub_title'		=> $this->input->post('sub_title'),
          'icon'				=> $dataupload['file_name'],
          'aktivasi'		=> $this->input->post('aktivasi'),
					'update_date'	=> date('Y-m-d H:i:s'),
					'update_by' 	=> $this->session->userdata('user_id')
				);

				$update = $this->tag->update(array('id' => $this->input->post('kode')), $data);
				if ($update) {
					$files 			= "./upload/tag_images/" . $get_image->icon;
					$hapus_file = unlink($files);

					echo json_encode(array("status" => "ok"));
				} else {
					echo json_encode(array("status" => "failed"));
				}
			}
		}
	}

	public function tag_update_OLD()
	{
		$this->_validation_tag();

		$data = array(
			'urutan'				=> $this->input->post('urutan'),
			'main_title'		=> $this->input->post('main_title'),
			'sub_title'			=> $this->input->post('sub_title'),
			'icon'					=> $this->input->post('icon'),
			'aktivasi'			=> $this->input->post('aktivasi'),
			'update_date'		=> date('Y-m-d H:i:s'),
			'update_by' 		=> $this->session->userdata('user_id')
		);

		$this->tag->update(array('id' => $this->input->post('kode')), $data);
		echo json_encode(array("status" => "ok"));
	}

	public function tag_deleted_OLD($id)
	{
		$data = $this->tag->delete_by_id($id);
		echo json_encode(array("status" => "ok"));
	}

  public function tag_deleted($id)
	{
		$cek_file 	= $this->tag->get_by_id($id);
		$files 			= "./upload/tag_images/" . $cek_file->icon;
		$hapus_file = unlink($files);
		if ($hapus_file) {
			$data_delete 	= $this->tag->get_by_id($id);
			$data 				= $this->tag->delete_by_id($id);
			echo json_encode(array("status" => "ok"));
		}
	}

	private function _validation_tag(){
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

		// if($this->input->post('icon') == '')
		// {
		// 	$data['inputerror'][] = 'icon';
		// 	$data['error_string'][] = 'Icon is required';
		// 	$data['status'] = FALSE;
		// }

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