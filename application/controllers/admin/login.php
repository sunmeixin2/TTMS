<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
* 	登录页面
*/
class Login extends CI_Controller
{

	/**
	*	进入登录界面
	*/

	public function index(){
		// 验证码

		$this->load->helper('captcha');		//验证码辅助函数
		$this->load->library('session');	//载入session验证类

		//设置验证码的内容
		$speed="0123456789";
		$word='';
		for($i=0;$i<4;$i++){
			$word .=$speed[mt_rand(0,strlen($speed)-1)];
		}

		//配置项
		$vals=array(
			'word' => $word,
			'img_path'=>'./captcha/',		//验证码保存路径
			'img_url'=> base_url().'captcha/',		//验证码图片URL
			//'font_path'=>'',		//验证码上字体
			'img_width'=>100,		//验证码图片宽度
			'img_height'=>25,		//验证码图片高度
			'expiration'=> 120 ,		//验证码图片删除时间
			'word_length'=> 4,		//验证码长度
			'font_size'=>16 ,			//验证码字体大小
			'img_id'=>'iamge_id' ,			//将会设置为图片验证码的ID   ？？
			'pool' => '0123456789zxcvbnmasdfghjklqwertyuiopZXCVBNMASDFGHJKLQWERTYUIOP',		// ？？
			'colors'=>array(
				'background'=>array(255,255,255),	//图片背景颜色
				'border'=>array(120,120,120),	//边框颜色
				'text'=>array(0,0,0),	//字颜色
				'grid'=>array(123,120,120)		// ??
				)
			);

		//生成验证码  返回一个数组
		$cap = create_captcha($vals);
		$data['captcha']=$cap['image'];

		//验证码设为session
		$_SESSION['captcha']=strtoupper( $cap['word'] );

		
		$this->load->view('web/login.html',$data);
	}

	/**
	*	处理用户提交的登录信息
	*/

	public function action(){
	
		$account=$this->input->post('account');
		$passwd=$this->input->post('passwd');
		$captcha=$this->input->post('captcha');
		echo '<p>'.$account.'</p>';
		echo '<p>'.$passwd.'</p>';
		echo '<p>'.$captcha.'</p>';


		
	}
}



?>