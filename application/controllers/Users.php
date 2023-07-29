<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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

    $this->load->model('users_model', 'users');
  }

  public function index()
	{
		$data['group_halaman'] 		= "Users";
		$data['nama_halaman'] 		= "Daftar Users";
		//$data['icon_halaman'] 		= "icon-layers";
		//$data['perusahaan'] 			= $this->perusahaan->get_details();

		$this->load->view('adminx/users/index', $data, FALSE);
	}

	public function user_profile()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if($check_permission->num_rows() == 1){
			$data['group_halaman'] 		= "Users";
			$data['nama_halaman'] 		= "Profile User";
			$data['icon_halaman'] 		= "icon-user";
			
			$id 											= $this->session->userdata('user_nip');
			$data['karyawan_detail'] 	= get_karyawan_details($id);
			$data['perusahaan'] 			= $this->perusahaan->get_details();

			//ADDING TO LOG
			$log_url 		= base_url().$this->contoller_name."/".$this->function_name;
			$log_type 	= "VIEW";
			$log_data 	= "";
			
			log_helper($log_url, $log_type, $log_data);
			//END LOG

			$this->load->view('adminx/users/profile', $data, FALSE);
		} else {
			redirect('errorpage/error403');
		}
	}

  public function users_add()
  {
  	$this->_validation_user();

  	$data = array(
			'nip' 							=> $this->input->post('nip'),
			'email_pegawai' 		=> $this->input->post('email'),
			'username' 					=> $this->input->post('username'),
			'password' 					=> $this->hash_password($this->input->post('password')),
			'level' 						=> $this->input->post('level'),
			'aktivasi' 					=> $this->input->post('aktivasi'),
			'insert_date'				=> date('Y-m-d H:i:s'),
			'insert_by' 				=> $this->session->userdata('user_id')
		);
		$insert = $this->users->save($data);
		echo json_encode(array("status" => "ok"));
  }

  public function users_list()
  {
  	$list = $this->users->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $users) {
			$no++;
			$noUrut++;
			$row = array();
			$row[] = $no;
			//add html for action
			$row[] = '<a href="javascript:void(0)" onclick="edit('."'".$users->id."'".')"
									class="btn btn-info btn-sm">
									<i class="mdi mdi-pencil"></i>
								</a>
                <a href="javascript:void(0)" onclick="openModalDelete('."'".$users->id."'".')"
                	class="btn btn-danger btn-sm">
                	<i class="mdi mdi-window-close"></i>
                </a>';
      $row[] = $users->username;
      $row[] = $users->email_pegawai;;
      $row[] = $users->level;
      //$row[] = '';
      $row[] = $users->aktivasi == 'Aktif' ? '<h5><span class="badge bg-success">'.strtoupper($users->aktivasi).'</span></h5>' : '<h5><span class="badge bg-danger">'.strtoupper($users->aktivasi).'</span></h5>';
      $row[] = $users->last_login;
		
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->users->count_all(),
			"recordsFiltered" => $this->users->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
  }

  public function users_edit($id)
	{
		$data = $this->users->get_by_id($id);
		echo json_encode($data);
	}

	public function users_update()
	{
		$this->_validation_user_wp();
		
		$data = array(
			'nip' 							=> $this->input->post('nip'),
			'email_pegawai' 		=> $this->input->post('email'),
			'username' 					=> $this->input->post('username'),
			'level' 						=> $this->input->post('level'),
			'aktivasi' 					=> $this->input->post('aktivasi'),
			'insert_date'				=> date('Y-m-d H:i:s'),
			'insert_by' 				=> $this->session->userdata('user_id')
		);
		$this->users->update(array('id' => $this->input->post('kode')), $data);
		echo json_encode(array("status" => "ok"));
	}	

  public function users_deleted($id)
	{
		$data = $this->users->delete_by_id($id);
		echo json_encode(array("status" => "ok"));
	}

	public function update_password()
	{
		//CHECK FOR ACCESS FOR EACH FUNCTION
		$user_level 			= $this->session->userdata('user_level');
		$check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);
		if($check_permission->num_rows() == 1){
			$data['group_halaman'] 		= "Users";
			$data['nama_halaman'] 		= "Update Password";
			$data['icon_halaman'] 		= "icon-layers";
			$data['perusahaan'] 			= $this->perusahaan->get_details();

			//ADDING TO LOG
			$log_url 		= base_url().$this->contoller_name."/".$this->function_name;
			$log_type 	= "VIEW";
			$log_data 	= "";
			
			log_helper($log_url, $log_type, $log_data);
			//END LOG

			$this->load->view('adminx/users/update_password', $data, FALSE);
		} else {
			redirect('errorpage/error403');
		}
	}

	public function update_password_action()
	{
		$data = array(
			'password' 					=> $this->hash_password($this->input->post('confirm_new_password')),
			'update_date'				=> date('Y-m-d H:i:s'),
			'update_by' 				=> $this->session->userdata('user_id')
		);
		$this->users->update(array('id' => $this->session->userdata('user_id')), $data);
		echo json_encode(array("status" => TRUE));

		//ADDING TO LOG
		$log_url 		= base_url().$this->contoller_name."/".$this->function_name;
		$log_type 	= "UPDATE";
		$log_data 	= json_encode($data);
		
		log_helper($log_url, $log_type, $log_data);
		//END LOG
	}

	private function _validation_user(){
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if($this->input->post('nip') == '')
		{
			$data['inputerror'][] = 'nip';
			$data['error_string'][] = 'NIP is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('email') == '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('username') == '')
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('password') == '')
		{
			$data['inputerror'][] = 'password';
			$data['error_string'][] = 'Password is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('aktivasi') == '')
		{
			$data['inputerror'][] = 'aktivasi';
			$data['error_string'][] = 'Aktivasi is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('level') == '')
		{
			$data['inputerror'][] = 'level';
			$data['error_string'][] = 'Level is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	private function _validation_user_wp(){
		$data 								= array();
		$data['error_string'] = array();
		$data['inputerror'] 	= array();
		$data['status'] 			= TRUE;

		if($this->input->post('nip') == '')
		{
			$data['inputerror'][] = 'nip';
			$data['error_string'][] = 'NIP is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('email') == '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('username') == '')
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('aktivasi') == '')
		{
			$data['inputerror'][] = 'aktivasi';
			$data['error_string'][] = 'Aktivasi is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('level') == '')
		{
			$data['inputerror'][] = 'level';
			$data['error_string'][] = 'Level is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	private function hash_password($password){
  	return password_hash($password, PASSWORD_DEFAULT);
	}
}
