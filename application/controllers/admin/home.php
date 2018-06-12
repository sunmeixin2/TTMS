<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
* 	影厅管理界面
*/
class Home extends CI_Controller
{
	/*查看影厅信息*/
	public function index(){
		
		$this->load->model('admin/show_hall_model','show_hall');
		$data['show_hall'] = $this->show_hall->check();

		//$this->load->view('web/head.html');
		$this->load->view('web/yingting.html',$data);
		$this->load->view('web/foot.html');
	}

	// 添加影厅
	public function add_YT(){
	
		//$this->load->view('web/head.html');
		$this->load->view('web/add_YT.html');
		$this->load->view('web/foot.html');
		

	}


	/*添加影厅动作*/
	public function add(){

		$data = array(
				'h_name' => $this->input->post('h_name'),
				'rows' => $this->input->post('rows'),
				'cols' => $this->input->post('cols')
			);
		
		$this->load->model('admin/show_hall_model','show_hall');
		$this->show_hall->add_YT($data);
		
		//添加成功提示函数
		success('admin/home/index','影厅添加成功~~^v^~');
		
	}

	

	/*编辑影厅信息*/
	public function edit(){

		//获取指定影厅的ID
		$h_id = $this->uri->segment(4);

		$this->load->model('admin/show_hall_model','show_hall');
		$data['show_hall'] = $this->show_hall->check_YT($h_id);
		
		//$this->load->view('web/head.html');
		$this->load->view('web/xiugai_YT.html',$data);
		$this->load->view('web/foot.html');
	}


	/*编辑动作*/
	public function edit_YT(){

		
		$h_id = $this->input->post('h_id');
		$h_name = $this->input->post('h_name');
		$cols = $this->input->post('cols');
		$rows = $this->input->post('rows');
		$data = array(
			'h_name'=>$h_name,
			'rows'=>$rows,
			'cols'=>$cols
			);

		$this->load->model('admin/show_hall_model','show_hall');
		$data = $this->show_hall->update($h_id,$data);

		//添加成功提示函数
		success('admin/home/index','影厅修改成功 ~~^v^~');
		
	}


	/*删除影厅*/
	public function del_YT(){

		$h_id = $this->uri->segment(4);
		$this->load->model('admin/show_hall_model','show_hall');
		$this->show_hall->delete($h_id);
		
		//添加成功提示函数
		success('admin/home/index','影厅删除成功 ~~^v^~');
	}

	
}