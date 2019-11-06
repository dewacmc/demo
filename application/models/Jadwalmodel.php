<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JadwalModel extends CI_Model
{
  public $jadwal = 'cmc_jadwal';
  public $cabang = 'cmc_cabang';

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function getRooms(){
    $this->db->select('A.name, A.color, B.nama');
    $this->db->from("{$this->jadwal} A");
    $this->db->join("{$this->cabang} B", 'A.idcab = B.id');
    $query = $this->db->get();
    return $query->result();
  }

}