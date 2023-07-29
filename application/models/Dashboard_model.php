<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function jumlah_user()
  {
    $result = $this->db->count_all_results('table_user');

    return $result;
  }

  public function jumlah_produk()
  {
    $result = $this->db->count_all_results('table_produk');

    return $result;
  }

  public function jumlah_pertanyaan_proses()
  {
    $this->db->where('status_answer', 'ASK');
    $this->db->where('type', 'NORMAL');
    $result = $this->db->count_all_results('table_pertanyaan');

    return $result;
  }

  public function jumlah_pertanyaan_lengkap()
  {
    $this->db->where('status_answer', 'ANSWER');
    $this->db->where('type', 'NORMAL');
    $result = $this->db->count_all_results('table_pertanyaan');

    return $result;
  }

  public function jumlah_pertanyaan_all()
  {
    $this->db->where('type', 'NORMAL');
    $result = $this->db->count_all_results('table_pertanyaan');

    return $result;
  }

  public function jumlah_pertanyaan_data()
  {
    $this->db->where('type', 'NORMAL');
    $this->db->order_by('create_date', 'DESC');
    $this->db->limit(10);
    $result = $this->db->get('table_pertanyaan');

    return $result->result();
  }

  public function jumlah_call_back_all()
  {
    //$this->db->where('status_answer', 'ASK');
    $this->db->where('type', 'CALL BACK');
    $result = $this->db->count_all_results('table_pertanyaan');

    return $result;
  }

  public function jumlah_call_back_proses()
  {
    $this->db->where('status_answer', 'ASK');
    $this->db->where('type', 'CALL BACK');
    $result = $this->db->count_all_results('table_pertanyaan');

    return $result;
  }

  public function jumlah_call_back_lengkap()
  {
    $this->db->where('status_answer', 'ANSWER');
    $this->db->where('type', 'CALL BACK');
    $result = $this->db->count_all_results('table_pertanyaan');

    return $result;
  }

  public function jumlah_call_back_data()
  {
    $this->db->where('type', 'CALL BACK');
    $this->db->order_by('create_date', 'DESC');
    $this->db->limit(10);
    $result = $this->db->get('table_pertanyaan');

    return $result->result();
  }

  public function recent_activities()
  {
    $this->db->from('table_user');
    $this->db->order_by('last_login', 'DESC');
    $this->db->limit(10);
    $query = $this->db->get();

    return $query->result();
  }
}