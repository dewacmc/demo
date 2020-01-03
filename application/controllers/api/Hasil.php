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
            $idtrp = $this->post("idjadwal");
            $jadwalData = $this->Mjadwal->getAlldata($idtrp);
            if (count($jadwalData) == 0) {
                $jadwal["message"] = "Id Jadwal Tidak ditemukan";
                $jadwal["success"] = 0;
            }else{
                $jadwal["success"] = 1;
                $jadwal["message"] = "success show list all Data";
            }
               
            $jadwal["data"] = $jadwalData;
            $this->response($jadwal, REST_Controller::HTTP_OK);
    }
}