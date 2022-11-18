<?php defined('BASEPATH') or exit('No direct script access allowed');

class Home_model extends My_Model { 


    public function get_users(){
        $this->db->select('employees.id as employee_id, users.id as user_id, employees.first_name, employees.last_name, users.user_name, users.user_password, users.user_type'); 
		$this->db->join('employees', 'users.id = employees.user_id', 'inner');
		$this->db->from('users'); 
		$query = $this->db->get();
        return$query->result(); 
    }
 
    public function get_user_view($id){ 
        $this->db->select('employees.id as employee_id, users.id as user_id, employees.first_name, employees.last_name, users.user_name, users.user_password, users.user_type'); 
		$this->db->join('employees', 'users.id = employees.user_id', 'inner');  
		$this->db->where('users.id',$id);
		$this->db->from('users'); 
		$query = $this->db->get();

        return$query->result();  
    }

    public function get_user_view_time_record($id){ 
        $this->db->select('*'); 
		$this->db->join('employees', 'users.id = employees.user_id', 'inner');
		$this->db->join('employee_time_records ETR', 'ETR.user_id = users.id', 'inner'); 
		$this->db->where('users.id',$id);
		$this->db->from('users'); 
		$query = $this->db->get();

        return$query->result();  
    }

    public function get_employee_time_record(){ 
        $this->db->select('employees.*, ETR.*');
		$this->db->join('employee_time_records ETR', 'employees.id = ETR.employee_id', 'inner');
        $this->db->from('employees');
        $query = $this->db->get();

        return$query->result();  
    }
        
    public function add_users($data){
        $this->db->insert('users',$data);

        if ($this->db->affected_rows() >= 0) {
            return $this->db->insert_id();
        } else {
            return false;
        } 
    }
        
    public function edit_user($data){
        if($data['id'] !=0){
            $this->db->where('id',$data['id']);
            return $this->db->update('users',$data);
        }
    }
        
    public function add_employees($data){
        $this->db->insert('employees',$data);

        if ($this->db->affected_rows() >= 0) {
            return $this->db->insert_id();
        } else {
            return false;
        } 
    }
        
    public function edit_employee($data){
        if($data['id'] !=0){
            $this->db->where('id',$data['id']);
            return $this->db->update('employees',$data);
        }
    }

    // public function update_users($id) 
    // {
    //     $data=array(
    //         'user_name'=> 'test'.rand(10,10000),//$this->input->post('username'),
    //         'user_password'=> 'test'.rand(10,10000), //$this->input->post('password')
    //     );
    //     if($id==0){
    //         return $this->db->insert('users',$data);
    //     }else{
    //         $this->db->where('id',$id);
    //         return $this->db->update('users',$data);
    //     }    	

    // }

    public function check_username($username){

        $this->db->select('COUNT(id) as counter');  
		$this->db->where('users.user_name',$username);
		$this->db->from('users'); 
		$query = $this->db->get();

        return $query->result();
    }

    public function deleterecords($id){
        if(is_array($id)){
            $this->db->where_in('id', $id);
        }else{
            $this->db->where('id', $id);
        }
        
        $this->db->delete("users");
        return true;
    } 
 
    public function get_employee_data($data, $type){ 
		// type value can be user_name or employee_id
        if($type == 'employee_id'){
            $this->db->select('employees.*');  
            $this->db->where('id',$data);
            $this->db->from('employees'); 
            $query = $this->db->get();
        }else{
            // $type=user_name
            $this->db->select('*');  
            $this->db->from('users'); 
            $this->db->join('employees', 'users.id = employees.user_id', 'inner'); 
            $this->db->where('users.user_name',$data); 
            $query = $this->db->get();
        }

        return$query->result();  
    }

    public function add_employee_time_record($data){
        
        $this->db->insert('employee_time_records',$data);

        if ($this->db->affected_rows() >= 0) {
            return $this->db->insert_id();
        } else {
            return false;
        } 
    }

    public function get_time_record($data, $type){ 
		// type value can be username or employee_id
        if($type == 'employee_id'){
            $this->db->select('*'); 
            $this->db->from('employee_time_records');
            $this->db->where('employee_id',$data);
            $this->db->order_by('date_added','desc');
            $this->db->limit(1); 
            $query = $this->db->get();
        }else{ 
            //meaning, user inputs user_name
            //$data value is user_name 
            
            $this->db->select('*');  
            $this->db->from('users'); 
            $this->db->join('employees', 'users.id = employees.user_id', 'inner');
            $this->db->join('employee_time_records', 'employee_time_records.user_id = users.id', 'inner'); 
            $this->db->where('users.user_name',$data);
            $this->db->order_by('employee_time_records.date_added','desc');
            $this->db->limit(1); 
            $query = $this->db->get();
        }
        return $query->result();
        // var_dump($query);exit();
    }

}