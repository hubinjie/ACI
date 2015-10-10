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
 * 项目名称：楼栋信息 MODEL
 * 版本号：1 
 * 最后生成时间： 
 */
class Loudong_model extends Base_Model {
	
    var $page_size = 10;
    function __construct()
	{
    	$this->db_tablepre = 't_aci_';
    	$this->table_name = 'loudong';
		parent::__construct();
	}
    
    /**
     * 初始化默认值
     * @return array
     */
    function default_info()
    {
    	return array(
		'loudong_id'=>0,
		'loudong_name'=>'',
		'loudong_area'=>'',
		'loudong_manager'=>'',
		'user_id'=>'',
		'created'=>'',
		'loudong_remark'=>'',
		);
    }
    
    /**
     * 安装SQL表
     * @return void
     */
    function init()
    {
    	$this->query("CREATE TABLE  IF NOT EXISTS `t_aci_loudong`
(
`loudong_name` varchar(250) DEFAULT NULL COMMENT '楼栋名称',
`loudong_area` int(11) DEFAULT '0' COMMENT '楼栋面积',
`loudong_manager` varchar(250) DEFAULT NULL COMMENT '楼栋管理员',
`user_id` varchar(50) DEFAULT NULL COMMENT '创建者',
`created` varchar(50) DEFAULT NULL COMMENT '创建时间',
`loudong_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`loudong_remark` text COMMENT '楼栋备注',
PRIMARY KEY (`loudong_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
");
    }
    
        
    /**
     * 楼栋下拉框     * @return array
     */
    function dropdown_loudong_datasource($where='',$limit = '', $order = '', $group = '', $key='')
    {
    	$datalist = $this->select($where,'loudong_id,loudong_name,loudong_area',$limit,$order,$group,$key);
        return $datalist;
    }
    
    /**
     * 楼栋下拉框选择中项值     * @return array
     */
    function dropdown_loudong_value($id=0)
    {
    	$data_info = $this->get_one(array('loudong_id'=>$id),'loudong_name,loudong_area');
        if($data_info)
        {
        	return  implode("-",$data_info);
        }
        return NULL;
    }
        }

// END loudong_model class

/* End of file loudong_model.php */
/* Location: ./loudong_model.php */
?>