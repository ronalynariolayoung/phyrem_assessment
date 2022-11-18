<?php defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends My_Model { 

    public function login($data){
        $response = array();
		$query = $this->db->where('user_name', $data['user_name'])
			->from('users')
			->get();
		$query = $query->row_array();
		if($query) {
			$validPassword = password_verify($data['password'], $query['user_password']);
            // var_dump($validPassword);exit();
			if($validPassword) 
			{
				$response['status'] = 'success';
				$response['user_data'] = $query;
			} else {
                $response['status'] = 'fail';
			}
		} else {
			$response['status'] = 'fail';
		}
		return $response;
	}

}