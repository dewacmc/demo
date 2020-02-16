<?php
//use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */

class Jadwal extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->methods['insertjadwal_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->load->model("Jadwalmodel","Mjadwal");
       
    }

    public function listjadwal_post(){
        // header('Content-type: application/json');
        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Methods: GET,POST");
        // header("Access-Control-Allow-Methods: GET, OPTIONS, POST");
        // header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        
            
            $jadwalData = $this->Mjadwal->getAll();
            if (count($jadwalData) == 0) {
                $jadwal["message"] = "Tidak ada banner aktif untuk saat ini";
                $jadwal["success"] = 0;
            }else{
                $jadwal["success"] = 1;
                $jadwal["message"] = "success show list all banners";
            }
               
            $jadwal["data"] = $jadwalData;
            $this->response($jadwal, REST_Controller::HTTP_OK);
    }

    public function listjadwalterapis_post(){
            $idtrp = $this->post("idterapis");
            $jadwalData = $this->Mjadwal->getAllterapis($idtrp);
            if (count($jadwalData) == 0) {
                $jadwal["message"] = "Tidak ada banner aktif untuk saat ini";
                $jadwal["success"] = 0;
            }else{
                $jadwal["success"] = 1;
                $jadwal["message"] = "success show list all banners";
            }
               
            $jadwal["data"] = $jadwalData;
            $this->response($jadwal, REST_Controller::HTTP_OK);
    }

    public function listroom_post(){
        // header('Content-type: application/json');
        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Methods: GET,POST");
        // header("Access-Control-Allow-Methods: GET, OPTIONS, POST");
        // header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        
        $roomsData = $this->Mjadwal->getRooms();
        if (count($roomsData) == 0) {
            $rooms["message"] = "Tidak ada data Ruangan untuk saat ini";
            $rooms["success"] = 0;
        }else{
            $rooms["success"] = 1;
            $rooms["message"] = "success show list all rooms";
        }
            $rooms["data"] = $roomsData;
        $this->response($rooms, REST_Controller::HTTP_OK);

    }

    public function testing_post(){
        $terapis = $this->post("terapis");
        $cabang = $this->post("cabang");
        $room = $this->post("room");
            // echo "<pre>";
            // print_r($cabang);
            // echo "<pre>";

        $filterdata = $this->Mjadwal->getFiter($terapis,$cabang,$room);
        if (count($filterdata) == 0) {
            $filters["message"] = "Tidak ada data Ruangan untuk saat ini";
            $filters["success"] = 0;
        }else{
            $filters["success"] = 1;
            $filters["message"] = "success show list all rooms";
        }
            $filters["data"] = $filterdata;
        $this->response($filters, REST_Controller::HTTP_OK);
    }

    public function cabanglist_post(){
        $filterdata = $this->Mjadwal->getcabang();
        if (count($filterdata) == 0) {
            $filters["message"] = "Tidak ada data Ruangan untuk saat ini";
            $filters["success"] = 0;
        }else{
            $filters["success"] = 1;
            $filters["message"] = "success show list all rooms";
        }
            $filters["data"] = $filterdata;
        $this->response($filters, REST_Controller::HTTP_OK);
    }

    public function terapislist_post(){
        $filterdata = $this->Mjadwal->getterapis();
        if (count($filterdata) == 0) {
            $filters["message"] = "Tidak ada data Ruangan untuk saat ini";
            $filters["success"] = 0;
        }else{
            $filters["success"] = 1;
            $filters["message"] = "success show list all rooms";
        }
            $filters["data"] = $filterdata;
        $this->response($filters, REST_Controller::HTTP_OK);
    }

    public function getallweek_post(){
        $terapis = $this->post("terapis");
        if($terapis){
            $thisweek = $this->Mjadwal->getthisweek($terapis);
            $lastweek = $this->Mjadwal->getlastweek($terapis);
            $nextweek = $this->Mjadwal->getnetweek($terapis);
            $filters["success"] = 1;
            $filters["message"] = "success show list all Jadwal";
        }else{
            $filters["message"] = "User tidak diketahui";
            $filters["success"] = 0;
        }
        
            $filters["thisweek"] = $thisweek;
            $filters["lastweek"] = $lastweek;
            $filters["nextweek"] = $nextweek;
        $this->response($filters, REST_Controller::HTTP_OK);
    }

    public function getbydate_post(){
        $terapis = $this->post("terapis");
        $tglcari= $this->post("tglcari");

        $filterdata = $this->Mjadwal->getFiterdate($terapis,$tglcari);
        if (count($filterdata) == 0) {
            $filters["message"] = "Tidak ada data untuk saat ini";
            $filters["success"] = 0;
            $filters["data"] = $filterdata;
        }else{
            foreach($filterdata as $key=>$item){
                echo "<pre>";
                print_r($filterdata->id);
                echo "<pre>";
            }
            
            $filters["success"] = 1;
            $filters["message"] = "success show list all Jadwal";
        }
            //$filters["data"] = $filterdata;
        $this->response($filters, REST_Controller::HTTP_OK);
    }

    public function getstsjadwal_post(){
        $terapis = $this->post("terapis");
        $tglcari= $this->post("tglcari");

        $filterdata = $this->Mjadwal->getstscurrentmonth($terapis,$tglcari);
        if (count($filterdata) == 0) {
            $filters["message"] = "Tidak ada data untuk saat ini";
            $filters["success"] = 0;
        }else{
            $filters["success"] = 1;
            $filters["message"] = "success show list all Jadwal";
        }
            $filters["data"] = $filterdata;
        $this->response($filters, REST_Controller::HTTP_OK);
    }
}