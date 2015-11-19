<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile extends Admin_Controller {
	
	var $method_config;
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('Member_model'));
		$this->load->helper(array('global'));
		
		$this->method_config['upload'] = array(
										'thumb'=>array('upload_size'=>1024,'upload_file_type'=>'jpg|png|gif','upload_path'=>'uploadfile/user','upload_url'=>'/uploadfile/user/'),
										);
	}
	
	
	function change_pwd()
	{
		$datainfo = $this->Member_model->get_one(array('user_id'=>$this->user_id));
		if(!$datainfo)$this->Member_model('系统错误',base_url('/member/manage/logout'));
		if(isset($_POST['password1'])) {
			
			$password1 =  isset($_POST['password1'])?$_POST['password1']:exit(json_encode(array('status'=>false,'tips'=>'旧密码不能为空')));

			$password2 =  isset($_POST['password2'])?$_POST['password2']:exit(json_encode(array('status'=>false,'tips'=>'新密码不能为空')));
			$password3 =  isset($_POST['password3'])?$_POST['password3']:exit(json_encode(array('status'=>false,'tips'=>'新密码不能为空')));


			if(trim($password2)=="")exit(json_encode(array('status'=>false,'tips'=>'新密码不能为空')));

			if($password2!=$password3)exit(json_encode(array('status'=>false,'tips'=>'两次密码不一致')));

			
			
			$password1 = md5(md5($password1.$datainfo['encrypt']));
			$c= $this->Member_model->count(array('user_id'=>$this->user_id,'password'=>$password1));
			if(intval($c)!=1)exit(json_encode(array('status'=>false,'tips'=>'旧密码错误')));

			
			$password2 = md5(md5($password2.$datainfo['encrypt']));
			$status=$this->Member_model->update(array('password'=>$password2),array('user_id'=>$this->user_id));
			if($status)
			{
				$this->session->sess_destroy();
				exit(json_encode(array('status'=>true,'tips'=>'密码修改成功，请重新登录')));
			}else 
			{
				exit(json_encode(array('status'=>false,'tips'=>'密码修改失败')));
			}
		}else 
		$this->view('change_pwd',array('datainfo'=>$datainfo,'require_js'=>true));
	}
	
}