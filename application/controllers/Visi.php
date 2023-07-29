<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visi extends CI_Controller {

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

    $this->load->model('visi_model', 'visi');
  }

  public function index()
	{
		$data['group_halaman'] 		= "Beranda";
		$data['nama_halaman'] 		= "Daftar Visi";
		//$data['icon_halaman'] 		= "icon-layers";
		//$data['perusahaan'] 			= $this->perusahaan->get_details();

		$this->load->view('adminx/tentang_kami/visi', $data, FALSE);
	}

  public function visi_list()
  {
  	$list = $this->visi->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $visi) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
      $row[] = '<a href="javascript:void(0)" onclick="edit('."'".$visi->id."'".')"
									class="btn btn-info btn-sm">
									<i class="mdi mdi-pencil"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$visi->id."'".')"
                	class="btn btn-danger btn-sm">
                	<i class="mdi mdi-window-close"></i>
                </a>';
			$row[] = $visi->aktivasi == 'AKTIF' ? '<h5><span class="badge bg-success">'.strtoupper($visi->aktivasi).'</span></h5>' : '<h5><span class="badge bg-danger">'.strtoupper($visi->aktivasi).'</span></h5>';
			$row[] = $visi->text;
			$row[] = $visi->insert_date;
			$row[] = $visi->insert_by;
		
			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->visi->count_all(),
			"recordsFiltered" => $this->visi->count_filtered(),
			"data" 						=> $data,
		);
		//output to json format
		echo json_encode($output);
  }

  public function visi_add() 
  {
  	$this->_validation_visi();

    $data = array(
			'text'					=> $this->input->post('text'),
			'aktivasi'			=> $this->input->post('aktivasi'),
			'insert_date'		=> date('Y-m-d H:i:s'),
			'insert_by' 		=> $this->session->userdata('user_id')
		);
    $insert = $this->visi->save($data);

		echo json_encode(array("status" => "ok"));
  }

	public function visi_edit($id)
	{
		$data = $this->visi->get_by_id($id);
		echo json_encode($data);
	}

	public function visi_update()
	{
		$this->_validation_visi();

		$data = array(
			'text'					=> $this->input->post('text'),
			'aktivasi'			=> $this->input->post('aktivasi'),
			'update_date'		=> date('Y-m-d H:i:s'),
			'update_by' 		=> $this->session->userdata('user_id')
		);
		$this->visi->update(array('id' => $this->input->post('kode')), $data);

		echo json_encode(array("status" => "ok"));
	}

	public function visi_deleted($id)
	{
		$data = $this->visi->delete_by_id($id);

		echo json_encode(array("status" => "ok"));
	}

	private function _validation_visi(){
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