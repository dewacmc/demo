<?php
//use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Login extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model("Loginmodel","Mlogin");
       
    }
    public function ceklogin_post(){
        $loginid = $this->post("email");
        $loginpasw = $this->post("pasw");
        $roomsData = $this->Mlogin->getLogin($loginid,$loginpasw);
        if (count($roomsData) == 0) {
            $rooms["message"] = "Check Your Username or Password";
            $rooms["success"] = 0;
        }else{
            $rooms["success"] = 1;
            $rooms["message"] = "success login";
        }
            $rooms["data"] = $roomsData;
        $this->response($rooms, REST_Controller::HTTP_OK);

    }

    public function newregis_post(){
        $nama = $this->post("nama");
        $notel = $this->post("notel");
        $email = $this->post("email");
        $googleid = $this->post("gooleid");
            // echo "<pre>";
            // print_r($cabang);
            // echo "<pre>";
        if ($nama == "" || $googleid == "" || $email == "" ) {
            $resp["success"] = 0;
            $resp["message"] = "All field is required";
            $this->response($resp, REST_Controller::HTTP_OK);
        }else{
            $data = array(
                "nama" => $nama,
                "notel"  => $notel,
                "email" => $email,
                "googleid" => $googleid,
                );
                //tidak perlu cek email / googleid karena di firebase google sudah dicek tidak mungkin double
                //lgs masuk ke database aja 
                $filterdata = $this->Mlogin->registerterapis($data);
                if ($filterdata) {
                    $filters["success"] = 1;
                    $filters["message"] = "success Daftar Baru";
                }else{

                    $filters["message"] = "Error Daftar Baru";
                    $filters["success"] = 0;
                }
                $this->response($filters, REST_Controller::HTTP_OK);
                
        }

    }
}