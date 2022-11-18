<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends My_Controller {

	public function __construct(){
        parent::__construct();
		$this->load->model('Login_model', 'login_model');
		$this->load->library('session');
	}

	public function index()
	{
		$data['primaryView'] = 'login';
		$data['templateStyle'] = 'default'; 
		$this->load->view('layouts/'.$data['templateStyle'].'_template', $data);
	}

	public function process_login(){
		$data = $this->input->post();

		// $data['user_name'] = $data->user_name;
		// $data['password'] = 'password';

		$isLoggedIn = $this->login_model->login($data);
        // var_dump($isLoggedIn);
        // exit();

        if($isLoggedIn['status']!='fail'){ 
            $this->session->set_userdata('isLoggedIn', true);
            $this->session->set_userdata('loggedUser', $isLoggedIn['user_data']);
            redirect('home/index'); 
        }else{
            $this->session->set_flashdata('save_result', false);
            $this->session->set_flashdata('message', "Login Failed");
            redirect('login/index');

        }

	}

    public function logout(){ 
        $this->session->sess_destroy();
        redirect('login');
    }

}