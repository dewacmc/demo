<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JadwalModel extends CI_Model
{
  public $room = 'cmc_room';
  public $cabang = 'cmc_cabang';
  public $terapis='cmc_terapis';
  public $client= 'cmc_client';
  public $jadwal= 'cmc_jadwal';

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
    $this->db->select('A.id, A.title, A.start, A.end, A.descp, B.name, B.color, C.nama, D.nama, D.tgldaftar, E.nama');
    $this->db->from("{$this->jadwal} A");
    $this->db->join("{$this->room} B", 'A.idroom = B.idroom');
    $this->db->join("{$this->terapis} C", 'A.idterapis = C.id');
    $this->db->join("{$this->client} D", 'A.idclient = D.id');
    $this->db->join("{$this->cabang} E", 'A.idcab = E.id');
    $query = $this->db->get();
    return $query->result();
  }

}