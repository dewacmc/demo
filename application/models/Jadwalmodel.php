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

 

  public function getAll(){
    $this->db->select('A.id, CONCAT(G.nama,": ",F.nama,"- " ,D.name,"- ",E.nama ) AS title,A.start, A.end, A.jenis, E.nama as cabang, G.nama as terapis, D.name as room, D.color, F.tgldaftar, F.nama');
    $this->db->from("{$this->jadwal_h} A");
    $this->db->join("{$this->jadwal_d} B", 'A.id = B.id');
    $this->db->join("{$this->jadwal_d1} C", 'A.id = C.id');
    $this->db->join("{$this->room} D", 'A.idroom = D.idroom');
    $this->db->join("{$this->cabang} E", 'A.idcab = E.id');
    $this->db->join("{$this->client} F", 'B.iduser = F.id');
    $this->db->join("{$this->terapis} G", 'C.idterapis = G.id');
    $query = $this->db->get();
    return $query->result();
  }

  public function getFiter($terapis,$cabang,$room){
    $this->db->select('A.id, CONCAT(G.nama,": ",F.nama,"- " ,D.name,"- ",E.nama ) AS title,A.start, A.end, A.jenis, E.nama as cabang, G.nama as terapis, D.name as room, D.color, F.tgldaftar, F.nama');
    $this->db->from("{$this->jadwal_h} A");
    $this->db->join("{$this->jadwal_d} B", 'A.id = B.id');
    $this->db->join("{$this->jadwal_d1} C", 'A.id = C.id');
    $this->db->join("{$this->room} D", 'A.idroom = D.idroom');
    $this->db->join("{$this->cabang} E", 'A.idcab = E.id');
    $this->db->join("{$this->client} F", 'B.iduser = F.id');
    $this->db->join("{$this->terapis} G", 'C.idterapis = G.id');
    if(is_array($terapis) && count($terapis) > 0){
      $this->db->where_in('G.nama', $terapis );
    }

    if(is_array($cabang) && count($cabang) > 0){
      $this->db->where_in('E.nama', $cabang );
    }

    if(is_array($room) && count($room) > 0){
     $this->db->where_in('D.name', $room);
    }
    $this->db->where('month(A.start)',date('m'));
    $query = $this->db->get();
    return $query->result();
  }

  public function getcabang(){
    $this->db->select('A.id,A.nama');
    $this->db->from("{$this->cabang} A");
    $query = $this->db->get();
    return $query->result();
  }

  public function getRooms(){
    $this->db->select('A.name,A.color');
    $this->db->from("{$this->room} A");
    $query = $this->db->get();
    return $query->result();
  }

  public function getterapis(){
    $this->db->select('A.id,A.nama');
    $this->db->from("{$this->terapis} A");
    $query = $this->db->get();
    return $query->result();
  }
}