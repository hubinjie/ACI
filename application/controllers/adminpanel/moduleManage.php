<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
define('NOT_CONVERT',true);
class ModuleManage extends Admin_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('Module_menu_model'));
		$this->load->helper(array('file','auto_codeIgniter'));
	}
	
	function index()
	{
		$this->view('index',array('require_js'=>true,'datalist'=>$this->aci_config));
	}
	
	
}