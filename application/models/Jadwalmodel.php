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
    $this->db->join("{$this->client} F", 'B.iduser = F.idpasien');
    $this->db->join("{$this->terapis} G", 'C.idterapis = G.id');
    $query = $this->db->get();
    return $query->result();
  }

  public function getAllterapis_lama($terapis){
    $curMonth = date('F');
    $curYear  = date('Y');
    $timestamp    = strtotime($curMonth.' '.$curYear);
    $first = date('Y-m-01 00:00:00', $timestamp);
    $last  = date('Y-m-t 12:59:59', $timestamp); 
    $this->db->select('A.id, CONCAT(G.nama,": ",F.nama,"- " ,D.name,"- ",E.nama ) AS title,A.start, A.end, A.jenis, E.nama as cabang, G.nama as terapis, D.name as room, D.color, F.tgldaftar, F.nama');
    $this->db->from("{$this->jadwal_h} A");
    $this->db->join("{$this->jadwal_d} B", 'A.id = B.id');
    $this->db->join("{$this->jadwal_d1} C", 'A.id = C.id');
    $this->db->join("{$this->room} D", 'A.idroom = D.idroom');
    $this->db->join("{$this->cabang} E", 'A.idcab = E.id');
    $this->db->join("{$this->client} F", 'B.iduser = F.idpasien');
    $this->db->join("{$this->terapis} G", 'C.idterapis = G.id');
    $this->db->where('G.googleid', $terapis);
    $this->db->where('A.start BETWEEN "'. date('Y-m-d', strtotime($first)). '" and "'. date('Y-m-d', strtotime($last)).'"');
    $query = $this->db->get();
    return $query->result();
  }


  public function getAllterapis($terapis){
    $curMonth = date('F');
    $curYear  = date('Y');
    $timestamp    = strtotime($curMonth.' '.$curYear);
    $first = date('Y-m-01 00:00:00', $timestamp); // awal bulan
    $last  = date('Y-m-t 12:59:59', $timestamp); // akhir bulan
            // echo "<pre>";
            // print_r($first);
            // print_r($last);
            // echo "<pre>";
    $this->db->select('A.id, CONCAT(G.nama,": ",D.name,"- ",E.nama ) AS title,A.start, A.end, E.nama as cabang, G.nama as terapis, D.name as room, D.color');
    $this->db->from("{$this->jadwal_h} A");
    $this->db->join("{$this->jadwal_d1} C", 'A.id = C.id');
    $this->db->join("{$this->room} D", 'A.idroom = D.idroom');
    $this->db->join("{$this->cabang} E", 'A.idcab = E.id');
    $this->db->join("{$this->terapis} G", 'C.idterapis = G.id');
    $this->db->where('G.googleid', $terapis);
    $this->db->where('A.start BETWEEN "'. date('Y-m-d', strtotime($first)). '" and "'. date('Y-m-d', strtotime($last)).'"');
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
      $this->db->where_in('G.id', $terapis );
    }

    if(is_array($cabang) && count($cabang) > 0){
      $this->db->where_in('E.id', $cabang );
    }

    if(is_array($room) && count($room) > 0){
     $this->db->where_in('D.idroom', $room);
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
    $this->db->select('A.idroom,A.name,A.color');
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

  public function getthisweek($terapis){
    $curdate=date('Y-m-d');
    //cari data awal minggu dan akhir minggu
    $awal= date("Y-m-d", strtotime('monday this week', strtotime($curdate)));   // hari senin di minggu berjalan
    $akhir= date("Y-m-d", strtotime('sunday this week', strtotime($curdate)));  // hari minggu di minggu berjalan
    $this->db->select('A.id, A.start, A.end, E.nama as cabang, G.nama as terapis, D.name as room, D.color');
    $this->db->from("{$this->jadwal_h} A");
    $this->db->join("{$this->jadwal_d1} C", 'A.id = C.id');
    $this->db->join("{$this->room} D", 'A.idroom = D.idroom');
    $this->db->join("{$this->cabang} E", 'A.idcab = E.id');
    $this->db->join("{$this->terapis} G", 'C.idterapis = G.id');
    $this->db->where('G.googleid', $terapis);
    $this->db->where('A.start BETWEEN "'. date('Y-m-d', strtotime($awal)). '" and "'. date('Y-m-d', strtotime($akhir)).'"');
    $query = $this->db->get();
    return $query->result();
    
  }

  public function getFiterdate($terapis,$tglcari){
    $time = strtotime($tglcari);
    $datecari = date('Y-m-d', $time);
    $this->db->select('A.id, A.start, A.end, E.nama as cabang, G.nama as terapis, D.name as room, D.color');
    $this->db->from("{$this->jadwal_h} A");
    $this->db->join("{$this->jadwal_d1} C", 'A.id = C.id');
    $this->db->join("{$this->room} D", 'A.idroom = D.idroom');
    $this->db->join("{$this->cabang} E", 'A.idcab = E.id');
    $this->db->join("{$this->terapis} G", 'C.idterapis = G.id');
    $this->db->where('G.googleid', $terapis);
    $this->db->where('date(A.start)', $datecari);
    $query = $this->db->get();
    return $query->result();
  }
}