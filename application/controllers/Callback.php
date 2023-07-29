<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Callback extends CI_Controller {

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

    $this->load->model('callback_model', 'callback');
  }

  public function index()
	{
		$data['group_halaman'] 		= "Kontak Kami";
		$data['nama_halaman'] 		= "Daftar Callback";
		//$data['icon_halaman'] 		= "icon-layers";
		//$data['perusahaan'] 			= $this->perusahaan->get_details();

		$this->load->view('adminx/kontak_kami/callback', $data, FALSE);
	}

  public function callback_list()
  {
  	$list = $this->callback->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $callback) {
			$no++;
			$noUrut++;
			$row   = array();
			$row[] = $no;
			//add html for action
			if ($callback->status_answer == 'ASK') {
				$row[] = '<select id="status_answer" name="status_answer" 
										class="form-select form-select-sm" onchange="update_answer(this, '.$callback->id.')">
	                  <option disabled="disabled">-- Pilih --</option>
	                  <option value="'.$callback->status_answer.'" selected="selected">'.$callback->status_answer.'</option>
	                  <option value="ANSWER">ANSWER</option>
	                  <option value="HOLD">HOLD</option>
	                </select>';
			} elseif ($callback->status_answer == 'ANSWER') {
				$row[] = '<select id="status_answer" name="status_answer" 
										class="form-select form-select-sm" onchange="update_answer(this, '.$callback->id.')">
	                  <option selected="selected" disabled="disabled">-- Pilih --</option>
	                  <option value="'.$callback->status_answer.'" selected="selected">'.$callback->status_answer.'</option>
	                  <option value="ASK">ASK</option>
	                  <option value="HOLD">HOLD</option>
	                </select>';
			} else{
				$row[] = '<select id="status_answer" name="status_answer" 
										class="form-select form-select-sm" onchange="update_answer(this, '.$callback->id.')">
	                  <option selected="selected" disabled="disabled">-- Pilih --</option>
	                  <option value="'.$callback->status_answer.'" selected="selected">'.$callback->status_answer.'</option>
	                  <option value="ASK">ASK</option>
	                  <option value="ANSWER">ANSWER</option>
	                </select>';
			}
			
			if ($callback->status_answer == 'ASK') {
				$row[] = '<div class="d-grid"><button class="btn btn-warning btn-sm ">'.$callback->status_answer.'</button></div>';
			} elseif ($callback->status_answer == 'ANSWER') {
				$row[] = '<div class="d-grid"><button class="btn btn-success btn-sm ">'.$callback->status_answer.'</button></div>';
			} else {
				$row[] = '<div class="d-grid"><button class="btn btn-danger btn-sm ">'.$callback->status_answer.'</button></div>';
			}
			
			$row[] = $callback->pengirim;
			$row[] = $callback->phone;
			$row[] = $callback->judul;
			$row[] = $callback->create_date;
		
			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->callback->count_all(),
			"recordsFiltered" => $this->callback->count_filtered(),
			"data" 						=> $data,
		);
		//output to json format
		echo json_encode($output);
  }

  public function update_answer()
  {
  	$id 		= $this->input->post('id');
  	$answer = $this->input->post('answer');

  	$data = array(
			'status_answer'		=> $answer,
			'update_date'			=> date('Y-m-d H:i:s'),
			'update_by' 			=> $this->session->userdata('user_id')
		);

		$this->callback->update(array('id' => $id), $data);

		echo json_encode(array("status" => "ok"));
  }
}