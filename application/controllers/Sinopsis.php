<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sinopsis extends CI_Controller {

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

    $this->load->model('sinopsis_model', 'sinopsis');
  }

  public function index()
	{
		$data['group_halaman'] 		= "Sinopsis";
		$data['nama_halaman'] 		= "Daftar Sinopsis";
		//$data['icon_halaman'] 		= "icon-layers";
		//$data['perusahaan'] 			= $this->perusahaan->get_details();

		$this->load->view('adminx/beranda/sinopsis', $data, FALSE);
	}

  public function sinopsis_list()
  {
  	$list = $this->sinopsis->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $sinopsis) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
      $row[] = '<a href="javascript:void(0)" onclick="edit('."'".$sinopsis->id."'".')"
									class="btn btn-info btn-sm">
									<i class="mdi mdi-pencil"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$sinopsis->id."'".')"
                	class="btn btn-danger btn-sm">
                	<i class="mdi mdi-window-close"></i>
                </a>';
      $row[] = $sinopsis->urutan;
			$row[] = $sinopsis->aktivasi == 'AKTIF' ? '<h5><span class="badge bg-success">'.strtoupper($sinopsis->aktivasi).'</span></h5>' : '<h5><span class="badge bg-danger">'.strtoupper($sinopsis->aktivasi).'</span></h5>';
			$row[] = $sinopsis->product_name;
			$row[] = $sinopsis->product_images == '' ? '-' : $sinopsis->product_images;
			$row[] = $sinopsis->types;
		
			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->sinopsis->count_all(),
			"recordsFiltered" => $this->sinopsis->count_filtered(),
			"data" 						=> $data,
		);
		//output to json format
		echo json_encode($output);
  }

  public function sinopsis_add() 
  {
  	$this->_validation_sinopsis();

  	if ($_FILES['file']['name'] == '') {

  		$data = array(
				'product_name'		=> $this->input->post('product_name'),
				'product_desc'		=> $this->input->post('product_desc'),
				'aktivasi'				=> $this->input->post('aktivasi'),
				'urutan'					=> $this->input->post('urutan'),
				'types'						=> $this->input->post('types'),
				'link'						=> $this->input->post('link'),
				'insert_date'			=> date('Y-m-d H:i:s'),
				'insert_by' 			=> $this->session->userdata('user_id')
			);
       
      $insert = $this->sinopsis->save($data);
			echo json_encode(array("status" => "ok"));

  	} else {

	  	//PREPARING CONFIG FILE UPLOAD
	  	$product_name 						= $this->input->post('product_name');
	  	$new_name                 = $product_name."_".$_FILES['file']['name'];
	    $config['file_name']      = $new_name;
	    $config['upload_path'] 		= './upload/sinopsis_images';
	    $config['allowed_types'] 	= 'pdf|jpg|png';
	    $config['max_size']  			= '8192';

	    $this->load->library('upload', $config);

	    if (!$this->upload->do_upload('file')) {
	      $status = "error";
	      $msg 		= $this->upload->display_errors();
	    } else {

	      $dataupload = $this->upload->data();
		    $data = array(
					'product_name'		=> $this->input->post('product_name'),
					'product_desc'		=> $this->input->post('product_desc'),
					'product_images'	=> $dataupload['file_name'],
					'aktivasi'				=> $this->input->post('aktivasi'),
					'urutan'					=> $this->input->post('urutan'),
					'types'						=> $this->input->post('types'),
					'link'						=> $this->input->post('link'),
					'insert_date'			=> date('Y-m-d H:i:s'),
					'insert_by' 			=> $this->session->userdata('user_id')
				);
	       
	      $insert = $this->sinopsis->save($data);
				echo json_encode(array("status" => "ok"));
	    }
	  }
  }

	public function sinopsis_edit($id)
	{
		$data = $this->sinopsis->get_by_id($id);
		echo json_encode($data);
	}

	public function sinopsis_update()
	{
		$this->_validation_sinopsis();

		if ($_FILES['file']['name'] == '') {
			//echo "lewat sini";
			$id 				= $this->input->post('kode');
			$types 			= $this->input->post('types');
			$get_image 	= $this->sinopsis->get_by_id($id);
			if ($get_image->types == 'IMAGES' && $get_image->product_images != '') {
				$files 			= "./upload/sinopsis_images/".$get_image->product_images;
				$hapus_file = unlink($files);
				if ($hapus_file) {
					$data = array(
						'product_name'		=> $this->input->post('product_name'),
						'product_desc'		=> $this->input->post('product_desc'),
						'aktivasi'				=> $this->input->post('aktivasi'),
						'urutan'					=> $this->input->post('urutan'),
						'types'						=> $this->input->post('types'),
						'link'						=> $this->input->post('link'),
						'update_date'			=> date('Y-m-d H:i:s'),
						'update_by' 			=> $this->session->userdata('user_id')
					);
					$this->sinopsis->update(array('id' => $this->input->post('kode')), $data);
				} else {
					echo "gagal hapus files";
				}
			} else {
				$data = array(
					'product_name'		=> $this->input->post('product_name'),
					'product_desc'		=> $this->input->post('product_desc'),
					'aktivasi'				=> $this->input->post('aktivasi'),
					'urutan'					=> $this->input->post('urutan'),
					'types'						=> $this->input->post('types'),
					'link'						=> $this->input->post('link'),
					'update_date'			=> date('Y-m-d H:i:s'),
					'update_by' 			=> $this->session->userdata('user_id')
				);
				$this->sinopsis->update(array('id' => $this->input->post('kode')), $data);
			}

			echo json_encode(array("status" => "ok"));
		} else {
			$id 				= $this->input->post('kode');
			$types 			= $this->input->post('types');
			$get_image 	= $this->sinopsis->get_by_id($id);
			if ($get_image->types == 'TEXT' && $get_image->product_images == '') {
			  //echo $message = "The file does not exists";
			  //exit;

			  $product_name 						= $this->input->post('product_name');
				$new_name                 = $product_name."_".$_FILES['file']['name'];
				$config['file_name']      = $new_name;
				$config['upload_path'] 		= './upload/sinopsis_images';
				$config['allowed_types'] 	= 'pdf|jpg|png';
				$config['max_size']  			= '8192';

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('file')) {
				  $status = "error";
				  $msg 		= $this->upload->display_errors();
				} else {

				  $dataupload = $this->upload->data();
				  $data = array(
						'product_name'		=> $this->input->post('product_name'),
						'product_desc'		=> $this->input->post('product_desc'),
						'product_images'	=> $dataupload['file_name'],
						'aktivasi'				=> $this->input->post('aktivasi'),
						'urutan'					=> $this->input->post('urutan'),
						'types'						=> $this->input->post('types'),
						'link'						=> $this->input->post('link'),
						'update_date'			=> date('Y-m-d H:i:s'),
						'update_by' 			=> $this->session->userdata('user_id')
					);
				   
				  $update = $this->sinopsis->update(array('id' => $this->input->post('kode')), $data);
				  if ($update) {
						echo json_encode(array("status" => "ok"));
				  } else {
				  	echo json_encode(array("status" => "failed"));
				  }
				}
			} else {
				//echo "anda disana";
			  //$message = "The file exist";
			  $files 			= "./upload/sinopsis_images/".$get_image->product_images;
				$hapus_file = unlink($files);
				if ($hapus_file) {
					$product_name 						= $this->input->post('product_name');
					$new_name                 = $product_name."_".$_FILES['file']['name'];
					$config['file_name']      = $new_name;
					$config['upload_path'] 		= './upload/sinopsis_images';
					$config['allowed_types'] 	= 'pdf|jpg|png';
					$config['max_size']  			= '8192';

					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('file')) {
					  $status = "error";
					  $msg 		= $this->upload->display_errors();
					} else {

					  $dataupload = $this->upload->data();
					  $data = array(
							'product_name'		=> $this->input->post('product_name'),
							'product_desc'		=> $this->input->post('product_desc'),
							'product_images'	=> $dataupload['file_name'],
							'aktivasi'				=> $this->input->post('aktivasi'),
							'urutan'					=> $this->input->post('urutan'),
							'types'						=> $this->input->post('types'),
							'link'						=> $this->input->post('link'),
							'update_date'			=> date('Y-m-d H:i:s'),
							'update_by' 			=> $this->session->userdata('user_id')
						);
					   
					  $update = $this->sinopsis->update(array('id' => $this->input->post('kode')), $data);
					  if ($update) {
							echo json_encode(array("status" => "ok"));
					  } else {
					  	echo json_encode(array("status" => "failed"));
					  }
					}
				}
			}
		}
	}

	public function sinopsis_deleted($id)
	{
		$cek_file 	= $this->sinopsis->get_by_id($id);
		
		if ($cek_file->types == 'TEXT') {
			$data 				= $this->sinopsis->delete_by_id($id);
			echo json_encode(array("status" => "ok"));
		} else {
			$files 			= "./upload/sinopsis_images/".$cek_file->product_images;
			$hapus_file = unlink($files);
			if ($hapus_file) {
				$data_delete 	= $this->sinopsis->get_by_id($id); //DATA DELETE
				$data 				= $this->sinopsis->delete_by_id($id);
				echo json_encode(array("status" => "ok"));
			}
		}
	}

	private function _validation_sinopsis(){
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if($this->input->post('product_name') == '')
		{
			$data['inputerror'][] = 'product_name';
			$data['error_string'][] = 'Product Name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('product_desc') == '')
		{
			$data['inputerror'][] = 'product_desc';
			$data['error_string'][] = 'Product Description is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('types') == '')
		{
			$data['inputerror'][] = 'types';
			$data['error_string'][] = 'Types is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('aktivasi') == '')
		{
			$data['inputerror'][] = 'aktivasi';
			$data['error_string'][] = 'Aktivasi is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('urutan') == '')
		{
			$data['inputerror'][] = 'urutan';
			$data['error_string'][] = 'Urutan is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('link') == '')
		{
			$data['inputerror'][] = 'link';
			$data['error_string'][] = 'Link is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}