<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

	var $_table = 'table_user';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function islogin($data){  
    $query = $this->db->get_where('table_user', array('username' => $data['username']));
    $success      = $query->num_rows();
    $successData  = $query->row();

    //JIKA EMAIL DITEMUKAN
    if ($success > 0) {
      $isPasswordTrue = password_verify($data['password'], $successData->password);
      //echo "a".$isPasswordTrue;
      if ($isPasswordTrue) {
        if ($successData->aktivasi == 'Aktif'){

          $dataLogin =  array(
                        'user_id'         => $successData->id,
                        'user_name'       => $successData->username,
                        'user_nip'        => $successData->nip,
                        'user_level_name' => $successData->level,
                        'user_email'      => $successData->email_pegawai,
                        'user_valid'      => true
                      );
          $this->session->set_userdata($dataLogin);

          //GET TANGGAL SEKARANG
          $now = date('Y-m-d H:i:s');

          //UPDATE TABLE USER AND SET LAST LOGIN
          $update = $this->db->query("UPDATE table_user SET last_login = '$now' 
                                      WHERE id = '".$successData->id."'");

          return 30; //$query->num_rows();
        }else{
          return 20; //USERNAME DI BLOCK
        }
      }else{
        return 10; //JIKA PASSWORD SALAH
      }
    }else{
      return 0; //DATA TIDAK DITEMUKAN
    }
	}

  public function isNotLogin(){
    if ($this->session->userdata('user_valid') == false && $this->session->userdata('user_id') == "") {
      redirect(base_url());
      //redirect('welcome');
    }
  }

}