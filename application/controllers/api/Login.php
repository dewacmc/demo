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
        $this->load->model("LoginModel","Mlogin");
       
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
}