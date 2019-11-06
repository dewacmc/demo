<?php
use Restserver\Libraries\REST_Controller;
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
        $this->load->model("api/JadwalModel","Mjadwal");
       
    }

    public function listjadwal_post(){
        header("Access-Control-Allow-Origin: *");
            $jadwal["success"] = 1;
            $jadwal["message"] = "success show list all banners";
            $jadwalData = $this->Mjadwal->getAll();
            if (count($jadwalData) == 0) 
                $jadwal["message"] = "Tidak ada banner aktif untuk saat ini";
                $jadwal["success"] = 0;
            $jadwal["data"] = $jadwalData;
            $this->response($jadwal, REST_Controller::HTTP_OK);
    }

}