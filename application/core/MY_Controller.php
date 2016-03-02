<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{
	private  $is_load_captcha;
	public $aci_config;
	public $aci_status;
	public $all_module_menu;
	protected $page_data = array(
		'module_name' => '',
		'controller_name' => '',
		'method_name' => '',
	);


	function __construct(){
		parent::__construct();
		$this->load->driver('cache',array('adapter'=>'file'));
		$this->load->helper(array('global','url','string','text','language','auto_codeIgniter_helper','member'));

		$this->page_data['folder_name']=trim(substr($this->router->directory, 0, -1)) ;
		$this->page_data['controller_name']= trim($this->router->class);
		$this->page_data['method_name']= trim($this->router->method);
		$this->page_data['controller_info']= $this->config->item($this->page_data['controller_name'],'module');

		$this->config->load('aci');
		$this->aci_config = $this->config->item('aci_module');
		$this->aci_status = $this->config->item('aci_status');

		$_pageseo = $this->config->item($this->router->class,'seo');
		$_default_pageseo = $this->config->item('default','seo');
		$this->page_data['title'] = isset($_pageseo['title'])?$_pageseo['title'] : $_default_pageseo['title'];
		$this->page_data['keyword'] = isset($_pageseo['keywords'])?$_pageseo['keywords'] : $_default_pageseo['keywords'];
		$this->page_data['description'] = isset($_pageseo['decriptions'])?$_pageseo['decriptions'] : $_default_pageseo['decriptions'];
		unset($_pageseo);
		unset($_default_pageseo);
		//如果未安装，执行安装
		if(!$this->aci_status['installED']&&$this->page_data['folder_name']!="setup") die("未安装");

		$this->all_module_menu = getcache("cache_module_menu_all");
		$this->load->vars($this->page_data);
		$this->_check_module();

	}

	//检查模块
	function _check_module()
	{
		if(!$this->aci_status['installED']&&$this->page_data['folder_name']=="setup")  return true;
		$_aci_config = NULL;

		foreach($this->aci_config as $k=>$v)
		{
			if(strtolower(trim($v['modulePath']))==strtolower(trim($this->page_data['folder_name']) ))
			{
				if($v['moduleDetails'])
					foreach($v['moduleDetails'] as $moduleDetail)
					{
						if(strtolower(trim($moduleDetail['controller']))==strtolower(trim($this->page_data['controller_name'])))
						{
							if (preg_match("/^".strtolower(trim($moduleDetail['method']))."/i", strtolower(trim($this->page_data['method_name'])))) {

								$_aci_config = $v;
								break;
							}

						}
					}
			}
			if($_aci_config!=NULL)break;
		}


		if($_aci_config==NULL)exit($this->page_data['controller_name'].'模块:未在ACI中注册');
		if(!isset($_aci_config['works']))$this->showmessage('模块不存在，或未正确安装',base_url($this->page_data['folder_name'].'/moduleManage/index'));
		if(!$_aci_config['works'])$this->showmessage('模块已经被卸载，请重新加载',base_url($this->page_data['folder_name'].'/moduleManage/index'));
	}



	protected function showmessage($msg, $url_forward = '', $ms = 500, $dialog = '', $returnjs = '') {

		if($url_forward=='')$url_forward=$_SERVER['HTTP_REFERER'];
		$datainfo = array("msg"=>$msg,"url_forward"=>$url_forward,"ms"=>$ms,"returnjs"=>$returnjs,"dialog"=>$dialog);
		exit($msg);
	}

	protected function view($view_file,$sub_page_data=NULL,$autoload_header_footer_view= true)
	{
		$view_file= $this->page_data['folder_name'].DIRECTORY_SEPARATOR.$this->page_data['controller_name'].DIRECTORY_SEPARATOR.$view_file;

		$this->load->view(reduce_double_slashes($view_file),$sub_page_data);
	}

}

class Front_Controller extends MY_Controller{
	function __construct(){
		parent::__construct();
	}

	/**
	 * 自动模板调用
	 *
	 * @param $module
	 * @param $template
	 * @param $istag
	 * @return unknown_type
	 */
	protected function view($view_file,$page_data=array(),$cache=false)
	{
		$view_file= $this->page_data['folder_name'].DIRECTORY_SEPARATOR.$this->page_data['controller_name'].DIRECTORY_SEPARATOR.$view_file;
		if(isset($this->current_member_info))
		{
			$page_data['current_member_info']=$this->current_member_info;
			$page_data['current_member_id']=$this->current_member_id;//当前用户id
		}

		$page_data = array_merge($page_data,$this->page_data);

		$this->parser->parse($view_file, $page_data);
	}


	final private function _load_submenu($first_child_arr){
		if($first_child_arr&&str_exists($first_child_arr['method'],'go_')&& $first_child_arr['is_parent']){

			$arr_childid = explode(",",$first_child_arr['arr_childid']);
			$first_sub_child_arr = $this->Module_menu_model->get_one("parent_id = ".$arr_childid[1]);
			if($first_sub_child_arr) return $this->_load_submenu($first_sub_child_arr);

		}
	
		return base_url($first_child_arr['folder'].'/'.$first_child_arr['controller'].'/'.$first_child_arr['method']) ;
	}


	//重新加载所有缓存至文件
	final public function reload_all_cache(){

		$menus = array();
		$datas = $this->Module_menu_model->select('','*',10000,'list_order ASC,menu_id asc');
		$array = array();
		foreach ($datas as $r) {
			//$r['url'] =base_url($r['folder'].'/'.$r['controller'].'/'.$r['method']) ;
			$r['url'] = $this->_load_submenu($r);
			$arr_parentid =  $r['arr_parentid'];
			$arr_parentid = explode(",",$arr_parentid);
			
			$menus[$r['menu_id']] = $r;
			
		}

		setcache('cache_module_menu_all', $menus);


		$priv_arr = $this->Member_role_priv_model->select("");
		$new_priv_arr = array();
		if($priv_arr) {
			foreach($priv_arr as $k=>$v){
				$new_priv_arr[$v['role_id']][$v['menu_id']]=$v;
			}

			setcache('cache_member_role_priv', $new_priv_arr);

			$infos = $this->Member_role_model->select('',  '*', '', 'role_id ASC');
			
			$groups = array();

			foreach ($infos as $info){
				$role[$info['role_id']] = $info['role_name'];
				$groups[$info['role_id']]=$info;
			}

			setcache('cache_member_group', $groups);
		}

	}

}


class Member_Controller extends Front_Controller{
	public $module_info,$user_id,$group_id,$current_member_info,$menu_side_list,$cache_module_menu_arr,$current_role_priv_arr;
	function __construct(){
		parent::__construct();
		define("IN_MEMBER", TRUE);
		$this->module_info = $this->config->item('module');
		$this->cache_module_menu_arr =  getcache('cache_module_menu_all');
		$this->user_id = intval($this->session->userdata('user_id'));
		$this->user_name = $this->security->xss_clean($this->session->userdata('user_name'));
		$this->group_id = intval($this->session->userdata('group_id'));
		$_cache_member_role_priv_arr = getcache('cache_member_role_priv');

		$this->current_role_priv_arr = $this->group_id==SUPERADMIN_GROUP_ID?$this->cache_module_menu_arr:(isset($_cache_member_role_priv_arr[$this->group_id])?$_cache_member_role_priv_arr[$this->group_id]:NULL);

		$this->check_member();
		$this->check_priv();


	}

	/**
	 * 判断用户是否已经登陆
	 */
	protected function check_member() {

		$_datainfo = $this->Member_model->get_one(array('user_id'=>$this->user_id,'username'=>$this->user_name));
		
		if(!($this->page_data['folder_name']=='member'&&$this->page_data['controller_name']=='manage'&&$this->page_data['method_name']=='login')&&!$_datainfo)
		{
			$this->showmessage('请您重新登录',site_url('member/manage/login'));
			exit(0);
		}else if($_datainfo){
			
			$this->current_member_info = $_datainfo;
		}
	}

	protected function check_priv()
	{
		$cache_member_role_priv = getcache('cache_member_role_priv');
		if(strtolower($this->page_data['folder_name']) =='member' && strtolower($this->page_data['controller_name']) =='manage' && in_array(strtolower($this->page_data['method_name']), array('login', 'logout','manage'))) return true;
		if($this->group_id == SUPERADMIN_GROUP_ID) return true;
		if(preg_match('/^public_/',strtolower($this->page_data['method_name']))) return true;

		// 如果有缓存，缓存优先
		if($this->current_role_priv_arr)
		{
			$found=false;
			foreach($this->current_role_priv_arr as $k=>$v){
				if(strtolower($v['method'])==strtolower($this->page_data['method_name'])&&strtolower($v['controller'])==strtolower($this->page_data['controller_name'])&&strtolower($v['folder'])==strtolower($this->page_data['folder_name'])){
					$found=true;
					break;
				}
			}
			if(!$found) $this->showmessage('您没有权限操作该项','blank');
		}else{

			$r =$this->Member_role_priv_model->get_one(array('method'=>$this->page_data['method_name'],'controller'=>$this->page_data['controller_name'] ,'folder'=>$this->page_data['folder_name'],'role_id'=>$this->group_id ));
			if(!$r) $this->showmessage('您没有权限操作该项','blank');
		}

	}

	protected function showmessage($msg, $url_forward = '', $ms = 500, $dialog = '', $returnjs = '') {

		if($url_forward=='')$url_forward=$_SERVER['HTTP_REFERER'];

		$datainfo = array("msg"=>$msg,"url_forward"=>$url_forward,"ms"=>$ms,"returnjs"=>$returnjs,"dialog"=>$dialog);
		echo $this->load->view('member/header',NULL,true);
		echo $this->load->view('member/message',$datainfo,true);
		echo $this->load->view('member/footer',NULL,true);
		exit;
	}

	/**
	 * 自动模板调用
	 *
	 * @param $module
	 * @param $template
	 * @param $istag
	 * @return unknown_type
	 */
	protected function view($view_file,$sub_page_data=NULL,$cache=false)
	{
		$view_file= $this->page_data['folder_name'].DIRECTORY_SEPARATOR.$this->page_data['controller_name'].DIRECTORY_SEPARATOR.$view_file;

		if(isset($this->current_member_info))
		{
			$page_data['current_member_info']=$this->current_member_info;
		}
		$page_data['current_member_id']=$this->user_id;//当前用户id
		$page_data['current_member_groupid']=$this->group_id;

		//加截菜单

		$menu_data =$this->nav_menu(0,0,0);
		$page_data['sub_menu_data']= NULL;
		$page_data['current_pos']= "";

		$find_menu=false;
		$menu_id = 0;

		foreach($this->all_module_menu as $k=>$_value)
		{
			if($_value['folder']==trim($this->page_data['folder_name'])&&
				$_value['controller']==trim($this->page_data['controller_name'])&&
				$_value['method']==trim($this->page_data['method_name']))
			{

				$menu_id = $_value['menu_id'];
				if(!$find_menu){
					$arr_parentid = explode(",",$_value['arr_parentid']);
					if(count($arr_parentid)>=2) {
						$parent_id =$arr_parentid[1];
					}else{
						$parent_id =$_value['menu_id'];
					}

					$page_data['sub_menu_data']=$this->nav_menu($parent_id);

					foreach($page_data['sub_menu_data'] as $kk=>$vv){
						$page_data['sub_menu_data'][$kk]['sub_array'] = $this->nav_menu($vv['menu_id']);
					}

					$find_menu = true;
				}
			}
		}

		$page_data['menu_data']= $menu_data;
		$page_data['current_pos']=$this->current_pos($menu_id);
		$page_data['sub_page']=$this->load->view(reduce_double_slashes($view_file),$sub_page_data,true);

		$this->load->view('member/header',$page_data);
		$this->load->view('member/index',$page_data);
		$this->load->view('member/footer',$page_data);
	}



	/**
	 * 按父ID查找菜单子项
	 * @param integer $parentid   父菜单ID
	 * @param integer $with_self  是否包括他自己
	 */
	protected function nav_menu($parent_id, $with_self = 0, $show_where = 0) {
		$parent_id = intval($parent_id);

		$result =  array();
		if($this->all_module_menu)
		foreach($this->all_module_menu as $k=>$v){
			if($show_where==1&&strtolower($v['folder'])!="adminpanel")continue;
			if($show_where==0&&strtolower($v['folder'])=="adminpanel")continue;
			if($v['parent_id']==$parent_id&&$v['is_display']==1&&$v['is_side_menu']==1){
				$result[] = $v;
			}
		}

		if($with_self) {
			if(isset($this->all_module_menu[$parent_id])){
				$result = array_merge($this->all_module_menu[$parent_id],$result);
			}
		}

		if($this->group_id == SUPERADMIN_GROUP_ID) return $result;
		;
		//权限检查
		$array = array();
		foreach($result as $v) {
			$action = base_url($v['folder'].'/'.$v['controller'].'/'.$v['method']);
			$v['url'] = $action;
			if(preg_match('/^public_/',$v['method'])) {
				$array[] = $v;
			} else {
				$r = $this->Member_role_priv_model->get_one(array('folder'=> $v['folder'],'controller'=> $v['controller'] ,'method'=> $v['method'],'role_id'=>$this->group_id));
				if($r) $array[] = $v;
			}
		}
		return $array;
	}

	final  public function current_pos($id)
	{
		$str = '';
		if (isset($this->all_module_menu[$id])) {

			if ($this->all_module_menu[$id]['is_side_menu']) {
				$str = $this->current_pos($this->all_module_menu[$id]['parent_id']);

				if ($this->all_module_menu[$id]['is_parent'])
					$str = $str . '<li><a href="' . $this->all_module_menu[$id]['url'] . '">' . $this->all_module_menu[$id]['menu_name'] . '</a></li>';

				else
					$str = $str . '<li> ' . $this->all_module_menu[$id]['menu_name'] . ' </li>';

				return $str;
			}
		}
	}



}


class Admin_Controller extends Member_Controller{

	function __construct(){
		define("IN_ADMIN", TRUE);
		parent::__construct();
	}

	protected function showmessage($msg, $url_forward = '', $ms = 500, $dialog = '', $returnjs = '') {

		if($url_forward=='')$url_forward=$_SERVER['HTTP_REFERER'];

		$datainfo = array("msg"=>$msg,"url_forward"=>$url_forward,"ms"=>$ms,"returnjs"=>$returnjs,"dialog"=>$dialog);
		echo $this->load->view('adminpanel/header',NULL,true);
		echo $this->load->view('adminpanel/message',$datainfo,true);
		echo $this->load->view('adminpanel/footer',NULL,true);

		exit;
	}



	/**
	 * 判断用户是否已经登陆
	 */
	protected function check_member() {

	
		if(!$this->user_id&&!($this->page_data['folder_name']=='adminpanel'&&$this->page_data['controller_name']=='manage'&&$this->page_data['method_name']=='login'))
		{
			$this->showmessage('请您重新登录',site_url('adminpanel/manage/login'));
			exit(0);
		}

		$_datainfo = $this->Member_model->get_one(array('user_id'=>$this->user_id,'username'=>$this->user_name));
		if(!($this->page_data['folder_name']=='adminpanel'&&$this->page_data['controller_name']=='manage'&&$this->page_data['method_name']=='login')&&!$_datainfo)
		{
			$this->showmessage('请您重新登录',site_url('adminpanel/manage/login'));
			exit(0);
		}else if($_datainfo){
			
			$this->current_member_info = $_datainfo;
		}

	}

	protected function check_priv()
	{
		if($this->page_data['folder_name'] =='adminpanel' && $this->page_data['controller_name'] =='manage' && in_array($this->page_data['method_name'], array('login', 'logout','manage'))) return true;
		if($this->group_id == SUPERADMIN_GROUP_ID) return true;
		if(preg_match('/^public_/',strtolower($this->page_data['method_name']))||(strtolower($this->page_data['method_name'])=="go"&&strtolower($this->page_data['controller_name'])=="manage")) return true;

		// 如果有缓存，缓存优先
		if($this->current_role_priv_arr)
		{
			$found=false;
			foreach($this->current_role_priv_arr as $k=>$v){
	
				if(strtolower($v['method'])==strtolower($this->page_data['method_name'])&&strtolower($v['controller'])==strtolower($this->page_data['controller_name'])&&strtolower($v['folder'])==strtolower($this->page_data['folder_name'])){
					$found=true;
					break;
				}
			}
			if(!$found) $this->showmessage('您没有权限操作该项','blank');
		}else{

			$r =$this->Member_role_priv_model->get_one(array('method'=>$this->page_data['method_name'],'controller'=>$this->page_data['controller_name'] ,'folder'=>$this->page_data['folder_name'],'role_id'=>$this->group_id ));
			if(!$r) $this->showmessage('您没有权限操作该项','blank');
		}
	}

	/**
	 * 自动模板调用
	 *
	 * @param $module
	 * @param $template
	 * @param $istag
	 * @return unknown_type
	 */
	protected function admin_tpl($view_file,$page_data=false,$cache=false)
	{
		$view_file= $this->page_data['folder_name'].DIRECTORY_SEPARATOR.$this->page_data['controller_name'].DIRECTORY_SEPARATOR.$view_file;

		$this->load->view('adminpanel/header',$page_data);
		$this->load->view(reduce_double_slashes($view_file),$page_data);
		$this->load->view('adminpanel/footer',$page_data);
	}


	/**
	 * 自动模板调用
	 *
	 * @param $module
	 * @param $template
	 * @param $istag
	 * @return unknown_type
	 */
	protected function view($view_file,$sub_page_data=NULL,$cache=false)
	{
		$view_file= $this->page_data['folder_name'].DIRECTORY_SEPARATOR.$this->page_data['controller_name'].DIRECTORY_SEPARATOR.$view_file;
		
		if(isset($this->current_member_info))
		{
			$page_data['current_member_info']=$this->current_member_info;
		}
		$page_data['current_member_id']=$this->user_id;//当前用户id
		$page_data['current_member_groupid']=$this->group_id;

		//加截菜单

		$menu_data =$this->nav_menu(0,0,1);

		$page_data['sub_menu_data']= NULL;
		$page_data['current_pos']= "";

		$find_menu=false;
		$menu_id = 0;
		$third_menu_id = 0;//第三个菜单ID

		if($this->current_role_priv_arr)
		foreach($this->cache_module_menu_arr as $k=>$_value)
		{
			if(strtolower($_value['folder'])==strtolower(trim($this->page_data['folder_name']))&&
				strtolower($_value['controller'])==strtolower(trim($this->page_data['controller_name']))&&
				strtolower($_value['method'])==strtolower(trim($this->page_data['method_name'])))
			{


				$menu_id = $_value['menu_id'];
				if(!$find_menu&&isset($_value['arr_parentid'])){
					
					$arr_parentid = explode(",",$_value['arr_parentid']);
					if(count($arr_parentid)>=2) {
						$parent_id =$arr_parentid[1];
						$third_menu_id =isset($arr_parentid[3])? $arr_parentid[3]:$menu_id;
					}else{
						$parent_id =$_value['menu_id'];
					}

					$page_data['sub_menu_data']=$this->nav_menu($parent_id,0,1);


					foreach($page_data['sub_menu_data'] as $kk=>$vv){
						$page_data['sub_menu_data'][$kk]['sub_array'] = $this->nav_menu($vv['menu_id'],0,1);
					}

					$find_menu = true;
				}
			}
		}

		$page_data['menu_data'] = $sub_page_data['menu_data']= $menu_data;
		$page_data['current_pos']=$this->current_pos($menu_id);
		$page_data['third_menu_id']=$third_menu_id;
		$page_data['sub_page']=$this->load->view(reduce_double_slashes($view_file),$sub_page_data,true);
		$this->load->view('adminpanel/header',$page_data);
		$this->load->view('adminpanel/index',$page_data);
		$this->load->view('adminpanel/footer',$page_data);
	}
}

class API_Controller extends Front_Controller{

	public $POST,$GET;
	public $current_member_info;

	function __construct(){


		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) && (

					$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'POST' ||
					$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'DELETE' ||
					$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'PUT' )) {
				header('Access-Control-Allow-Origin: *');
				header("Access-Control-Allow-Credentials: true");
				header('Access-Control-Allow-Headers: X-Requested-With');
				header('Access-Control-Allow-Headers: access_token');
				header('Access-Control-Allow-Headers: Content-Type');
				header('Access-Control-Allow-Headers: Authorization');

				header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE'); 
				header('Access-Control-Max-Age: 86400');
			}
			exit;
		}

		parent::__construct();
		$this->load->library(array('encrypt'));
		define("IN_API", TRUE);

		$this->_check_token();
	}

	function _check_token(){

		$access_token = "";
		$headers = array();

		foreach ($_SERVER as $key => $value) {
		    if ('HTTP_' == substr($key, 0, 5)) {
		        $headers[strtoupper(substr($key, 5))] = $value;
		    }
		}

		if(isset($headers['ACCESS_TOKEN'])){

			$access_token = trim($headers['ACCESS_TOKEN']);
		}

		if($access_token=="")exit(json_encode(array('status_id'=>-99991,'tips'=>' 登录失败，缺少token')));
	
		$token =  str_replace("^^","+",$access_token);
		$token =  str_replace("~~","#",$token);
		//xfqJROfIE3lnauI1xvBuWFNcLpeDzMnWMVRvabsy8eBM++bQFUM9r+qLfZd9x0g9bsHW73eU+x7A70dqRmmL71hGTC\/yTCpHQk1prbQOg6sKZGwqMii24gukvxfrRQ4l
		

		$decode_token = $this->encrypt->decode($token);
	

		if($decode_token=="")exit(json_encode(array('status_id'=>-9998,'tips'=>' token 无效')));
		$decode_token_arr = explode("_",$decode_token);
		if(count($decode_token_arr)!=4)exit(json_encode(array('status_id'=>-9997,'tips'=>' token 无效')));
		$user_id =  $decode_token_arr[0];
		$user_name =  $decode_token_arr[2];
		$user_password =  $decode_token_arr[1];
		$user_login_time =  $decode_token_arr[3];
		$this->current_member_info = $this->Member_model->get_one(array('username'=>$user_name,'password'=>$user_password));
		if(!$this->current_member_info)exit(json_encode(array('status_id'=>-1000,'tips'=>' token 无效')));
		//
	}
}