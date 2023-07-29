<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  /***** GENERAL SETTING *****/
  //1.1. PROFILE HEADER
  public function get_profile_headers($nama_halaman)
  {
    $this->db->select('*');
    $this->db->from('table_profile_header');
    $this->db->where('aktivasi', 'AKTIF');
    $this->db->like('url', $nama_halaman);
    $this->db->limit(1);

    $query  = $this->db->get();
    $cek    = $query->num_rows();

    if ($cek > 0) {
      return $query->row();
    } else {
      return (object) ['message' => 'details tidak ditemukan'];
    }
  }

  //1.2. COMPANY
  public function get_company_details()
  {
    $this->db->select('*');
    $this->db->from('table_perusahaan');
    $this->db->where('aktivasi', 'AKTIF');
    $this->db->limit(1);

    $query = $this->db->get();

    return $query->row();
  }

  /***** BERANDA *****/
  //1.1. SLIDER
  public function get_all_sliders()
  {
    $this->db->select('*');
    $this->db->from('table_main_slider');
    $this->db->where('aktivasi', 'AKTIF');
    $this->db->order_by('urutan', 'ASC');

    $query = $this->db->get();

    return $query->result();
  }

  //1.2. SINOPSIS PRODUK
  public function get_all_sinopsis()
  {
    $this->db->select('*');
    $this->db->from('table_sinopsis_produk');
    $this->db->where('aktivasi', 'AKTIF');
    $this->db->order_by('urutan', 'ASC');
    $this->db->limit(3);

    $query = $this->db->get();

    return $query->result();
  }

  //1.3. SERTIFIKASI
  public function get_all_sertified()
  {
    $this->db->select('*');
    $this->db->from('table_sertified_by');
    $this->db->where('aktivasi', 'AKTIF');
    $this->db->order_by('urutan', 'ASC');

    $query = $this->db->get();

    return $query->result();
  }

  //1.4. TAG
  public function get_all_tags()
  {
    $this->db->select('*');
    $this->db->from('table_produk_tags');
    $this->db->where('aktivasi', 'AKTIF');
    $this->db->order_by('urutan', 'ASC');

    $query = $this->db->get();

    return $query->result();
  }

  //1.5. KEPERCAYAAN 
  public function get_all_trusted()
  {
    $this->db->select('*');
    $this->db->from('table_produk_trust');
    $this->db->where('aktivasi', 'AKTIF');
    $this->db->limit(1);

    $query = $this->db->get();

    return $query->row();
  }

  /***** TENTANG KAMI *****/
  //1.1. PROFILE PERUSAHAAN
  public function get_company_profile()
  {
    $this->db->select('*');
    $this->db->from('table_profile');
    $this->db->where('aktivasi', 'AKTIF');
    $this->db->order_by('insert_date', 'DESC');
    $this->db->limit(1);

    $query = $this->db->get();

    return $query->row();
  }

  //1.2. VISI 
  public function get_all_visi()
  {
    $this->db->select('*');
    $this->db->from('table_visi');
    $this->db->where('aktivasi', 'AKTIF');
    $this->db->limit(1);

    $query = $this->db->get();

    return $query->row();
  }

  //1.3. MISI
  public function get_all_misi()
  {
    $this->db->select('*');
    $this->db->from('table_misi');
    $this->db->where('aktivasi', 'AKTIF');

    $query = $this->db->get();

    return $query->result();
  }

  //1.4. METODE 
  public function get_all_metode()
  {
    $this->db->select('*');
    $this->db->from('table_metode_pdca');
    $this->db->where('aktivasi', 'AKTIF');

    $query = $this->db->get();

    return $query->result();
  }

  //1.5. PELANGGAN KAMI 
  public function get_all_customers()
  {
    $this->db->select('*');
    $this->db->from('table_logo_pelanggan');
    $this->db->where('aktivasi', 'AKTIF');
    $this->db->order_by('nama', 'asc');


    $query = $this->db->get();

    return $query->result();
  }

  //1.6. FASILITAS UJI 
  public function get_all_test_kit()
  {
    $this->db->select('*');
    $this->db->from('table_fasilitas_uji');
    $this->db->where('aktivasi', 'AKTIF');

    $query = $this->db->get();

    return $query->result();
  }

  /***** PRODUK *****/
  //1.1. PRODUK
  public function get_all_products($jenis)
  {
    $this->db->select('a.id, a.slug, a.insert_date, nama_produk, images, nominal_voltage, 
                       available_types, a.aktivasi, b.jenis_produk, c.product_images as jp_images');
    $this->db->from('table_produk a');
    $this->db->join('table_jenis_produk b', 'b.id = a.id_jenis', 'left');
    $this->db->join('table_sinopsis_produk c', 'c.link = b.jenis_produk', 'left');
    $this->db->where('a.aktivasi', 'AKTIF');
    $this->db->like('b.jenis_produk', $jenis);
    $this->db->order_by('a.insert_date', 'DESC');

    $query = $this->db->get();

    return $query->result();
  }

  public function get_all_products_new()
  {
    $this->db->select('a.id, a.slug, a.insert_date, nama_produk, images, nominal_voltage, 
                       available_types, a.aktivasi, b.jenis_produk, c.product_images as jp_images');
    $this->db->from('table_produk a');
    $this->db->join('table_jenis_produk b', 'b.id = a.id_jenis', 'left');
    $this->db->join('table_sinopsis_produk c', 'c.link = b.jenis_produk', 'left');
    $this->db->where('a.aktivasi', 'AKTIF');
    $this->db->order_by('a.insert_date', 'DESC');

    $query = $this->db->get();

    return $query->result();
  }

  //1.2. PRODUK MIX
  public function get_all_products_mix()
  {
    $this->db->select('a.id, a.slug, a.insert_date, nama_produk, images, nominal_voltage, 
                       available_types, a.aktivasi, b.jenis_produk');
    $this->db->from('table_produk a');
    $this->db->join('table_jenis_produk b', 'b.id = a.id_jenis', 'left');
    $this->db->where('a.aktivasi', 'AKTIF');
    $this->db->order_by('a.insert_date', 'DESC');

    $query = $this->db->get();

    return $query->result();
  }

  //1.3. PRODUK MIX TOPTEN
  public function get_mix_top_ten_products()
  {
    $this->db->select('a.id, a.slug, a.insert_date, nama_produk, images, nominal_voltage, 
                       available_types, a.aktivasi, b.jenis_produk');
    $this->db->from('table_produk a');
    $this->db->join('table_jenis_produk b', 'b.id = a.id_jenis', 'left');
    $this->db->where('a.aktivasi', 'AKTIF');
    $this->db->order_by('a.insert_date', 'DESC');
    $this->db->limit(10);

    $query = $this->db->get();

    return $query->result();
  }

  //1.4. PRODUK DETAIL
  public function get_product_details($slug)
  {
    $this->db->select('*');
    $this->db->from('table_produk a');
    $this->db->join('table_jenis_produk b', 'b.id = a.id_jenis', 'left');
    $this->db->where('a.aktivasi', 'AKTIF');
    $this->db->where('slug', $slug);

    $query  = $this->db->get();
    $cek    = $query->num_rows();

    if ($cek > 0) {
      return $query->row();
    } else {
      return (object) ['message' => 'produk tidak ditemukan'];
    }
  }

  //1.5. JENIS PRODUK
  public function get_all_product_types()
  {
    $this->db->select('*');
    $this->db->from('table_jenis_produk');
    $this->db->where('aktivasi', 'AKTIF');

    $query = $this->db->get();

    return $query->result();
  }

  public function get_count_product_types($id)
  {
    $this->db->select('COUNT(id) AS jumlah_produk');
    $this->db->from('table_produk');
    $this->db->where('aktivasi', 'AKTIF');
    $this->db->where('id_jenis', $id);

    $query = $this->db->get();

    return $query->row();
  }
}
