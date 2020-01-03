<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HasilModel extends CI_Model
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

  public function getAlldata($idjadwal){
    // $curMonth = date('F');
    // $curYear  = date('Y');
    // $timestamp    = strtotime($curMonth.' '.$curYear);
    // $first = date('Y-m-01 00:00:00', $timestamp);
    // $last  = date('Y-m-t 12:59:59', $timestamp); 
    $this->db->select('A.id, CONCAT(G.nama,": ",F.nama,"- " ,D.name,"- ",E.nama ) AS title,A.start, A.end, A.jenis, E.nama as cabang, G.nama as terapis, D.name as room, D.color, F.tgldaftar, F.nama');
    $this->db->from("{$this->jadwal_h} A");
    $this->db->join("{$this->jadwal_d} B", 'A.id = B.id');
    $this->db->join("{$this->jadwal_d1} C", 'A.id = C.id');
    $this->db->join("{$this->room} D", 'A.idroom = D.idroom');
    $this->db->join("{$this->cabang} E", 'A.idcab = E.id');
    $this->db->join("{$this->client} F", 'B.iduser = F.idpasien');
    $this->db->join("{$this->terapis} G", 'C.idterapis = G.id');
    $this->db->where('A.id', $idjadwal);
    // $this->db->where('A.start BETWEEN "'. date('Y-m-d', strtotime($first)). '" and "'. date('Y-m-d', strtotime($last)).'"');
    $query = $this->db->get();
    return $query->result();
  }
}