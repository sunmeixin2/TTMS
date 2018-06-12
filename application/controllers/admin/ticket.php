<?php  defined('BASEPATH') OR exit('No direct script access allowed');


/**
* 票务管理页面
*/
class Ticket extends CI_Controller
{


	/*
	*	在票务管理页面 载入所有的演出计划的信息
	*/

	public function index(){
		//获取演出计划表信息
		$this->load->model('admin/ticket_model','ticket'); 
		$info['ticket']=$this->ticket->select();
		
		//修改上映时间和结束时间为日期格式
		$i=0;
		foreach ($info['ticket'] as $val) {
			 
			$info['ticket'][$i]['up_time']=date('Y-m-d H:i',($val['up_time']));
			//$info['show_plan'][$i]['down_time']=date('Y-m-d H:i',($val['down_time']));
			$i++;

		}
		//var_dump($info);exit();
		// $this->load->view('web/head.html');
		$this->load->view('web/piaowu.html',$info);
		$this->load->view('web/foot.html');
		

	}



	//根据演出计划进入对应的选座购票页面

	public function buy_ticket(){

		$s_id=$this->uri->segment(4);
	

		//获取演出计划表信息
		$this->load->model('admin/ticket_model','ticket'); 
		$info=$this->ticket->check($s_id);
		$info['s_id']=$s_id;
		$info['show_plan'][0]['up_time']=date("Y-m-d H:i",$info['show_plan'][0]['up_time']);
		 //var_dump($info);exit();

		 //echo json_encode($info['tickets']);
		
		$this->load->view('web/goupiao.html',$info);
	}

	//ajax传输已经售出的座位信息
	public function buy(){

		$s_id=$_POST['s_id'];

		// var_dump($s_id);exit();
		//获取演出计划表信息
		$this->load->model('admin/ticket_model','ticket'); 
		$info=$this->ticket->check_ticket($s_id);

		//var_dump($info);exit();

		echo json_encode($info);

	}


	/**
	*	处理用户提交的座位信息
	*/

	public function tickets()
	{

		$t=$_POST['ticket'];
		$s_id=$_POST['s_id'];
		
		$i=0;
		foreach ($t as $v) {
			$i++;
			$temp=explode(' ', $v);
			$data[$i]=($temp[0]-1)*10+$temp[1];
		}
		 //var_dump($data);

		//载入用户选中的座位信息  为用户提交表单
		$this->load->model('admin/ticket_model','ticket');
		$status=$this->ticket->ticket_action($data,$s_id);
		//$data=1;
		// $d[]=$data;
	// 	var_dump($status);
	// 	if($status==true){
	// 		success('admin/ticket/index',"您已购票成功(●'◡'●)ﾉ♥");
	// 		// success('admin/play/index','剧目添加成功~~^v^~');
	// 	}else{
	// 		error("万般无奈，您的购票失败啦（┭┮﹏┭┮）");
	// 	}
	// success('admin/play/index','剧目添加成功~~^v^~');
		echo json_encode($status);

	}


}

?>