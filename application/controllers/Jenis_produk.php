<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_produk extends CI_Controller {

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

    $this->load->model('jenis_produk_model', 'jenis_produk');
  }

  public function index()
	{
		$data['group_halaman'] 		= "Produk";
		$data['nama_halaman'] 		= "Jenis Produk";
		//$data['icon_halaman'] 		= "icon-layers";
		//$data['perusahaan'] 			= $this->perusahaan->get_details();

		$this->load->view('adminx/produk/jenis_produk', $data, FALSE);
	}

  public function jenis_produk_list()
  {
  	$list = $this->jenis_produk->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $jenis_produk) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
      $row[] = '<a href="javascript:void(0)" onclick="edit('."'".$jenis_produk->id."'".')"
									class="btn btn-info btn-sm">
									<i class="mdi mdi-pencil"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$jenis_produk->id."'".')"
                	class="btn btn-danger btn-sm">
                	<i class="mdi mdi-window-close"></i>
                </a>';
			$row[] = $jenis_produk->aktivasi == 'AKTIF' ? '<h5><span class="badge bg-success">'.strtoupper($jenis_produk->aktivasi).'</span></h5>' : '<h5><span class="badge bg-danger">'.strtoupper($jenis_produk->aktivasi).'</span></h5>';
			$row[] = $jenis_produk->jenis_produk;
			$row[] = $jenis_produk->insert_date;
			$row[] = $jenis_produk->insert_by;
		
			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->jenis_produk->count_all(),
			"recordsFiltered" => $this->jenis_produk->count_filtered(),
			"data" 						=> $data,
		);
		//output to json format
		echo json_encode($output);
  }

  public function jenis_produk_add() 
  {
  	$this->_validation_jenis_produk();

    $data = array(
			'jenis_produk'	=> $this->input->post('nama'),
			'aktivasi'			=> $this->input->post('aktivasi'),
			'insert_date'		=> date('Y-m-d H:i:s'),
			'insert_by' 		=> $this->session->userdata('user_id')
		);
     
    $insert = $this->jenis_produk->save($data);

		echo json_encode(array("status" => "ok"));
  }

	public function jenis_produk_edit($id)
	{
		$data = $this->jenis_produk->get_by_id($id);
		echo json_encode($data);
	}

	public function jenis_produk_update()
	{
		$this->_validation_jenis_produk();

		$data = array(
			'jenis_produk'	=> $this->input->post('nama'),
			'aktivasi'			=> $this->input->post('aktivasi'),
			'update_date'		=> date('Y-m-d H:i:s'),
			'update_by' 		=> $this->session->userdata('user_id')
		);
		$this->jenis_produk->update(array('id' => $this->input->post('kode')), $data);

		echo json_encode(array("status" => "ok"));	
	}

	public function jenis_produk_deleted($id)
	{
		$data = $this->jenis_produk->delete_by_id($id);

		echo json_encode(array("status" => "ok"));
	}

	private function _validation_jenis_produk(){
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] 	= 'nama';
			$data['error_string'][] = 'Nama Jenis Produk is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('aktivasi') == '')
		{
			$data['inputerror'][] 	= 'aktivasi';
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