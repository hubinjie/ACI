<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Times_model extends Base_Model {
	public function __construct() {
		$this->table_name = 'times';
		parent::__construct();
	}
}