<?php
//use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Hasil extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model("Hasilmodel","MHasil");
       
    }

    public function getalldata_post(){
            $idjw = $this->post("idjadwal");
            $idtrp= $this->post("idterapis");
            $jadwalData = $this->MHasil->getAlldata($idjw,$idtrp);
            
            if (count($jadwalData) == 0) {
                $jadwal["message"] = "Id Jadwal Tidak ditemukan";
                $jadwal["success"] = 0;
            }else{
                $listpasien = $this->MHasil->getAllpasien($idjw);
                if (count($listpasien)== 0){
                    $jadwal["message"] = "List Pasien Tidak ditemukan";
                    $jadwal["success"] = 0;
                }else{
                    $jadwal["success"] = 1;
                    $jadwal["message"] = "success show list all Data";
                }
            }
               
            $jadwal["data"] = $jadwalData;
            $jadwal["pasien"] = $listpasien;
            $this->response($jadwal, REST_Controller::HTTP_OK);
    }

    public function userhadir_post(){
            $idjw = $this->post("idjadwal");
            $iduser= $this->post("iduser");
            $hadir= $this->post("hadir");
            $idterapis=$this->post("idterapis");
            $data = array(
                "hdr" => $hadir,
              );
              $hasilterapis = $this->MHasil->absendataterapis($idjw,$idterapis,$data);
              $hasilhadir = $this->MHasil->absendata($idjw,$iduser,$data);
            if($hasilhadir){
                $jadwal["success"] = 1;
                $jadwal["message"] = "success update Absen";
            }else{
                $jadwal["message"] = "Error Update Absen";
                $jadwal["success"] = 0;
            }
            $this->response($jadwal, REST_Controller::HTTP_OK);
    }
}