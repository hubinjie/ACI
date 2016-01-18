<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends Front_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{

		$cache_chomd = octal_permissions(fileperms(APPPATH.'cache'));
		
		$this->reload_all_cache();//更新全局菜单缓存，可以去掉这行
		$this->view('index',array('date'=>date('Y-m-d H:i:s'),'cache_chomd'=>$cache_chomd));
	}
	
	
}