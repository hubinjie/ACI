<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	
	if(!function_exists('group_options'))
	{
		function group_options($defaultValue=''){

			$all_groups = getcache("cache_member_group");

			$options[] =array('caption'=>'==请选择==','value'=>'');
			foreach($all_groups as $k=>$v)
			$options[] =array('caption'=>$v['role_name'],'value'=>$v['role_id']);
			
			$_html="";
			foreach($options as $k=>$v)
			{
				if($defaultValue == $v['value'])
					$_html .="<option value=\"{$v['value']}\" selected=\"selected\">{$v['caption']}</option>";
				else
					$_html .="<option value=\"{$v['value']}\" >{$v['caption']}</option>";
			}
			
			return $_html;
		}
	}
	
	
	if(!function_exists('sex'))
	{
		function sex($s){
		
			$s = intval($s);
			if($s==1) return "男";
			else if($s==2) return "女";
			
			return "-";
		}
	}
	
	
	if(!function_exists('group_name'))
	{
		function group_name($s){

			$all_groups = getcache("cache_member_group");

			return isset($all_groups[$s])?$all_groups[$s]['role_name']:"-";
		}
	}
	