<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sertifikasi extends CI_Controller {

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

    $this->load->model('sertifikasi_model', 'sertifikasi');
  }

  public function index()
	{
		$data['group_halaman'] 		= "Beranda";
		$data['nama_halaman'] 		= "Daftar Sertifikasi";
		//$data['icon_halaman'] 		= "icon-layers";
		//$data['perusahaan'] 			= $this->perusahaan->get_details();

		$this->load->view('adminx/beranda/sertifikasi', $data, FALSE);
	}

  public function sertifikasi_list()
  {
  	$list = $this->sertifikasi->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $sertifikasi) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
      $row[] = '<a href="javascript:void(0)" onclick="edit('."'".$sertifikasi->id."'".')"
									class="btn btn-info btn-sm">
									<i class="mdi mdi-pencil"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$sertifikasi->id."'".')"
                	class="btn btn-danger btn-sm">
                	<i class="mdi mdi-window-close"></i>
                </a>';
			$row[] = $sertifikasi->aktivasi == 'AKTIF' ? '<h5><span class="badge bg-success">'.strtoupper($sertifikasi->aktivasi).'</span></h5>' : '<h5><span class="badge bg-danger">'.strtoupper($sertifikasi->aktivasi).'</span></h5>';
			$row[] = $sertifikasi->urutan;
			$row[] = $sertifikasi->nama;
			$row[] = $sertifikasi->nomor_lisensi;
			$row[] = $sertifikasi->images;
		
			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->sertifikasi->count_all(),
			"recordsFiltered" => $this->sertifikasi->count_filtered(),
			"data" 						=> $data,
		);
		//output to json format
		echo json_encode($output);
  }

  public function sertifikasi_add() 
  {
  	$this->_validation_sertifikasi();

		//PREPARING CONFIG FILE UPLOAD
  	$new_name                 = $_FILES['file']['name'];
    $config['file_name']      = $new_name;
    $config['upload_path'] 		= './upload/sertified_images';
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
				'nama'					=> $this->input->post('nama'),
				'nomor_lisensi'	=> $this->input->post('nomor_lisensi'),
				'images'				=> $dataupload['file_name'],
				'aktivasi'			=> $this->input->post('aktivasi'),
				'insert_date'		=> date('Y-m-d H:i:s'),
				'insert_by' 		=> $this->session->userdata('user_id')
			);
       
      $insert = $this->sertifikasi->save($data);
			echo json_encode(array("status" => "ok"));
    }
  }

	public function sertifikasi_edit($id)
	{
		$data = $this->sertifikasi->get_by_id($id);
		echo json_encode($data);
	}

	public function sertifikasi_update()
	{
		$this->_validation_sertifikasi();

		if ($_FILES['file']['name'] == '') {

			$data = array(
				'urutan'				=> $this->input->post('urutan'),
				'nama'					=> $this->input->post('nama'),
				'nomor_lisensi'	=> $this->input->post('nomor_lisensi'),
				'aktivasi'			=> $this->input->post('aktivasi'),
				'update_date'		=> date('Y-m-d H:i:s'),
				'update_by' 		=> $this->session->userdata('user_id')
			);
			$this->sertifikasi->update(array('id' => $this->input->post('kode')), $data);

			echo json_encode(array("status" => "ok"));
		} else {
			$id 				= $this->input->post('kode');
			$get_image 	= $this->sertifikasi->get_by_id($id);

			//PREPARING CONFIG FILE UPLOAD
	  	$new_name                 = $_FILES['file']['name'];
	    $config['file_name']      = $new_name;
	    $config['upload_path'] 		= './upload/sertified_images';
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
					'nama'					=> $this->input->post('nama'),
					'nomor_lisensi'	=> $this->input->post('nomor_lisensi'),
					'images'				=> $dataupload['file_name'],
					'aktivasi'			=> $this->input->post('aktivasi'),
					'update_date'		=> date('Y-m-d H:i:s'),
					'update_by' 		=> $this->session->userdata('user_id')
				);
	       
	      $update = $this->sertifikasi->update(array('id' => $this->input->post('kode')), $data);
	      if ($update) {
	      	$files 			= "./upload/sertified_images/".$get_image->images;
					$hapus_file = unlink($files);

					echo json_encode(array("status" => "ok"));
	      } else {
	      	echo json_encode(array("status" => "failed"));
	      }
	    }
		}
	}

	public function sertifikasi_deleted($id)
	{
		$cek_file 	= $this->sertifikasi->get_by_id($id);
		$files 			= "./upload/sertified_images/".$cek_file->images;
		$hapus_file = unlink($files);
		if ($hapus_file) {
			$data_delete 	= $this->sertifikasi->get_by_id($id); //DATA DELETE
			$data 				= $this->sertifikasi->delete_by_id($id);
			echo json_encode(array("status" => "ok"));
		}
	}

	private function _validation_sertifikasi(){
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

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama Lembaga is required';
			$data['status'] = FALSE;
		}

		/*if($this->input->post('nomor_lisensi') == '')
		{
			$data['inputerror'][] = 'nomor_lisensi';
			$data['error_string'][] = 'License Number is required';
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