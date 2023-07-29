<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pertanyaan extends CI_Controller {

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

    $this->load->model('pertanyaan_model', 'pertanyaan');
  }

  public function index()
	{
		$data['group_halaman'] 		= "Kontak Kami";
		$data['nama_halaman'] 		= "Daftar Pertanyaan";
		//$data['icon_halaman'] 		= "icon-layers";
		//$data['perusahaan'] 			= $this->perusahaan->get_details();

		$this->load->view('adminx/kontak_kami/pertanyaan', $data, FALSE);
	}

  public function pertanyaan_list()
  {
  	$list = $this->pertanyaan->get_datatables();
		$data = array();
		$no 	= $_POST['start'];
		$noUrut = 0;
		foreach ($list as $pertanyaan) {
			$no++;
			$noUrut++;
			$row   = array();
			$row[] = $no;
			//add html for action
			if ($pertanyaan->status_answer == 'ASK') {
				$row[] = '<select id="status_answer" name="status_answer" 
										class="form-select form-select-sm" onchange="update_answer(this, '.$pertanyaan->id.')">
	                  <option disabled="disabled">-- Pilih --</option>
	                  <option value="'.$pertanyaan->status_answer.'" selected="selected">'.$pertanyaan->status_answer.'</option>
	                  <option value="ANSWER">ANSWER</option>
	                  <option value="HOLD">HOLD</option>
	                </select>';
			} elseif ($pertanyaan->status_answer == 'ANSWER') {
				$row[] = '<select id="status_answer" name="status_answer" 
										class="form-select form-select-sm" onchange="update_answer(this, '.$pertanyaan->id.')">
	                  <option selected="selected" disabled="disabled">-- Pilih --</option>
	                  <option value="'.$pertanyaan->status_answer.'" selected="selected">'.$pertanyaan->status_answer.'</option>
	                  <option value="ASK">ASK</option>
	                  <option value="HOLD">HOLD</option>
	                </select>';
			} else{
				$row[] = '<select id="status_answer" name="status_answer" 
										class="form-select form-select-sm" onchange="update_answer(this, '.$pertanyaan->id.')">
	                  <option selected="selected" disabled="disabled">-- Pilih --</option>
	                  <option value="'.$pertanyaan->status_answer.'" selected="selected">'.$pertanyaan->status_answer.'</option>
	                  <option value="ASK">ASK</option>
	                  <option value="ANSWER">ANSWER</option>
	                </select>';
			}
			
			if ($pertanyaan->status_answer == 'ASK') {
				$row[] = '<div class="d-grid"><button class="btn btn-warning btn-sm ">'.$pertanyaan->status_answer.'</button></div>';
			} elseif ($pertanyaan->status_answer == 'ANSWER') {
				$row[] = '<div class="d-grid"><button class="btn btn-success btn-sm ">'.$pertanyaan->status_answer.'</button></div>';
			} else {
				$row[] = '<div class="d-grid"><button class="btn btn-danger btn-sm ">'.$pertanyaan->status_answer.'</button></div>';
			}
			
			$row[] = $pertanyaan->pengirim;
			$row[] = $pertanyaan->email;
			$row[] = $pertanyaan->phone;
			//$row[] = $pertanyaan->type;
			$row[] = $pertanyaan->judul;
			$row[] = $pertanyaan->isi;
			$row[] = $pertanyaan->create_date;
		
			$data[] = $row;
		}

		$output = array(
			"draw" 						=> $_POST['draw'],
			"recordsTotal" 		=> $this->pertanyaan->count_all(),
			"recordsFiltered" => $this->pertanyaan->count_filtered(),
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

		$this->pertanyaan->update(array('id' => $id), $data);

		echo json_encode(array("status" => "ok"));
  }
}