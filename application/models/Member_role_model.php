<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * AutoCodeIgniter.com
 *
 * 基于CodeIgniter核心模块自动生成程序
 *
 * 源项目		AutoCodeIgniter
 * 作者：		AutoCodeIgniter.com Dev Team
 * 版权：		Copyright (c) 2015 , AutoCodeIgniter com.
 * 项目名称：用户组管理 MODEL
 * 版本号：1 
 * 最后生成时间：2015-01-21 10:08:51 
 */
class Member_role_model extends Base_Model {
	
    var $page_size = 10;
    function __construct()
	{
    	$this->db_tablepre = 't_sys_';
    	$this->table_name = 'member_role';
		parent::__construct();
	}
    
    /**
     * 安装SQL表
     * @return void
     */
    function init()
    {
    	$this->query("CREATE TABLE `t_aci_role`
(
`role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`role_name` varchar(250) DEFAULT NULL COMMENT '用户组名',
`description` text COMMENT '用户组描述',
PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
");
    }

    function default_info(){
        return array('role_id'=>0,'role_name'=>'','description'=>'');
    }
}

// END role_model class

/* End of file role_model.php */
/* Location: ./role_model.php */
?>