<?php

class MY_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('session');
    }
    

}

class AuthController extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $isLoggedIn = $this->session->get_userdata('isLoggedIn');
        
        if($this->session->userdata('isLoggedIn') != 1){
            redirect('/login');
        } 

       
    }

    public function check_user_type(){
        if($this->session->userdata('loggedUser')['user_type'] == '2'){ 
            redirect('/time-record');
        }
    }
}