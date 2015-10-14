<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Captcha_model extends Base_Model {
	public function __construct() {
		$this->table_name = 'captcha';
		parent::__construct();
	}
	
	function save_captcha($data) {
		$this->insert($data);
	}
	
	function delete_old_captcha($expiration) {
	    $query = $this->delete( array("captcha_time"=>$expiration));
	}
	
	function verify_captcha($word,$ip_address,$captcha_time) {
		
	    $c = $this->count(array("word"=>$word,"ip_address"=>$ip_address,"captcha_time > "=>$captcha_time));

	    if($c == 1) {
	    	return TRUE;
	    }
	    return FALSE;
	}
	
}