<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    public function __construct()
	{
		parent::__construct();
		$this->writeDB = $this->load->database('default', TRUE, TRUE);

		 // Pass reference of database to the CI-instance
		 //  Assists with intellisense and profiler
		$CI =& get_instance();
		$CI->writeDB =& $this->writeDB;
	}

    /**
	 * Custom Function that updates the timestamps on all records
	 */
	final protected function updateTimestamps($fields, $action)
	{
		$now = UTC_Now();
		if ($action == 'update') {
			$fields = array_merge($fields, ['datetime_modified' => $now]);
		}
		if ($action == 'insert') {
			$fields = array_merge($fields, ['datetime_added	' => $now]);
		}
		if ($action == 'delete') {
			$fields = array_merge($fields, ['datetime_modified' => $now]);
		}
		return $fields;
	}

    final public function general_save($table_name,$save_data)
    {
		$save_data = $this->updateTimestamps($save_data, 'insert');
		$this->writeDB->insert($table_name, $save_data);
		if ($this->writeDB->affected_rows() >= 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
    }

    final public function general_fetch($table="",$where = array(), $order_by = array(), $join = array(), $select="*" ){

        if($table){
            $this->db->select($select);
			if(!empty($where)){
				foreach($where as $w){
					$this->db->where($w["name"],$w['value']);
				}
			}
			if($order_by){
				$this->db->order_by($order_by["name"], $order_by["order"]);
			}
			if($join){
				foreach($join as $j){
					$this->db->join($j['table'], $j['condition']);
				}
			}

            $query = $this->db->get($table);
            $return = $query->result_array();

            return $return;
        }else{
            die("Table name was not defined.");
        }


	}

    final public function general_update($table_name,$primary_key,$save_data,$action="update"){
		$save_data = $this->updateTimestamps($save_data, $action);
		$this->writeDB->where($primary_key, $save_data[$primary_key])
				->set($save_data)
				->update($table_name);

		if ($this->writeDB->affected_rows() >= 0) {
			return true;
		} else {
			return false;
		}
    }

}