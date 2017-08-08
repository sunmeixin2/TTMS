<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Show_hall_model extends CI_Model{

	public function register($data){

		$this->db->insert('user',$data);
	}



	/*影厅管理模块*/


	/*增加影厅*/
	public function add_YT($data){
		$this->db->insert('show_hall',$data);
	}

	/*查看影厅信息*/
	public function check(){
		$data = $this->db->get('show_hall')->result_array();
		return $data;
	}

	/*编辑影厅信息时的查询影厅信息*/
	public function check_YT($h_id){
		$data = $this->db->where(array('h_id'=>$h_id))->get('show_hall')->result_array();
		return $data;
	}

	public function update($h_id,$data){
		$this->db->update('show_hall',$data,array('h_id' =>$h_id));

	}

	/*删除*/
	public function delete($h_id){

		$this->db->delete('show_hall',array('h_id'=>$h_id));
	}


	
}