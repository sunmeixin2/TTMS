<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


/**
*  剧目信息处理页面
*/
class Play_model extends CI_Model
{

	/**
	*	查询所有的剧目信息
	*/

	public function select(){

		$data=$this->db->select('play.*,poster')
				->from('play')
				->join('picture','play.p_id=picture.p_id','right')
				->get()->result_array();
		return $data;
	}


	/**
	*	添加剧目信息
	*/

	public function add($data){
	
		//将剧目信息添加到play表中
		$status1=$this->db->insert('play',$data['play']);

		//获取新插入剧目信息的ID
		$id=$this->db->query("select last_insert_id()")->result_array();	//返回一个数组类型的数据
		
		$value=array(
					'p_id'=>$id[0]['last_insert_id()'],
					'poster'=>$data['poster']
				);
		
		//将剧目对应的海报添加到picture表中
		$status2=$this->db->insert('picture',$value);
		// if($status1 && $status2)
		// 	var_dump($status1);
		// 	//return $status1;
		// else
		// 	echo false;
		// 	//return false;

	}


	/**
	*	修改剧目信息
	*/

	public function edit_select($id){

		$data=$this->db->select('play.*,poster')
				->from('play')
				->join('picture','play.p_id=picture.p_id','left')
				->where("play.p_id",$id)
				->get()->result_array();

		return $data;
	}

	public function edit($data){

		
		//修改paly表信息
		$this->db->where('p_id',$data['p_id']);
		$status1=$this->db->update('play',$data['play']);

		// $value=array(
		// 	'poster'=>$data['poster']
		// 	);

		// //修改picture表信息
		// $this->db->where('p_id',$data['p_id']);
		// $status2=$this->db->update('picture',$value);
		// if($status1 && $status2)
		// 	return $status;
		// else
		// 	return false; 
	}


	/**
	*	删除剧目信息
	*/

	public function delete($id){

		//先删除picture表剧目对应的poster
		$status1=$this->db->delete('picture',array('p_id'=>$id));

		//删除play表对应的剧目信息
		$status2=$this->db->delete('play',array('p_id'=>$id));

		// if($status1 && $status2)
		// 	var_dump($status1);
		// 	//return $status1;
		// else
		// 	echo false;
		// 	//return false;
	}
}


?>