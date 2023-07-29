<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perusahaan extends CI_Controller {

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

    $this->load->model('perusahaan_model', 'perusahaan');
  }

  public function index()
	{
		$data['group_halaman'] 		= "Perusahaan";
		$data['nama_halaman'] 		= "Daftar Perusahaan";
		//$data['icon_halaman'] 		= "icon-layers";
		//$data['perusahaan'] 			= $this->perusahaan->get_details();

		$this->load->view('adminx/general_seetings/perusahaan', $data, FALSE);
	}

  public function perusahaan_list()
  {
  	$list = $this->perusahaan->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $perusahaan) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
      $row[] = '<a href="javascript:void(0)" onclick="edit('."'".$perusahaan->id."'".')"
									class="btn btn-info btn-sm">
									<i class="mdi mdi-pencil"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$perusahaan->id."'".')"
                	class="btn btn-danger btn-sm">
                	<i class="mdi mdi-window-close"></i>
                </a>
                <a href="javascript:void(0)" onclick="openModalUpload('."'".$perusahaan->id."'".')" title="Tambahkan Icon Perusahaan"
                	class="btn btn-warning btn-sm">
                	<i class="mdi mdi-upload"></i>
                </a>';
			$row[] = $perusahaan->aktivasi == 'AKTIF' ? '<h5><span class="badge bg-success">'.strtoupper($perusahaan->aktivasi).'</span></h5>' : '<h5><span class="badge bg-danger">'.strtoupper($perusahaan->aktivasi).'</span></h5>';
			$row[] = $perusahaan->nama;
			$row[] = $perusahaan->telepon;
			$row[] = $perusahaan->handphone;
			$row[] = $perusahaan->fax;
			$row[] = $perusahaan->email;
			$row[] = $perusahaan->alamat;
			$row[] = $perusahaan->icon_name;
			$row[] = $perusahaan->logo_name;
			$row[] = $perusahaan->twitter;
			$row[] = $perusahaan->facebook;
			$row[] = $perusahaan->instagram;
			$row[] = $perusahaan->pinterest;
			$row[] = $perusahaan->youtube;
			$row[] = $perusahaan->skype;
		
			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->perusahaan->count_all(),
			"recordsFiltered" => $this->perusahaan->count_filtered(),
			"data" 						=> $data,
		);
		//output to json format
		echo json_encode($output);
  }

  public function perusahaan_add() 
  {
  	$this->_validation_perusahaan();

  	//PREPARING CONFIG FILE UPLOAD
  	$new_name                 = $_FILES['file']['name'];
    $config['file_name']      = $new_name;
    $config['upload_path'] 		= './upload/general_images';
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
				'logo_name'			=> $dataupload['file_name'],
				'aktivasi'			=> $this->input->post('aktivasi'),
				'telepon'				=> $this->input->post('telepon'),
				'handphone'			=> $this->input->post('handphone'),
				'fax'						=> $this->input->post('fax'),
				'email'					=> $this->input->post('email'),
				'alamat'				=> $this->input->post('alamat'),
				'maps'					=> $this->input->post('maps'),
				'twitter'				=> $this->input->post('twitter'),
				'facebook'			=> $this->input->post('facebook'),
				'instagram'			=> $this->input->post('instagram'),
				'pinterest'			=> $this->input->post('pinterest'),
				'youtube'				=> $this->input->post('youtube'),
				'skype'					=> $this->input->post('skype'),
				'insert_date'		=> date('Y-m-d H:i:s'),
				'insert_by' 		=> $this->session->userdata('user_id')
			);
       
      $insert = $this->perusahaan->save($data);
			echo json_encode(array("status" => "ok"));
    }
  }

	public function perusahaan_edit($id)
	{
		$data = $this->perusahaan->get_by_id($id);
		echo json_encode($data);
	}

	public function perusahaan_update()
	{
		$this->_validation_perusahaan();

		if ($_FILES['file']['name'] == '') {

			$data = array(
				'nama'					=> $this->input->post('nama'),
				'aktivasi'			=> $this->input->post('aktivasi'),
				'telepon'				=> $this->input->post('telepon'),
				'handphone'			=> $this->input->post('handphone'),
				'fax'						=> $this->input->post('fax'),
				'email'					=> $this->input->post('email'),
				'alamat'				=> $this->input->post('alamat'),
				'maps'					=> $this->input->post('maps'),
				'twitter'				=> $this->input->post('twitter'),
				'facebook'			=> $this->input->post('facebook'),
				'instagram'			=> $this->input->post('instagram'),
				'pinterest'			=> $this->input->post('pinterest'),
				'youtube'				=> $this->input->post('youtube'),
				'skype'					=> $this->input->post('skype'),
				'update_date'		=> date('Y-m-d H:i:s'),
				'update_by' 		=> $this->session->userdata('user_id')
			);
			$this->perusahaan->update(array('id' => $this->input->post('kode')), $data);

			echo json_encode(array("status" => "ok"));
		} else {
			$id 				= $this->input->post('kode');
			$get_image 	= $this->perusahaan->get_by_id($id);

			//PREPARING CONFIG FILE UPLOAD
	  	$new_name                 = $_FILES['file']['name'];
	    $config['file_name']      = $new_name;
	    $config['upload_path'] 		= './upload/general_images';
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
					'logo_name'			=> $dataupload['file_name'],
					'aktivasi'			=> $this->input->post('aktivasi'),
					'telepon'				=> $this->input->post('telepon'),
					'handphone'			=> $this->input->post('handphone'),
					'fax'						=> $this->input->post('fax'),
					'email'					=> $this->input->post('email'),
					'alamat'				=> $this->input->post('alamat'),
					'maps'					=> $this->input->post('maps'),
					'twitter'				=> $this->input->post('twitter'),
					'facebook'			=> $this->input->post('facebook'),
					'instagram'			=> $this->input->post('instagram'),
					'pinterest'			=> $this->input->post('pinterest'),
					'youtube'				=> $this->input->post('youtube'),
					'skype'					=> $this->input->post('skype'),
					'update_date'		=> date('Y-m-d H:i:s'),
					'update_by' 		=> $this->session->userdata('user_id')
				);
	       
	      $update = $this->perusahaan->update(array('id' => $this->input->post('kode')), $data);
	      if ($update) {
	      	$files 			= "./upload/general_images/".$get_image->logo_name;
					$hapus_file = unlink($files);

					echo json_encode(array("status" => "ok"));
	      } else {
	      	echo json_encode(array("status" => "failed"));
	      }
	    }
		}
	}

	public function perusahaan_deleted($id)
	{
		$cek_file 	= $this->perusahaan->get_by_id($id);
		$files 			= "./upload/general_images/".$cek_file->logo_name;
		$hapus_file = unlink($files);
		if ($hapus_file) {
			$data_delete 	= $this->perusahaan->get_by_id($id); //DATA DELETE
			$data 				= $this->perusahaan->delete_by_id($id);
			echo json_encode(array("status" => "ok"));
		}
	}


	//FUNCTION UPLOAD ICON
	public function upload_icon()
	{
		$id 				= $this->input->post('kode_perusahaan');
		$get_image 	= $this->perusahaan->get_by_id($id);

		//PREPARING CONFIG FILE UPLOAD
  	$new_name                 = $_FILES['file_icon']['name'];
    $config['file_name']      = $new_name;
    $config['upload_path'] 		= './upload/general_images';
    $config['allowed_types'] 	= 'pdf|jpg|png';
    $config['max_size']  			= '8192';
    /*print_r($config);
    exit();*/
    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('file_icon')) {
      $status = "error";
      $msg 		= $this->upload->display_errors();

      echo $msg;
    } else {

      $dataupload = $this->upload->data();
	    $data = array(
				'icon_name'			=> $dataupload['file_name'],
				'update_date'		=> date('Y-m-d H:i:s'),
				'update_by' 		=> $this->session->userdata('user_id')
			);
       
      $update = $this->perusahaan->update(array('id' => $id), $data);
      if ($update) {

      	$cek_icon = $get_image->icon_name;
      	//echo $icon_name;
      	if ($cek_icon == '' || $cek_icon == null) {
      		echo json_encode(array("status" => "ok"));
      	} else {
      		$files 			= "./upload/general_images/".$get_image->icon_name;
					$hapus_file = unlink($files);

					echo json_encode(array("status" => "ok"));
      	}
      } else {
      	echo json_encode(array("status" => "failed"));
      }
    }
	}

	private function _validation_perusahaan(){
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

		if($this->input->post('telepon') == '')
		{
			$data['inputerror'][] = 'telepon';
			$data['error_string'][] = 'Nomor Telepon is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('handphone') == '')
		{
			$data['inputerror'][] = 'handphone';
			$data['error_string'][] = 'Nomor Handphone is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('fax') == '')
		{
			$data['inputerror'][] = 'fax';
			$data['error_string'][] = 'Nomor Fax is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('email') == '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Alamat Email is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('alamat') == '')
		{
			$data['inputerror'][] = 'alamat';
			$data['error_string'][] = 'Alamat Perusahaan is required';
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