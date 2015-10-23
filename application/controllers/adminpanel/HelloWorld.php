<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class HelloWorld extends Admin_Controller {
	
	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$this->view('index',array('require_js'=>true));
	}
}