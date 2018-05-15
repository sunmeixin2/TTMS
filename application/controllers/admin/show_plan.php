<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
*   演出计划管理页面
*/
class Show_plan extends CI_Controller
{

	/**
	*	载入所有演出计划信息
	*/

	public function index(){		

		//获取演出计划表信息
		$this->load->model('admin/show_plan_model','show_plan'); 
		$info['show_plan']=$this->show_plan->select();
		
		//修改上映时间和结束时间为日期格式
		$i=0;
		foreach ($info['show_plan'] as $val) {
			
			$info['show_plan'][$i]['up_time']=date('Y-m-d H:i',($val['up_time']));
			$info['show_plan'][$i]['down_time']=date('Y-m-d H:i',($val['down_time']));
			$i++;

		}
		//var_dump($info['show_plan']);exit();
		//将信息传递给view层
		$this->load->view('web/head.html');
		$this->load->view('web/jihua.html',$info);
		$this->load->view('web/foot.html');
		

	}


	/**
	*	添加演出计划
	*/

	public function add(){

		$this->load->model('admin/show_plan_model','show_plan');
		$info=$this->show_plan->add_check();
		$this->load->view('web/head.html');
		$this->load->view('web/add_jihua.html',$info);
		$this->load->view('web/foot.html');
		
	}

	public function show_add(){

		//接收表单传过来的数据
		$data = array(
				
					  'p_id' => $this->input->post('p_id'), 
					  'h_id' => $this->input->post('h_id'),
					  'up_time' => strtotime( $this->input->post('up_time')),
					  'down_time' => strtotime( $this->input->post('down_time')),
					  'price' =>$this->input->post('price')
				);
	
		//将表单中的数据载入到model层
		$this->load->model('admin/show_plan_model','show_plan');
		$status=$this->show_plan->add($data);
		
		//添加演出计划成功
		success('admin/show_plan/index','演出计划添加成功~~^v^~');
	}


	/**
	*	修改演出计划  ok
	*/

	public function show_edit(){

		//获取需要修改的演出计划的ID
		$s_id=$this->uri->segment(4);

		//var_dump($s_id);exit();

		$this->load->model('admin/show_plan_model','show_plan');
		$info['data']=$this->show_plan->edit_select($s_id);
		
		//修改上映时间和结束时间为日期格式
		$info['data'][0]['up_time']=date('Y-m-d H:i',$info['data'][0]['up_time']);
		$info['data'][0]['down_time']=date('Y-m-d H:i',$info['data'][0]['down_time']);

		$this->load->view('web/head.html');
		$this->load->view('web/xiugai_jihua.html',$info);
		$this->load->view('web/foot.html');
		

	}

	public function show_edit_action(){
		
		//接收表单传过来的数据
		$data = array(
			'plan'=>array(
					  'p_id' => $this->input->post('p_id'), 
					  'h_id' => $this->input->post('h_id'),
					  'up_time' => strtotime( $this->input->post('up_time')),
					  'down_time' => strtotime( $this->input->post('down_time')),
					  'ticket_num' =>$this->input->post('ticket_num')
					  )
				);
		$data['s_id']=$this->input->post('s_id');
		// var_dump($data);exit();
		//表单中的数据载入到model层
		$this->load->model('admin/show_plan_model','show_plan');
		$status=$this->show_plan->edit($data);

		//修改成功
		success('admin/show_plan/index','演出计划修改成功~~^v^~');
	}


	/**
	*	删除演出计划
	*/
	public function show_delete(){

		//获取需要删除的演出计划的ID
		$s_id=$this->uri->segment(4);

		$this->load->model('admin/show_plan_model','show_plan');
		$status=$this->show_plan->delete($s_id);

		//删除演出计划成功
		success('admin/show_plan/index','演出计划删除成功~~^v^~');
	}



}

?>