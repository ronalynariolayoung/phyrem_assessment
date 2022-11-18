<?php
/** 
* @author  Ronalyn S. Ariola-Young
* @version 1.0
* @since   2022-11-14 
*/

defined('BASEPATH') OR exit('No direct script access allowed');


class Home extends AuthController {
	// class Home extends CI_Controller {

	public function __construct(){
        parent::__construct();
		$this->load->model('Home_model', 'home_model'); //load the Home_model and call home_model
		$this->load->library('session');
	}
	
	/**
	* @functionName: index
	* @apiNote : shows the list of users ; only Super Admin can access this page
	* @param: void
	* @return: void
	*/
	public function index()
	{
		$this->check_user_type();
		$data['primaryView'] = '/users/index'; //this is the view php file
		$data['templateStyle'] = 'bootstrap'; //uses the bootstrap_template.php
		
		// to getusers
		$data['users'] = $this->home_model->get_users();
		// to get logged user
		$user = $this->session->userdata('loggedUser');
		$data['loggedInUser'] = $user;
		$this->load->view('layouts/'.$data['templateStyle'].'_template', $data);
	}
 

	
	/**
	* @functionName: users_view
	* @apiNote : show details of a user and list of his time records ; only Super Admin can access this page
	* @param: int $id == user_id
	* @return: void
	*/
	public function users_view($id){
		$data['primaryView'] = '/users/view';
		$data['templateStyle'] = 'bootstrap';  
		$data['user'] = $this->home_model->get_user_view($id)[0];
		$data['time_records'] = $this->home_model->get_user_view_time_record($id);


		$this->load->view('layouts/'.$data['templateStyle'].'_template', $data);

	}

	/**
	* @functionName: users_edit
	* @apiNote : allow user to edit ; only Super Admin can access this page
	* @param: int $id == user_id
	* @return: void
	*/
	public function users_edit($id){
		$data['primaryView'] = '/users/edit';
		$data['templateStyle'] = 'bootstrap'; 
		$data['user'] = $this->home_model->get_user_view($id)[0];
		$this->load->view('layouts/'.$data['templateStyle'].'_template', $data);

	}

	/**
	* @functionName: employee_time_record
	* @apiNote : show list of employee time record; Super Admin and Admin can access this page
	* @param: void
	* @return: void
	*/
	public function employee_time_record(){
		$data['primaryView'] = '/employees/index';
		$data['templateStyle'] = 'bootstrap'; 

		$data['employeeRecords'] = $this->home_model->get_employee_time_record();

		$this->load->view('layouts/'.$data['templateStyle'].'_template', $data);

	}
	public function time_record(){
		$data['primaryView'] = '/employees/time_record';
		$data['templateStyle'] = 'default'; 

		$data['employeeRecords'] = $this->home_model->get_employee_time_record();

		// to get logged user
		$user = $this->session->userdata('loggedUser');
		$data['loggedInUser'] = $user;
		
		$this->load->view('layouts/'.$data['templateStyle'].'_template', $data);

	}

	public function users_create(){

		$data['primaryView'] = '/users/create';
		$data['templateStyle'] = 'bootstrap'; 
		// to get logged user
		$user = $this->session->userdata('loggedUser');
		$data['loggedInUser'] = $user;

		$this->load->view('layouts/'.$data['templateStyle'].'_template', $data);

	}


	/**
	* @functionName: generate_password
	* @apiNote : display 10 characters which contains a lowercase, uppercase, number, and special character
	* @param: void
	* @return: void
	*/
	public function generate_password() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%&*]+$';
		$pass = array(); //declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 10; $i++) { //minimum of 10 characters
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		} 
		echo implode($pass);   
	} 


	/**
	* @functionName: hash_username
	* @apiNote : type value can be encode or decode
	* @param: user_name and $type
	* @return: string if decode
	*/
	public function hash_username($username, $type){
		if($type == 'encode'){
			$string = base64_encode($username);
			echo $string;
		}else{
			$string = base64_decode($username); 
			return $string;
		}   
	}

	/**
	* @functionName: create_save
	* @apiNote : function to save 
	* @param: void
	* @return: void
	*/
	public function create_save(){
		$data = $this->input->post();
		
        $users_data=array(
            'user_name'=> $data['user_name'], 
            'user_password'=> password_hash( $data["password"], PASSWORD_DEFAULT),
            'user_type'=> $data['user_type'],   
            );
		
		$add_users_query = $this->home_model->add_users($users_data);
		if($add_users_query){
			$employees_data=array(
				'first_name'=> $data['first_name'], 
				'last_name'=> $data['last_name'], 
				'created_by'=> $data['created_by'],  
				'user_id'=> $add_users_query,   	
				);
				$add_employees_query = $this->home_model->add_employees($employees_data);

				if($add_employees_query){
					$this->session->set_flashdata('save_result', true);
					$this->session->set_flashdata('message', "User successfully created");
				}else{
					$this->session->set_flashdata('save_result', false);
					$this->session->set_flashdata('message', "Cannot create user");

				}
				redirect('users-create'); 
		}

	}

	public function edit_save(){
		$data = $this->input->post();
		
        $user_data=array(
            'id'=> $data['user_id'], 
            'user_name'=> $data['user_name'], 
            'user_password'=> password_hash( $data["password"], PASSWORD_DEFAULT), 
            'user_type'=> $data['user_type'],   
            );
		
		$edit_user_query = $this->home_model->edit_user($user_data);

		if($edit_user_query){
			$employee_data=array(
				'id'=> $data['employee_id'], 
				'first_name'=> $data['first_name'], 
				'last_name'=> $data['last_name'],  	
				);
				$edit_employee_query = $this->home_model->edit_employee($employee_data);

				if($edit_employee_query){
					$this->session->set_flashdata('save_result', true);
					$this->session->set_flashdata('message', "User successfully edited");
				}else{
					$this->session->set_flashdata('save_result', false);
					$this->session->set_flashdata('message', "Cannot create user");

				}
				redirect('users-edit/'.$data['user_id']); 
		}

	}
	public function check_username($data){
		$check = $this->home_model->check_username($data);
		if($check[0]->counter >= 1){
			echo 'Username already exists!';
		} 
	}
	public function deleteuser($id = '0'){ 
		if($id == 0){
			$id = $this->input->post()['ids'];
		}

		$response=$this->home_model->deleterecords($id);
		if(!is_array($id)){
			if($response==true){
				$this->session->set_flashdata('save_result', true);
				$this->session->set_flashdata('message', "User successfully deleted");
			}
			else{
				$this->session->set_flashdata('save_result', true);
				$this->session->set_flashdata('message', "Cannot delete your own account");
			}
			redirect('/home');
		}
		echo "suceess"; 
	}

	/**
	* @functionName: time_record_save
	* @apiNote : this function should process employee_time_record for inputs like employee_id and username and if qr code has been scanned
	* @param: $data ; either unhashed user_name, hashed user_name or employee_id
	* @param: $qr ; //qr value can 1 or 0 ( if 1, data came from qrcode;else from time_record page)
	* @return: message
	*/
	public function time_record_save($data, $qr=0){
		
		//if qr == 1 ; decode
		// type value can be username or employee_id
		$date_added = date('Y-m-d H:i:s');
		$time_now = date('H:i:s');

		if ( is_numeric($data) ) {
			$response=$this->home_model->get_employee_data($data, 'employee_id'); //check if employee exists in DB
			// print_r($response);exit();
			if(empty($response)){
				$message = 'Employee does not exist!';
				print_r($message);
			}else{
				// EMPLOYEE has previous record in employee_time_records table
				$employee_id = $response[0]->id;
				$user_id = $response[0]->user_id;
				
				//call function process_employee_time_record
				$this->process_employee_time_record($data, 'employee_id', $employee_id, $user_id ); 
				 
			}
			
		} else {
			//THIS IS FOR USERNAME 
			if($qr!=0){
				//if user scans a QR code
				$data = $this->hash_username($data, 'decode');
				
			}
				//check if users exists in DB
				$response=$this->home_model->get_employee_data($data, 'user_name'); //check if employee exists in DB
				// print_r($response);exit();
				// EMPLOYEE has previous record in employee_time_records table 
				if(empty($response)){
					$message = 'Employee does not exist!';
					print_r($message);
				}else{
					$employee_id = $response[0]->id;
					$user_id = $response[0]->user_id;

					//call function process_employee_time_record
					$this->process_employee_time_record($data, 'user_name', $employee_id, $user_id ); 
				}
		} 

	}
	

	public function process_employee_time_record($data, $type, $employee_id,  $user_id ){

		$date_added = date('Y-m-d H:i:s');
		$time_now = date('H:i:s');
				//check if users last activity is time in or time out 
				$check_last_record = $this->home_model->get_time_record($data, $type);
				
				if(empty($check_last_record)){
					//if empty, insert time in
					$insert_data = array(
						'employee_id'=>$employee_id,
						'user_id'=>$user_id,
						'date_added'=>$date_added,
						'time_in'=>$time_now,  
					);
					$add_employee_time_record = $this->home_model->add_employee_time_record($insert_data);
					$message = 'Time in successful.';
				}else{

					//TO DO: transfer this into a function
					$time_in = $check_last_record[0]->time_in;
					$time_out = $check_last_record[0]->time_out;
					// check if time in is empty , insert time in; else insert time out
					if($time_in =='00:00:00'){
						//since in the last record the timein is null; insert timeout
						$insert_data = array(
							'employee_id'=>$employee_id,
							'user_id'=>$user_id,
							'date_added'=>$date_added,
							'time_in'=>$time_now,  
						);
						$message = 'Time in successful.';

					}else{
						$insert_data = array(
							'employee_id'=>$employee_id,
							'user_id'=>$user_id,
							'date_added'=>$date_added,
							'time_out'=>$time_now,  
						);
						$message = 'Time out successful.';

					}
					
					$add_employee_time_record = $this->home_model->add_employee_time_record($insert_data);
				}
		
				print_r($message);
	}
 
 

}
