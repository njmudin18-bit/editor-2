<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Misi extends CI_Controller {

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

    $this->load->model('misi_model', 'misi');
  }

  public function index()
	{
		$data['group_halaman'] 		= "Beranda";
		$data['nama_halaman'] 		= "Daftar Misi";
		//$data['icon_halaman'] 		= "icon-layers";
		//$data['perusahaan'] 			= $this->perusahaan->get_details();

		$this->load->view('adminx/tentang_kami/misi', $data, FALSE);
	}

  public function misi_list()
  {
  	$list = $this->misi->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $misi) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
      $row[] = '<a href="javascript:void(0)" onclick="edit('."'".$misi->id."'".')"
									class="btn btn-info btn-sm">
									<i class="mdi mdi-pencil"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$misi->id."'".')"
                	class="btn btn-danger btn-sm">
                	<i class="mdi mdi-window-close"></i>
                </a>';
			$row[] = $misi->aktivasi == 'AKTIF' ? '<h5><span class="badge bg-success">'.strtoupper($misi->aktivasi).'</span></h5>' : '<h5><span class="badge bg-danger">'.strtoupper($misi->aktivasi).'</span></h5>';
			$row[] = $misi->text;
			$row[] = $misi->insert_date;
			$row[] = $misi->insert_by;
		
			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->misi->count_all(),
			"recordsFiltered" => $this->misi->count_filtered(),
			"data" 						=> $data,
		);
		//output to json format
		echo json_encode($output);
  }

  public function misi_add() 
  {
  	$this->_validation_misi();

    $data = array(
			'text'					=> $this->input->post('text'),
			'aktivasi'			=> $this->input->post('aktivasi'),
			'insert_date'		=> date('Y-m-d H:i:s'),
			'insert_by' 		=> $this->session->userdata('user_id')
		);
    $insert = $this->misi->save($data);

		echo json_encode(array("status" => "ok"));
  }

	public function misi_edit($id)
	{
		$data = $this->misi->get_by_id($id);
		echo json_encode($data);
	}

	public function misi_update()
	{
		$this->_validation_misi();

		$data = array(
			'text'					=> $this->input->post('text'),
			'aktivasi'			=> $this->input->post('aktivasi'),
			'update_date'		=> date('Y-m-d H:i:s'),
			'update_by' 		=> $this->session->userdata('user_id')
		);
		$this->misi->update(array('id' => $this->input->post('kode')), $data);

		echo json_encode(array("status" => "ok"));
	}

	public function misi_deleted($id)
	{
		$data = $this->misi->delete_by_id($id);

		echo json_encode(array("status" => "ok"));
	}

	private function _validation_misi(){
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if($this->input->post('text') == '')
		{
			$data['inputerror'][] = 'text';
			$data['error_string'][] = 'Text is required';
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