<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends Front_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->view('index',array('date'=>date('Y-m-d H:i:s')));
	}
	
	
}