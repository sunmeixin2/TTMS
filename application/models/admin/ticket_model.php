<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
 *  票务管理model层
 */
 class Ticket_model extends CI_Model
 {


 	/**
 	*	查询演出计划信息 ok
 	*/

 	public function select()
 	{

 		//查询所有的演出计划信息
		$result=$this->db->select('s_id,p_name,h_name,up_time,price,ticket_num')
				->from('show_plan as s')
				->from('play as p')
				->from('show_hall as h')
				->group_start()
						->where('h.h_id=s.h_id')
						->where('p.p_id=s.p_id')
				->group_end()
				->get()->result_array();

		return $result;
 	}



 	/**
 	*	购票信息页面
 	*/

 	public function check($id)
 	{

 		//查询对应的某一演出计划的信息
		$data['show_plan']=$this->db->select('s_id,p_name,up_time,time,price,ticket_num')
				->from('show_plan as s')
				->from('play as p')
				->group_start()
						->where('p.p_id=s.p_id')
						->where(array('s_id'=>$id))
				->group_end()
				->get()->result_array();

		// //对应已经售出的座位票信息
		// $this->db->select('nums,is_sale');
		// $data['tickets']=$this->db->get_where('ticket',array('is_sale'=>1,'s_id'=>$s_id))->result_array();
		// // var_dump($data);
		 return $data;
 	}
 	public function check_ticket($s_id){


 			//对应已经售出的座位票信息
		$this->db->select('nums,is_sale');
		$data['tickets']=$this->db->get_where('ticket',array('is_sale'=>1,'s_id'=>$s_id))->result_array();
		 var_dump($data);
		 exit(0);
		 return $data;
 	}


 	/**
 	*	查询所对应的演出计划的座位票  用户购票
 	*/

 	public function ticket_action($data,$s_id) 
 	{ 
 		
 		$this->db->query("set autocommit=0");		//禁止事务自动提交
 		$this->db->query('start transaction');			//开启事务
 		$i=1;

 		foreach ($data as $value) 			//循环查看用户需要购买的每张票是否已经售出
 		{
			//判断用户所选中的票是否已经售出
			// $is_sale=$this->db->select('is_sale')
			// 	->get_where('ticket',array('s_id'=>$id,'nums'=>$value))
			// 	->result_array();


				$this->db->query('BEGIN');
				$is_sale=$this->db->query("select *from ticket where s_id=$s_id and nums=$value FOR UPDATE")->result_array();
				// var_dump($is_sale);
				// exit(0);
				// var_dump($is_sale);exit();
				if($is_sale[0]['is_sale'] != 0){
					$this->db->query('rollback');		//如果此票已售出  则事务回滚
					return false;
				}
				// else{
				// 	// $this->db->query('commit');		//此张票还为售出  可以继续购买
				// 	$this->db->query('BEGIN');
				// 	$this->db->query('select *from ticket where s_id='.$id.' and nums='.$value.' FOR UPDATE')
				// }
 		
 		}	

 		//用户所选的座位 都 还未出售

 		foreach ($data as $value) 			//在用户所选的每张票的信息还为售出情况下 用户才可买票
 		{

 				$sale=array('is_sale'=>1);

 				//按照s_id和座位号修改信息
 				$status1=$this->db->update('ticket',$sale,array('s_id'=>$s_id,'nums'=>$value));

 				//对应演出计划票数减少
 				$t=$this->db->get_where('show_plan',array('s_id'=>$s_id))->result_array();

 				$status2=$this->db->query('update show_plan set ticket_num='.($t[0]['ticket_num']-1).' where s_id='.$s_id);

 				if( $status2 && $status1)
 				{
 					$this->db->query('COMMIT');		//ticket表和show_plan表更新成功  购票成功  提交事务

 				}else
 				{
 					$this->db->query('rollback');		//购票失败  进行事务回滚
 					return false;
 				}
 		
 		}

 		return true;
 	}



 	/**
 	*	退票
 	*/
 	public function return_ticket()
 	{

 	}


 } 



?>