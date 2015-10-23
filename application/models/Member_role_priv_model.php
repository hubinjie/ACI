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
 * 项目名称：用户组权限管理 MODEL
 * 版本号：1 
 * 最后生成时间：2015-01-21 10:08:51 
 */
class Member_role_priv_model extends Base_Model {
	
    var $page_size = 10;
    function __construct()
	{
    	$this->db_tablepre = 't_sys_';
    	$this->table_name = 'member_role_priv';
		parent::__construct();
	}
	
	
	/**
	 * 获取菜单表信息
	 * @param int $menuid 菜单ID
	 * @param int $menu_info 菜单数据
	 */
	public function get_menuinfo($menuid,$menu_info) {
		$menuid = intval($menuid);
		unset($menu_info[$menuid]['menu_id']);
		return $menu_info[$menuid];
	}
	
	/**
	 *  检查指定菜单是否有权限
	 * @param array $data menu表中数组
	 * @param int $roleid 需要检查的角色ID
	 */
	public function is_checked($folder,$controller,$method,$role_id) {
		$c = $this->count(array('folder'=>$folder,'controller'=>$controller,'method'=>$method,'role_id'=>$role_id));
		return $c;
	}
	/**
	 * 是否为设置状态
	 */
	public function is_setting($siteid,$roleid) {
		$siteid = intval($siteid);
		$roleid = intval($roleid);
		$sqls = "`siteid`='$siteid' AND `roleid` = '$roleid' AND `m` != ''";
		$result = $this->get_one($sqls);
		return $result ? true : false;
	}
	/**
	 * 获取菜单深度
	 * @param $id
	 * @param $array
	 * @param $i
	 */
	public function get_level($id,$array=array(),$i=0) {
		foreach($array as $n=>$value){
			if($value['menu_id'] == $id)
			{
				if($value['parentid']== '0') return $i;
				$i++;
				return $this->get_level($value['parentid'],$array,$i);
			}
		}
	}
}

// END role_priv_model class

/* End of file role_priv_model.php */
/* Location: ./role_priv_model.php */
?>