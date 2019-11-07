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

  public function getRooms(){
    $this->db->select('A.name,A.color,B.nama');
    $this->db->from("{$this->room} A");
    $this->db->join("{$this->cabang} B", 'A.idcab = B.id');
    $query = $this->db->get();
    return $query->result();
  }

  public function getAll(){
    $this->db->select('A.id, A.start, A.end, A.jenis, E.nama, G.nama, D.nama, D.color, F.tgldaftar, F.nama');
    $this->db->from("{$this->jadwal_h} A");
    $this->db->join("{$this->jadwal_d} B", 'A.id = B.id');
    $this->db->join("{$this->jadwal_d1} C", 'A.id = C.id');
    $this->db->join("{$this->room} D", 'A.idroom = D.id');
    $this->db->join("{$this->cabang} E", 'A.idcab = E.id');
    $this->db->join("{$this->client} F", 'B.iduser = F.id');
    $this->db->join("{$this->terapis} G", 'C.idterapis = G.id');
    $query = $this->db->get();
    return $query->result();
  }
}