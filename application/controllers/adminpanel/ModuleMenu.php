<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
define('NOT_CONVERT',true);
class ModuleMenu extends Admin_Controller {

	var $menus;
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('tree');
		$this->load->helper(array('auto_codeIgniter'));
	}
	
	function index()
	{
		$tree=$this->tree;
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		
		$result = $this->Module_menu_model->select('','*,`menu_id` as id','','list_order ASC,menu_id DESC');

		$array = array();

		foreach($result as $r) {
			$r['menu_name'] = $r['menu_name'];
			$r['is_system'] = $r['is_system']?'是':'否';
			$r['is_side_menu'] = $r['is_side_menu']?'是':'否';
			if($r['is_system'])
			{
				$r['str_manage'] =aci_ui_a($this->page_data['folder_name'],$this->page_data['controller_name'],'add',$r['id'],' class="btn btn-default btn-xs"','<span class="glyphicon glyphicon-plus"></span> 新增子菜单',true);
				$r['str_manage'] .= " ". aci_ui_a($this->page_data['folder_name'],$this->page_data['controller_name'],'edit',$r['id'],' class="btn btn-default btn-xs"','<span class="glyphicon glyphicon-wrench"></span> 修改',true);
			}else{
				
			}
			
			$array[] = $r;
		}
	
		$str  = "<tr>
					<td><input type='checkbox' name='pid[]' value='\$menu_id' /></td>
					<td><i class='fa fa-\$css_icon'></i> </td>
					<td>\$spacer\$menu_name</td>
					<td>\$folder</td>
					<td>\$controller</td>
					<td>\$method</td>
					<td>\$is_side_menu</td>
					<td>\$is_system</td>
					<td>\$str_manage</td>
				</tr>";
				
		$tree->init($array);
		$table_html = $tree->get_tree(0, $str);
		
		$this->view('index',array('require_js'=>true,'table_html'=>$table_html));
	}
	
	function set_menu()
	{
		if(isset($_POST))
		{
			$pidarr = isset($_POST['pid']) ? $_POST['pid'] : $this->showmessage('无效参数', HTTP_REFERER);
			$where = $this->Module_menu_model->to_sqls($pidarr, '', 'menu_id');
			$status = $this->Module_menu_model->update(array('is_side_menu'=>'^1'),$where);
			if($status)
			{
				$this->repair();
				$this->cache();
				$this->showmessage('操作成功', HTTP_REFERER);
			}else 
			{
				$this->showmessage('操作失败');
			}
		}
	}
	
	function delete()
	{
		if(isset($_POST))
		{
			$pidarr = isset($_POST['pid']) ? $_POST['pid'] : $this->showmessage('无效参数', HTTP_REFERER);
			$where = $this->Module_menu_model->to_sqls($pidarr, '', 'menu_id');
			$status = $this->Module_menu_model->delete($where." ");
			if($status)
			{
				$this->repair();
				$this->cache();
				$this->showmessage('操作成功', HTTP_REFERER);
			}else 
			{
				$this->showmessage('操作失败');
			}
		}
	}
	
	function add($parent_id=0)
	{
		if(isset($_POST['parent_id'])&& is_ajax()) {

			$parent_id = intval($this->input->post('parent_id'));
			$menu_name = trim($this->input->post('menu_name',true));
			$menu_url = trim($this->input->post('menu_url',true));
			$is_display = intval($this->input->post('is_display',true));
			$css_icon = trim($this->input->post('css_icon',true));
			$show_where = intval($this->input->post('show_where'));

			$depth = $parent_id>0?$this->get_depth($parent_id):0;
			//只有不是一二级菜单
			if($depth>1){
				$menu_url_arr=explode(",",$menu_url);
				list($folder,$controller,$methodName)  = $menu_url_arr;
			}else{
				$folder = $show_where==1?$this->page_data['folder_name']:"member";
				$controller = "manage";
				$methodName = "go_0";
			}
			
			if($menu_name=="")exit(json_encode(array('status'=>false,'tips'=>' 菜单名称不能为空')));
			$status = $this->Module_menu_model->insert(
													array(
														'menu_name'=>$menu_name,
														'parent_id'=>$parent_id,
														'list_order'=>0,
														'is_display'=>$is_display,
														'controller'=>$controller,
														'folder'=>$folder,
														'method'=>$methodName,
														'css_icon'=>$css_icon,
														'is_works'=>true,
														'is_system'=>false,
														'is_side_menu'=>true,
														'show_where'=>$show_where,
														'user_id'=>$this->user_id
														));

			if($status){
				if($depth<=1)$this->Module_menu_model->update(array('method'=>'go_'.$status),array('menu_id'=>$status));
				$this->repair();
				$this->cache();
				echo json_encode(array('status'=>true,'tips'=>"ok"));
			}
			else
				echo json_encode(array('status'=>false,'tips'=>"false"));
				
		} else {
			$show_validator = '';
			$parent_id =  intval($parent_id);
			$tree=$this->tree;
			$result = $this->Module_menu_model->select('','*,`menu_id` as id','','list_order ASC,menu_id DESC');
			$array = array();
			foreach($result as $r) {
				$r['cname'] = $r['menu_name'];
				$r['selected'] = $r['menu_id'] == $parent_id ? 'selected' : '';
				$array[] = $r;
			}
			$str  = "<option depth='\$depth' value='\$menu_id' \$selected>\$spacer \$cname </option>";
			$tree->init($array);
			$select_categorys = $tree->get_tree(0, $str);
			
			$this->view('edit',array('is_edit'=>false,'require_js'=>true,'select_categorys'=>$select_categorys,'data_info'=>$this->Module_menu_model->default_info()));
		}
	}
	
	
	function edit($menu_id=0)
	{
		$menu_id = intval($menu_id);
		$datainfo = $this->Module_menu_model->get_one(array('menu_id'=>$menu_id));

		if(!$datainfo) $this->showmessage('菜单信息不存在');
		
		if(isset($_POST['parent_id'])&& is_ajax()) {

			$parent_id = intval($this->input->post('parent_id'));
			$menu_name = trim($this->input->post('menu_name',true));
			$menu_url = trim($this->input->post('menu_url',true));
			$is_display = intval($this->input->post('is_display',true));
			$css_icon = trim($this->input->post('css_icon',true));
			$show_where = intval($this->input->post('show_where'));

			$depth = $parent_id>0?$this->get_depth($parent_id):0;

			//只有不是一二级菜单
			if($depth>1){
				$menu_url_arr=explode(",",$menu_url);
				list($folder,$controller,$methodName)  = $menu_url_arr;
			}else{
				$folder = $show_where==1?$this->page_data['folder_name']:"member";
				$controller = "manage";
				$methodName = "go_".$menu_id;
			}
			
			if($menu_name=="")exit(json_encode(array('status'=>false,'tips'=>' 菜单名称不能为空')));

			$status = $this->Module_menu_model->update(
													array(
														'menu_name'=>$menu_name,
														'parent_id'=>$parent_id,
														'is_display'=>$is_display,
														'controller'=>$controller,
														'folder'=>$folder,
														'method'=>$methodName,
														'css_icon'=>$css_icon,
														'show_where'=>$show_where,
														),array('menu_id'=>$menu_id));
			

			if($status){
				$this->repair();
				$this->cache();
				echo json_encode(array('status'=>true,'tips'=>"ok"));
			}
			else
				echo json_encode(array('status'=>false,'tips'=>"false"));
				
		} else {
			$show_validator = $array = $r = '';
			$tree=$this->tree;
			
		
			$result = $this->Module_menu_model->select('','*,`menu_id` as id','','list_order ASC,menu_id DESC');
			foreach($result as $r) {
				$r['cname'] = $r['menu_name'];
				$r['selected'] = $r['menu_id'] == $datainfo['parent_id'] ? 'selected' : '';
				$array[] = $r;
			}
			$str  = "<option depth='\$depth'  value='\$id' \$selected>\$spacer \$cname</option>";
			$tree->init($array);
			$select_categorys = $tree->get_tree(0, $str);
			
			$this->view('edit',array('is_edit'=>true,'require_js'=>true,'select_categorys'=>$select_categorys,'data_info'=>$datainfo));
		}
	}

	/**
	 * 更新缓存
	 */
	private  function get_depth($menu_id=0){
		$cache_module_menu_all = getcache('cache_module_menu_all');

		if( isset($cache_module_menu_all[$menu_id])){
			$arr = $cache_module_menu_all[$menu_id];
			$arr_parentid = explode(",",$arr['arr_parentid']);
			return count($arr_parentid);
		}

		return 0;
	}

	/**
	 * 更新缓存
	 */
	private function cache() {
		$menus = array();

		$datas = $this->Module_menu_model->select('','*',10000,'list_order ASC,menu_id asc');
		$array = array();
		foreach ($datas as $k =>$r) {
			$r['url'] =base_url($r['folder'].'/'.$r['controller'].'/'.$r['method']) ;


			$arr_parentid =  $r['arr_parentid'];
			$arr_parentid = explode(",",$arr_parentid);

			#缓存的时候自动将第一级要跳转的URL写入到缓存
			if(count($arr_parentid)==1) {
				#找到下面第一个子目录
				$first_child_arr = $this->Module_menu_model->get_one("arr_parentid like '0,".$r['menu_id']."' and is_display = 1","*","list_order asc");

				if($first_child_arr){
					$first_child_child_arr = $this->Module_menu_model->get_one("arr_parentid like '0,".$r['menu_id'].",".$first_child_arr['menu_id']."' and is_display = 1","*","list_order asc");
					if($first_child_child_arr){
						$r['url'] =base_url($first_child_child_arr['folder'].'/'.$first_child_child_arr['controller'].'/'.$first_child_child_arr['method']) ;
					}
				}
			}
			$menus[$r['menu_id']] = $r;

		}
		setcache('cache_module_menu_all', $menus);
		return true;
	}


	/**
	 * 找出子目录列表
	 * @param array $categorys
	 */
	private function get_categorys($categorys = array()) {
		if (is_array($categorys) && !empty($categorys)) {
			foreach ($categorys as $catid => $c) {
				$this->menus[$catid] = $c;
				$result = array();
				foreach ($this->menus as $_k=>$_v) {
					if($_v['parent_id']) $result[] = $_v;
				}
			}
		}
		return true;
	}


	/**
	 *
	 * 获取父栏目ID列表
	 * @param integer $catid              栏目ID
	 * @param array $arrparentid          父目录ID
	 * @param integer $n                  查找的层次
	 */
	private function get_arrparentid($catid, $arrparentid = '', $n = 1) {
		if($n > 5 || !is_array($this->menus) || !isset($this->menus[$catid])) return false;
		$parentid = $this->menus[$catid]['parent_id'];
		$arrparentid = $arrparentid ? $parentid.','.$arrparentid : $parentid;
		if($parentid) {
			$arrparentid = $this->get_arrparentid($parentid, $arrparentid, ++$n);
		} else {
			$this->menus[$catid]['arr_childid'] = $arrparentid;
		}
		$parentid = $this->menus[$catid]['parent_id'];
		return $arrparentid;
	}

	/**
	 *
	 * 获取子栏目ID列表
	 * @param $catid 栏目ID
	 */
	private function get_arrchildid($catid) {
		$arrchildid = $catid;
		if(is_array($this->menus)) {
			foreach($this->menus as $id => $cat) {
				if($cat['parent_id'] && $id != $catid && $cat['parent_id']==$catid) {
					$arrchildid .= ','.$this->get_arrchildid($id);
				}
			}
		}
		return $arrchildid;
	}

	/**
	 * 修复栏目数据
	 */
	private function repair() {

		@set_time_limit(600);

		$this->menus = $categorys = array();
		$this->menus = $categorys = $this->Module_menu_model->select('', '*', '', 'list_order ASC, menu_id ASC', '', 'menu_id');

		$this->get_categorys($categorys);

		$categorys = $this->menus;
		if(is_array($this->menus)) {

			foreach($this->menus as $cid => $cat) {

				$arrparentid = $this->get_arrparentid($cid);

				$arrchildid = $this->get_arrchildid($cid);

				$is_parent = is_numeric($arrchildid) ? 0 : 1;

				if($categorys[$cid]['arr_parentid']!=$arrparentid || $categorys[$cid]['arr_childid']!=$arrchildid || $categorys[$cid]['is_parent']!=$is_parent)
				{
					$this->Module_menu_model->update(array('arr_parentid'=>$arrparentid,'arr_childid'=>$arrchildid,'is_parent'=>$is_parent),array('menu_id'=>$cid));
				}


				$catname = $cat['menu_name'];
				$listorder = $cat['list_order'] ? $cat['list_order'] : $cid;
				if($categorys[$cid]['list_order']!=$listorder) $this->Module_menu_model->update(array('list_order'=>$listorder), array('menu_id'=>$cid));
			}
		}

		//删除在非正常显示的栏目
		foreach($this->menus as $cid => $cat) {
			if($cat['parent_id'] != 0 && !isset($this->menus[$cat['parent_id']])) {
				$this->Module_menu_model->delete(array('menu_id'=>$cid));
			}
		}

		return true;
	}

}