<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JadwalModel extends CI_Model
{
  public $room = 'cmc_room';
  public $cabang = 'cmc_cabang';
  public $terapis='cmc_terapis';
  public $client= 'cmc_client';
  public $jadwal_h= 'cmc_jadwal_h';
  public $jadwal_d= 'cmc_jadwal_d';
  public $jadwal_d1= 'cmc_jadwal_d1';

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function getLogin($loginid,$loginpasw){
    $this->db->select('A.id,A.nama,A.notel,A.email,A.dep,A.pasw');
    $this->db->from("{$this->terapis} A");
    $this->db->where('A.email', $loginid );
    $this->db->where('A.pasw', $loginpasw );
    $query = $this->db->get();
    return $query->result();
  }
}