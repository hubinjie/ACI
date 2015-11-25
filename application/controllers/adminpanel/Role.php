<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * AutoCodeIgniter.com
 *
 * 基于CodeIgniter核心模块自动生成程序
 *
 * 源项目		AutoCodeIgniter
 * 作者：		AutoCodeIgniter.com Dev Team EMAIL:hubinjie@outlook.com QQ:5516448
 * 版权：		Copyright (c) 2015 , AutoCodeIgniter com.
 * 项目名称：用户组管理 
 * 版本号：1 
 * 最后生成时间：2015-01-21 10:08:51 
 */
class Role extends Admin_Controller {
	
    var $method_config;
    function __construct()
	{
		parent::__construct();
		$this->load->model(array('Member_role_model'));
        $this->load->helper(array('array'));
  		$this->load->library('tree');
	}
    
    /**
     * 默认首页列表
     * @param int $pageno 当前页码
     * @return void
     */
    function index($page_no=0,$sort_id=0)
    {
    	$page_no = max(intval($page_no),1);
        
        $orderby = "";
        $dir = $order=  NULL;
		        
        $where ="";
        $_arr = NULL;//从URL GET
        		$data_list = $this->Member_role_model->listinfo($where,'*',$orderby , $page_no, $this->Member_role_model->page_size,'',$this->Member_role_model->page_size,page_list_url('member/role/index',true));
    	$this->view('lists',array('require_js'=>true,'data_info'=>$_arr,'order'=>$order,'dir'=>$dir,'data_list'=>$data_list,'pages'=>$this->Member_role_model->pages));
    }
    
     /**
     * 新增数据
     * @param AJAX POST 
     * @return void
     */
    function add()
    {
    	//如果是AJAX请求
    	if($this->input->is_ajax_request())
		{
        	//接收POST参数
			$_arr['role_name'] = isset($_POST["role_name"])?trim(safe_replace($_POST["role_name"])):exit(json_encode(array('status'=>false,'tips'=>'组名不能为空')));
			if($_arr['role_name']=='')exit(json_encode(array('status'=>false,'tips'=>'组名不能为空')));
			$_arr['description'] = isset($_POST["description"])?trim(safe_replace($_POST["description"])):exit(json_encode(array('status'=>false,'tips'=>'组介绍不能为空')));
			if($_arr['description']=='')exit(json_encode(array('status'=>false,'tips'=>'组介绍不能为空')));
			
            $new_id = $this->Member_role_model->insert($_arr);
            if($new_id)
            {
            	$this->_cache();	
				exit(json_encode(array('status'=>true,'tips'=>'信息新增成功','new_id'=>$new_id)));
            }else
            {
            	exit(json_encode(array('status'=>false,'tips'=>'信息新增失败','new_id'=>0)));
            }
        }else
        {
        	$this->view('edit',array('is_edit'=>false,'require_js'=>true,'data_info'=>$this->Member_role_model->default_info()));
        }
    }
    
     /**
     * 删除单个数据
     * @param int id 
     * @return void
     */
    function delete_one($id=0)
    {
    	$id = intval($id);
        $data_info =$this->Member_role_model->get_one(array('role_id'=>$id));
        if(!$data_info)$this->showmessage('信息不存在');

        if($id!=SUPERADMIN_GROUP_ID){
        	$status = $this->Member_role_model->delete(array('role_id'=>$id));
	        if($status)
	        {
	        	$this->showmessage('删除成功');
	        }else
	        	$this->showmessage('删除失败');
        }
        $this->showmessage('删除失败');
        
    }
    
    
    
     /**
     * 修改数据
     * @param int id 
     * @return void
     */
    function edit($id=0)
    {
    	$id = intval($id);
        
        $data_info =$this->Member_role_model->get_one(array('role_id'=>$id));
    	//如果是AJAX请求
    	if($this->input->is_ajax_request())
		{
        	if(!$data_info)exit(json_encode(array('status'=>false,'tips'=>'信息不存在')));
        	//接收POST参数
			$_arr['role_name'] = isset($_POST["role_name"])?trim(safe_replace($_POST["role_name"])):exit(json_encode(array('status'=>false,'tips'=>'组名不能为空')));
			if($_arr['role_name']=='')exit(json_encode(array('status'=>false,'tips'=>'组名不能为空')));
			$_arr['description'] = isset($_POST["description"])?trim(safe_replace($_POST["description"])):exit(json_encode(array('status'=>false,'tips'=>'组介绍不能为空')));
			if($_arr['description']=='')exit(json_encode(array('status'=>false,'tips'=>'组介绍不能为空')));
			
            $status = $this->Member_role_model->update($_arr,array('role_id'=>$id));
            if($status)
            {
            	$this->_cache();	
				exit(json_encode(array('status'=>true,'tips'=>'信息修改成功')));
            }else
            {
            	exit(json_encode(array('status'=>false,'tips'=>'信息修改失败')));
            }
        }else
        {
        	if(!$data_info)$this->showmessage('信息不存在');
        	$this->view('edit',array('require_js'=>true,'is_edit'=>true,'data_info'=>$data_info));
        }
    }
    
     /**
     * 设定权限
     * @param int id 
     * @return void
     */
    function setting($id=0)
    {
    	$id = intval($id);
        $data_info =$this->Member_role_model->get_one(array('role_id'=>$id));
        if(!$data_info)$this->showmessage('信息不存在');
		
		if(isset($_POST['pid'])){
			if (isset($_POST['pid'])&&is_array($_POST['pid']) && count($_POST['pid']) > 0) {

				$pidarr = isset($_POST['pid']) ? $_POST['pid'] : $this->showmessage('无效参数', HTTP_REFERER);
				
				
				$this->Member_role_priv_model->delete(array('role_id'=>$id));
				$where = $this->Module_menu_model->to_sqls($pidarr, '', 'menu_id');
				$dataList = $this->Module_menu_model->select($where);
				
				$_arrs = NULL;
				foreach($dataList as $menu){
					$_arrs[] =  array('menu_id'=>$menu['menu_id'],'role_id'=>$id,'folder'=>$menu['folder'],'controller'=>$menu['controller'],'method'=>$menu['method']);
				}
				
				if($_arrs)$this->Member_role_priv_model->insert_batch($_arrs);
			} else {
				$this->Member_role_priv_model->delete(array('role_id'=>$id));
			}
			
			$this->_cache();	
			$this->showmessage('操作成功', HTTP_REFERER);
		}else
		{
			$tree=$this->tree;
			$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
			$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
			
			$result = $this->Module_menu_model->select('','*,`menu_id` as id','','list_order ASC,menu_id DESC');
						
			$array = array();
			foreach($result as $k=>$r) {
				$r['menu_name'] = $r['menu_name'];
				$r['checked'] = ($this->Member_role_priv_model->is_checked($r['folder'],$r['controller'],$r['method'],$id))? ' checked' : '';
				$array[] = $r;
			}
		
			$str  = "<tr>
						<td>-</td>
						<td>\$spacer\$menu_name</td>
						<td><input type='checkbox' name='pid[]' value='\$menu_id' \$checked /></td>
					</tr>";
					
			$tree->init($array);
			$table_html = $tree->get_tree(0, $str);
			
			$this->view('setting',array('data_info'=>$data_info,'require_js'=>true,'table_html'=>$table_html));
		}
    }
	


	/**
	 *
	 * 获取该组所有的员工ID列表
	 * @param $staffid 员工ID
	 */
	private function get_arrgroupid($groupid,$n=0) {
		$arrchildid = $n==0?"":$groupid;
		if(is_array($this->groups)) {
			foreach($this->groups as $id => $group) {
				$n++;
				if($group['parent_id'] && $id != $groupid && $group['parent_id']==$groupid) {
					$arrchildid .=  ($arrchildid==""?'':',').$this->get_arrgroupid($id,$n);
				}
			}
		}
		return $arrchildid;
	}

	/**
	 * 缓存站点数据
	 */
	private function _cache_system($role) {
		$where = $this->Member_role_priv_model->to_sqls($role, '', 'role_id');

		$priv_arr = $this->Member_role_priv_model->select($where);
		$new_priv_arr = array();
		if($priv_arr) {
			foreach($priv_arr as $k=>$v){
				$new_priv_arr[$v['role_id']][$v['menu_id']]=$v;
			}
			setcache('cache_member_role_priv', $new_priv_arr);
		}
		return $new_priv_arr;
	}


	/**
	 * 角色缓存
	 */
	private function _cache() {

		$infos = $this->Member_role_model->select('',  '*', '', 'role_id ASC');
		$role = array();
		$roldid_arr=array();
		foreach ($infos as $info){
			$role[$info['role_id']] = $info['role_name'];
			$roldid_arr[]=$info['role_id'];
			$this->groups[$info['role_id']]=$info;
		}
		$this->_cache_system($roldid_arr);

		foreach($this->groups as $k=>$v)
		{

			if($this->groups[$k]['auto_choose'])
			{
				$this->groups[$k]['arr_childid'] = trim($this->get_arrgroupid($k));
				if($this->groups[$k]['arr_childid'] !="")
				{
					$arr_users_rows = $this->Member_model->select("group_id in({$this->groups[$k]['arrchild_id']})","user_id");
					$arr_users_ids = array();
					foreach($arr_users_rows as $v)
					{
						$arr_users_ids[]= $v['user_id'];
					}
					$this->groups[$k]['arr_userid'] =  implode(",",$arr_users_ids);
				}else
					$this->groups[$k]['arr_userid'] ="";
			}
			else
			{
				$this->groups[$k]['arr_userid'] =$v['arr_userid'];
			}
		}

		setcache('cache_member_group', $this->groups);
		return $infos;
	}

	/**
	 * 用户组弹窗
	 * @return array
	 */
	function group_window($controlId='',$page_no=0)
	{
		$page_no = max(intval($page_no),1);

		$data_list = $this->Member_role_model->select('',  '*', '', 'role_id ASC');

		$this->view('choose',array('hidden_menu'=>true,'data_list'=>$data_list,'control_id'=>$controlId,'require_js'=>true));
	}
}

// END role class

/* End of file role.php */
/* Location: ./role.php */
?>