<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Member_model extends Base_Model {

	var $page_size = 10;
	public function __construct() {
		$this->table_name = 'member';
		parent::__construct();
	}
	
	function check_username_exists($username)
	{
		$c = $this->count("username ='".$username."' or email = '".$username."'");
		return $c;
	}
	
	function quick_register($username,$password,$encrypt='',$mobileno='')
	{
		if(!$this->check_username_exists($username))
		{
			$password = md5(md5($password.$encrypt));
			$newid = $this->insert(array('group_id'=>REGISTER_GROUP_ID,'mobile'=>$mobileno,'username'=>$username,'password'=>$password,'reg_ip'=>$this->input->ip_address(),'reg_time'=>date('Y-m-d H:i:s'),'encrypt'=>$encrypt,'last_login_ip'=>$this->input->ip_address(),'last_login_time'=>date('Y-m-d H:i:s'),'created'=>date('Y-m-d H:i:s'),'modified'=>date('Y-m-d H:i:s'),'is_seller'=>0));
			
			return $newid;
		}
		return 0;
	}
	
	function quick_changpwd($username,$password,$encrypt='',$mobileno='')
	{
		if($this->check_username_exists($username))
		{
			$password = md5(md5($password.$encrypt));
			$status = $this->update(array('encrypt'=>$encrypt,'password'=>$password,'modified'=>date('Y-m-d H:i:s')),array('username'=>$username));
			
			return $status;
		}
		return 0;
	}
	
	function default_info(){
		return array(
					'user_id'=>0,
					'username'=>'',
					'email'=>'',
					'password'=>'',
					'mobile'=>'',
					'fullname'=>'',
					'avatar'=>'nopic.gif',
					'group_id'=>0,
					'is_lock'=>false,
					);
	}
	
}
