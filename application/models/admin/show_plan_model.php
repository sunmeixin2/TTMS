<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 演出计划model层
*/


class Show_plan_model extends CI_Model
{

	/**
	*	查询演出计划信息 ok
	*/
	public function select(){

		// $this->load->database();  		//已在路由中自动载入

		$result=$this->db->select('s_id,p_name,h_name,up_time,down_time,ticket_num')
				->from('show_plan as s')
				->from('play as p')
				->from('show_hall as h')
				->group_start()
						->where('h.h_id=s.h_id')
						->where('p.p_id=s.p_id')
				->group_end()
				->order_by('s_id','asoc')
				->get()->result_array();

		return $result;
	}

	/**
	*	查询所有的剧目和影厅信息
	*/

	public function add_check(){

		//所有剧目信息
		$data['play']=$this->db->select('p_id,p_name')->get('play')->result_array();

		//所有影厅信息
		$data['hall']=$this->db->select('h_id,h_name')->get('show_hall')->result_array();

		return $data;
	}

	/**
	*	添加演出计划信息	ok
	*/
	public function add($data){
	

		//先查询出对应影厅的座位数
		$this->db->select("rows,cols");
		$this->db->where('h_id',$data['h_id']);
		$nums=$this->db->get('show_hall')->result_array();
		
		//根据演出厅生成总票数
		$data['ticket_num']=$nums[0]['rows']*$nums[0]['cols'];
		

		$status=$this->db->insert('show_plan',$data);

		$s_id=$this->db->insert_id();//查询到最新添加的演出计划的s_id  
		
		//添加演出计划成功，在ticket表中生成对应的票数
		if($status)
		{
			for($i=1;$i<=$data['ticket_num'];$i++){
				
				$ticket[$i-1]=array(
					's_id'=>$s_id,
					'nums'=>$i
					);
				
			}
			 $this->db->insert_batch('ticket',$ticket);
		}
		else{
			echo $status;
		}
	}

	/**
	*	修改演出计划信息
	*/

	public function edit_select($id){

		//查询指定的演出计划的ID
		$this->db->where('s_id',$id);
		$result=$this->db->get('show_plan')->result_array();
		
		return $result;
	}

	public function edit($data){
		
		//
		$this->db->where('s_id',$data['s_id']);
		$status=$this->db->update('show_plan',$data['plan']);
	
		return $status;
	}


	/**
	*	删除演出计划信息
	*/
	public function delete($id){

		$status=$this->db->delete('show_plan',array('s_id'=>$id));

		return $status;
	}
}





?>