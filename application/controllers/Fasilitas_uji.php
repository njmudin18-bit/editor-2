<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fasilitas_uji extends CI_Controller {

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

    $this->load->model('fasilitas_uji_model', 'fasilitas');
  }

  public function index()
	{
		$data['group_halaman'] 		= "Fasilitas";
		$data['nama_halaman'] 		= "Daftar Fasilitas Uji";
		//$data['icon_halaman'] 		= "icon-layers";
		//$data['perusahaan'] 			= $this->perusahaan->get_details();

		$this->load->view('adminx/tentang_kami/fasilitas', $data, FALSE);
	}

  public function fasilitas_list()
  {
  	$list = $this->fasilitas->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $fasilitas) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
      $row[] = '<a href="javascript:void(0)" onclick="edit('."'".$fasilitas->id."'".')"
									class="btn btn-info btn-sm">
									<i class="mdi mdi-pencil"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$fasilitas->id."'".')"
                	class="btn btn-danger btn-sm">
                	<i class="mdi mdi-window-close"></i>
                </a>';
			$row[] = $fasilitas->aktivasi == 'AKTIF' ? '<h5><span class="badge bg-success">'.strtoupper($fasilitas->aktivasi).'</span></h5>' : '<h5><span class="badge bg-danger">'.strtoupper($fasilitas->aktivasi).'</span></h5>';
			$row[] = $fasilitas->nama;
			$row[] = $fasilitas->image;
			$row[] = $fasilitas->deskripsi;
		
			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->fasilitas->count_all(),
			"recordsFiltered" => $this->fasilitas->count_filtered(),
			"data" 						=> $data,
		);
		//output to json format
		echo json_encode($output);
  }

  public function fasilitas_add() 
  {
  	$this->_validation_fasilitas();

  	//PREPARING CONFIG FILE UPLOAD
  	$new_name                 = $_FILES['file']['name'];
    $config['file_name']      = $new_name;
    $config['upload_path'] 		= './upload/fasilitas_images';
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
				'image'					=> $dataupload['file_name'],
				'deskripsi'			=> $this->input->post('deskripsi'),
				'aktivasi'			=> $this->input->post('aktivasi'),
				'insert_date'		=> date('Y-m-d H:i:s'),
				'insert_by' 		=> $this->session->userdata('user_id')
			);
       
      $insert = $this->fasilitas->save($data);
			echo json_encode(array("status" => "ok"));
    }
  }

	public function fasilitas_edit($id)
	{
		$data = $this->fasilitas->get_by_id($id);
		echo json_encode($data);
	}

	public function fasilitas_update()
	{
		$this->_validation_fasilitas();

		if ($_FILES['file']['name'] == '') {

			$data = array(
				'nama'					=> $this->input->post('nama'),
				'deskripsi'			=> $this->input->post('deskripsi'),
				'aktivasi'			=> $this->input->post('aktivasi'),
				'update_date'		=> date('Y-m-d H:i:s'),
				'update_by' 		=> $this->session->userdata('user_id')
			);
			$this->fasilitas->update(array('id' => $this->input->post('kode')), $data);

			echo json_encode(array("status" => "ok"));
		} else {
			$id 				= $this->input->post('kode');
			$get_image 	= $this->fasilitas->get_by_id($id);

			//print_r($data->slider_image);
			//PREPARING CONFIG FILE UPLOAD
	  	$new_name                 = $_FILES['file']['name'];
	    $config['file_name']      = $new_name;
	    $config['upload_path'] 		= './upload/fasilitas_images';
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
					'image'					=> $dataupload['file_name'],
					'deskripsi'			=> $this->input->post('deskripsi'),
					'aktivasi'			=> $this->input->post('aktivasi'),
					'update_date'		=> date('Y-m-d H:i:s'),
					'update_by' 		=> $this->session->userdata('user_id')
				);
	       
	      $update = $this->fasilitas->update(array('id' => $this->input->post('kode')), $data);
	      if ($update) {
	      	$files 			= "./upload/fasilitas_images/".$get_image->image;
					$hapus_file = unlink($files);

					echo json_encode(array("status" => "ok"));
	      } else {
	      	echo json_encode(array("status" => "failed"));
	      }
	    }
		}
	}

	public function fasilitas_deleted($id)
	{
		$cek_file 	= $this->fasilitas->get_by_id($id);
		$files 			= "./upload/fasilitas_images/".$cek_file->image;
		$hapus_file = unlink($files);
		if ($hapus_file) {
			$data_delete 	= $this->fasilitas->get_by_id($id); //DATA DELETE
			$data 				= $this->fasilitas->delete_by_id($id);
			echo json_encode(array("status" => "ok"));
		}
	}

	private function _validation_fasilitas(){
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama Alat is required';
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