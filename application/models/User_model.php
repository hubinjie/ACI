<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
*/
class User_model extends Member_model {
    public function __construct() {
        parent::__construct();
    }

    

    /**
     * 用户弹窗
     * @return array
     */
    function user_window_datasource($where='',$limit = '', $order = '', $group = '', $key=''){
    	
    	$datalist = $this->select($where,'user_id,username',$limit,$order,$group,$key);
        return $datalist;
    }

    

}