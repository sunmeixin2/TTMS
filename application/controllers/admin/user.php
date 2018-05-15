<?php  


/**
* 	用户管理页面
*/
class User extends CI_Controller
{
	

	/*查看用户信息*/
	public function index(){

		$this->load->model('admin/user_model','user');
		$data['user']=$this->user->select();

		$this->load->view('web/head.html');
		$this->load->view('web/yonghu.html',$data);
		$this->load->view('web/foot.html');
		
	}

	// 添加影厅

	public function user_add(){
		
		$this->load->view('web/head.html');
		$this->load->view('web/add_yonghu.html');
		$this->load->view('web/foot.html');
		

	}

	public function user_add_action(){

		
		$data=array(

			'account'=>$this->input->post('account'),
			'u_name'=>$this->input->post('u_name'),
			'type'=>$this->input->post('type'),
			'rank'=>$this->input->post('rank')

			);
		$this->load->model('admin/user_model','user');
		$this->user->add($data);

		success('admin/user/index','用户信息添加成功！');
	}


	/*编辑用户信息*/
	public function edit_user(){
		$uid = $this->uri->segment(4);
		//echo $uid;
		$this->load->model('admin/user_model','user');
		$data['user'] = $this->user->edit_select($uid);
		//p($data);die();
		$this->load->view('web/head.html');
		$this->load->view('web/xiugai_yonghu.html',$data);
		$this->load->view('web/foot.html');
		
	}

	/*编辑动作*/
	public function edit_user_action(){

		
		$uid = $this->input->post('uid');
		$rank = $this->input->post('rank');
		$type=$this->input->post('type');
		$account=$this->input->post('account');
		$u_name=$this->input->post('u_name');
		$data = array(
			'user'=>array
			(
				'rank'=>$rank,
				'type'=>$type,
				'account'=>$account,
				'u_name'=>$u_name
			)
		);

		$data['uid']=$uid;

		//var_dump($data);exit();

		$this->load->model('admin/user_model','user');
		$data = $this->user->edit($data);
		success('admin/user/index','用户信息修改成功！');
	}


	//删除用户信息
	public function del_user(){

		$h_id = $this->uri->segment(4);

		$this->load->model('admin/user_model','user');
		$this->user->delete($h_id);
		success('admin/user/index','用户信息删除成功！');
	}
}


?>