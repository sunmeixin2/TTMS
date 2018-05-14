<?php 


/**
* 	用户管理Model的层
*/
class User_model extends CI_Model
{

	public function login_check($user_name){
		$this->db->select('uid,passwd,type,u_name');
		$result=$this->db->where('account',$user_name)->get('user')->result_array();

		return $result[0];
		
	}
	
	/*查看所有用户信息*/
	public function select(){

		$data = $this->db->get('user')->result_array();
		return $data;
	}

	/*
	*	添加用户
	*/
	public function add($data){

		$status=$this->db->insert('user',$data);
		return $status;

	}



	/*编辑用户信息时的查询*/
	public function edit_select($uid)
	{
		$data = $this->db->where(array('uid'=>$uid))->get('user')->result_array();
		return $data;
	}

	public function edit($data)
	{
		$this->db->update('user',$data['user'],array('uid' =>$data['uid']));

	}


	/*删除用户信息*/
	public function delete($uid){

		$status=$this->db->delete('user',array('uid'=>$uid));
		return $status;

	}
}



?>