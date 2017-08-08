<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
* 后台管理主页
*/
class Index extends CI_Controller
{
	

	//进入影厅
	public function index(){

		// $this->load->view('admin/index.html');
		$this->load->view('admin/add_YT.html');
	}

	//进入剧目
	public function show_hall(){
		$this->load->view('admin/jumu.html');
	}

	//进入演出计划
	public function jumu(){
		$this->load->view('admin/jihua.html');
	}

	//进入票务
	public function piaowu(){
		$this->load->view('admin/piaowu.html');
	}

	//进入用户
	public function yonghu(){
		$this->load->view('admin/yonghu.html');
	}
}




?>