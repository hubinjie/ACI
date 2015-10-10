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
 * 项目名称：楼栋房间信息 MODEL
 * 版本号：1 
 * 最后生成时间： 
 */
class Loudongfangjian_model extends Base_Model {
	
    var $page_size = 10;
    function __construct()
	{
    	$this->db_tablepre = 't_aci_';
    	$this->table_name = 'loudongfangjian';
		parent::__construct();
	}
    
    /**
     * 初始化默认值
     * @return array
     */
    function default_info()
    {
    	return array(
		'loudongfangjian_id'=>0,
		'loudong_id'=>'',
		'loudongfangjian_name'=>'',
		'loudongfangjian_area'=>'',
		'created'=>'',
		);
    }
    
    /**
     * 安装SQL表
     * @return void
     */
    function init()
    {
    	$this->query("CREATE TABLE  IF NOT EXISTS `t_aci_loudongfangjian`
(
`loudong_id` varchar(250) DEFAULT NULL COMMENT '楼栋',
`loudongfangjian_name` varchar(250) DEFAULT NULL COMMENT '房间号',
`loudongfangjian_area` int(11) DEFAULT '0' COMMENT '房间面积',
`created` varchar(50) DEFAULT NULL COMMENT '创建时间',
`loudongfangjian_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`loudongfangjian_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
");
    }
    
        }

// END loudongfangjian_model class

/* End of file loudongfangjian_model.php */
/* Location: ./loudongfangjian_model.php */
?>