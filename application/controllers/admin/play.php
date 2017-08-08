<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
* 剧目管理信息
*/
class Play extends CI_Controller
{

	
	/**
	*	载入所有剧目信息
	*/
	public function index(){
		//$this->output->enable_profiler(true);
	
		//$this->load->view('web/index.html');
		// //从model层获取所有的剧目信息
		$this->load->model('admin/play_model','play');
		$info['play_info']=$this->play->select();
		//var_dump($info);exit;
		//将所有的剧目信息传到view层
		$this->load->view('web/jumu.html',$info);
	}



	/**
	*	添加剧目信息
	*/

	public function play_add(){

		$this->load->view('web/add_jumu.html');

	}
	public function play_add_action(){

		//接收上传的文件（海报）

		//参数设置
		$config['upload_path'] = './uploads';		//文件上传的位置  根目录下的uploads目录
		$config['allowed_types'] = 'gif|jpg|png|jpeg';		//允许上传的文件MIME类型
		$config['max_size'] = 2000;						//上传文件大小的最大值
		// $config['max_width'] = 1024;					//图片的最大宽度
		// $config['max_height'] = 768;					///图片的最大高度
		$config['file_name'] = time();			//重命名上传的文件

		$this->load->library('upload',$config);			//初始化文件上传类

		  if ( ! $this->upload->do_upload('play_file'))			//根据设置的参数上传文件
        {
            $error = array('error' => $this->upload->display_errors());		//获取错误信息

            var_dump($error);exit();
            //$this->load->view('admin/error.html',$error);		//将错误信息发送到view页面
        }
        else
        {
            $pic = array('upload_data' => $this->upload->data());		//获取文件上传成功后文件的信息

            $poster=$pic['upload_data']['orig_name'];
        }


		//接收表单传递过来的数据
		$name=$this->input->post('p_name');
		$type=$this->input->post('type');
		$time=$this->input->post('time');
		$actor=$this->input->post('actor');
		$director=$this->input->post('director');
		$up_date=$this->input->post('up_date');
		$details=$this->input->post('details');
		$like=$this->input->post('like'); 

		$data['play'] = array('p_name' => $name, 	
				      'p_type' => $type,
				      'time' => $time,
				      'actor' => $actor,
				      'director' => $director,
				      'up_date' => $up_date,
				      'details' => $details,
				      'like' => $like
				      );
		 $data['poster']=$poster;
		//var_dump($data);exit;
		//将剧目信息传递到model层
		$this->load->model('admin/play_model','play');
		$this->play->add($data);
		
		//添加成功提示函数
		success('admin/play/index','剧目添加成功~~^v^~');
	}


	/**
	*	修改剧目信息
	*/

	public function play_edit(){

		//获取需要修改的演出计划的ID
		$p_id=$this->uri->segment(4);
		//$p_id=1;

		$this->load->model('admin/play_model','play');
		$info['data']=$this->play->edit_select($p_id);

		//var_dump($info);exit();
		$this->load->view('web/xiugai_jumu.html',$info);

	}

	public function play_edit_action(){

		//接收上传的文件（海报）

		//参数设置
		// $config['upload_path'] = './uploads';		//文件上传的位置  根目录下的uploads目录
		// $config['allowed_types'] = 'gif|jpg|png|jpeg';		//允许上传的文件MIME类型
		// $config['max_size'] = 100;						//上传文件大小的最大值
		// $config['max_width'] = 1024;					//图片的最大宽度
		// $config['max_height'] = 768;					///图片的最大高度
		// $config['file_name'] = time();			//重命名上传的文件

		// $this->load->library('upload',$config);			//初始化文件上传类

		//   if ( ! $this->upload->do_upload('play_file'))			//根据设置的参数上传文件
  //       {
  //           $error = array('error' => $this->upload->display_errors());		//获取错误信息

  //           var_dump($error);exit();
  //           //$this->load->view('admin/error.html',$error);		//将错误信息发送到view页面
  //       }
  //       else
  //       {
  //           $pic = array('upload_data' => $this->upload->data());		//获取文件上传成功后文件的信息

  //           $poster=$pic['upload_data']['orig_name'];
  //       }


		//接收表单传递过来的数据
		$p_id=$this->input->post('p_id');
		$name=$this->input->post('p_name');
		$type=$this->input->post('type');
		$time=$this->input->post('time');
		$actor=$this->input->post('actor');
		$director=$this->input->post('director');
		$up_date=$this->input->post('up_date');
		$details=$this->input->post('details');
		$like=$this->input->post('like'); 

		$data['play'] = array(

					  'p_name' => $name, 	
				      'p_type' => $type,
				      'time' => $time,
				      'actor' => $actor,
				      'director' => $director,
				      'up_date' => $up_date,
				      'details' => $details,
				      'like' => $like

				      );
		
		$data['p_id']=$p_id;

		//将剧目信息传递到model层
		$this->load->model('admin/play_model','play');
		$this->play->edit($data);

		//添加成功提示函数
		success('admin/play/index','剧目修改成功~~^v^~');
	}


	/**
	*	删除剧目信息
	*/

	public function play_delete(){

		//获取需要删除的剧目的ID
		$p_id=$this->uri->segment(4);

		$this->load->model('admin/play_model','play');
		$status=$this->play->delete($p_id);
		//添加成功提示函数
		success('admin/play/index','剧目删除成功~~^v^~');
	}

}





?>