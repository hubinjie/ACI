<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
*/
class Role_model extends Member_role_model {
    public function __construct() {
        parent::__construct();
    }

    function group_dropdown_datasource($where='',$limit = '', $order = '', $group = '', $key=''){
    	$datalist = $this->select($where,'role_id,role_name',$limit,$order,$group,$key);
        return $datalist;
    }

}