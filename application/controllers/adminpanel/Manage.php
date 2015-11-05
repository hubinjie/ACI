<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manage extends Admin_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('Times_model'));
	}

	function cache(){
		$this->reload_all_cache();
		$this->showmessage('全局缓存成功',site_url('adminpanel'));
	}

	function go($id=0){
		if($id==0) exit() ;
		if(isset($this->current_role_priv_arr[$id])){

			$arr = $this->cache_module_menu_arr[$id];
			if(!isset($arr))exit();
			$arr_parentid = explode(",",$arr['arr_parentid']);

			if(count($arr_parentid)>2) redirect( base_url($arr['folder'].'/'.$arr['controller'].'/'.$arr['method']));
			else{
				foreach($this->cache_module_menu_arr as $k=>$v){
					if($v['parent_id']==$id){

						if(isset($this->current_role_priv_arr[$v['menu_id']])){
							redirect(base_url($v['folder'].'/'.$v['controller'].'/'.$v['method']));
							break;
						}
						
					}
				}
			}
		}
		exit();
	}
	
	function index()
	{
			$this->view('index',array('require_js'=>true));
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('adminpanel'));
	}
	
	function login()
	{
		if(isset($_POST['username'])) {
			$username = isset($_POST['username']) ? trim($_POST['username']) : exit(json_encode(array('status'=>false,'tips'=>' 用户名不能为空')));
			if($username=="")exit(json_encode(array('status'=>false,'tips'=>' 用户名不能为空')));
			$this->load->model('Times_model');
			//密码错误剩余重试次数
			$rtime = $this->Times_model->get_one(array('username'=>$username,'is_admin'=>1));
			$maxloginfailedtimes = 5;
			if($rtime)
			{
				if($rtime['failure_times'] > $maxloginfailedtimes) {
					$minute = 60-floor((SYS_TIME-$rtime['logintime'])/60);
					exit(json_encode(array('status'=>false,'tips'=>' 密码尝试次数过多，被锁定一个小时')));
				}
			}

			//查询帐号，默认组1为超级管理员
			$r = $this->Member_model->get_one(array('username'=>$username));
			if(!$r) exit(json_encode(array('status'=>false,'tips'=>' 用户名或密码不正确')));
			$password = md5(md5(trim($_POST['password']).$r['encrypt']));

			$ip = $this->input->ip_address();
			if($r['password'] != $password) {
				if($rtime && $rtime['failure_times'] < $maxloginfailedtimes) {
					$times = $maxloginfailedtimes-intval($rtime['failure_times']);
					$this->Times_model->update(array('login_ip'=>$ip,'is_admin'=>1,'failure_times'=>' +1'),array('username'=>$username));
				} else {
					$this->Times_model->delete(array('username'=>$username,'is_admin'=>1));
					$this->Times_model->insert(array('username'=>$username,'login_ip'=>$ip,'is_admin'=>1,'login_time'=>SYS_TIME,'failure_times'=>1));
					$times = $maxloginfailedtimes;
				}

				exit(json_encode(array('status'=>false,'tips'=>' 密码错误您还有'.$times.'机会')));
			}

			$this->Times_model->delete(array('username'=>$username));
			if($r['is_lock'])exit(json_encode(array('status'=>false,'tips'=>' 您的帐号已被锁定，暂时无法登录')));
			$this->Member_model->update(array('last_login_ip'=>$ip,'last_login_time'=>date('Y-m-d H:i:s')),array('user_id'=>$r['user_id']));
			$this->session->set_userdata('user_id',$r['user_id']);
			$this->session->set_userdata('user_fullname',$r['fullname']);
			$this->session->set_userdata('user_name',$username);
			$this->session->set_userdata('group_id',$r['group_id']);

			exit(json_encode(array('status'=>true,'tips'=>' 登录成功','next_url'=>site_url($this->page_data['folder_name']))));

		}else {

			$this->admin_tpl('login',array('require_js'=>true));
		}
	}

	
}