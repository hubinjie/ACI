<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
define('NOT_CONVERT',true);
class ModuleInstall extends Admin_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('file','auto_codeIgniter','array'));
	}
	
	function check()
	{
		if(DEMO_STATUS)$this->showmessage('当前为演示状态，无法上传模块');
		  $config['upload_path'] = INTALL_UPLOAD_TEMP_PATH;
		  $config['allowed_types'] = 'zip';
		  $config['max_size'] = '1024';
		  $config['encrypt_name'] = true;
		  $check_result = false;
		  
		  $form_PSOT_SN = '123';
		  
		  $this->load->library('upload', $config);
		 
		  if ( ! $this->upload->do_upload('autocodeigniterZipFile'))
		  {
			 
		   	 $error = array('error' => $this->upload->display_errors());
		  	 $this->view('error', $error);
		  } 
		  else
		  {
			   $upload_data = array('upload_data' => $this->upload->data());
			   //上传成功后跳到成功页面
			   $file_name = $upload_data['upload_data']['raw_name'];
			   $this->showmessage('上传成功,等待安装。',base_url($this->page_data['folder_name'].'/'.$this->page_data['controller_name'].'/setup/'.$file_name.'/123'));
		  }

	}

	function overwrite_setup(){

	}
	
	function setup($file_name='',$form_PSOT_SN='')
	{
		if(DEMO_STATUS)$this->showmessage('当前为演示状态，无法上传模块');
		$uploaded_file = INTALL_UPLOAD_TEMP_PATH.DIRECTORY_SEPARATOR.$file_name.".zip";
		if(!file_exists($uploaded_file))
		{
			 $this->showmessage('很抱歉安装文件包丢失',base_url($this->page_data['folder_name'].'/'.$this->page_data['controller_name']));
		}else
		{
			   //先得到md5 
			   $md5_file_value = md5_file($uploaded_file);
			   //判断是否一致
			   
			   $zip = new ZipArchive;
				$res = $zip->open($uploaded_file);
				//如果打开成功
				if ($res === TRUE) {
					//读取配置文件
					 $stream_aci = $zip->getStream('aci.php');  
					 
					 //如果存在
					 if($stream_aci)
					 {
						$str_aci = stream_get_contents($stream_aci); //这里注意获取到的文本编码
					 	$arr_aci_config = string2array($str_aci); 
						
						//校验序列号
						if(trim($form_PSOT_SN)!= $arr_aci_config['serialNumber'])
						{
							$check_result = array('error'=>'非法安装包:非法序列号！','result'=>false);
						}else
						{
							//检查模块所需上传路径
							if($arr_aci_config['environment']['uploadPath'])
							{
								foreach($arr_aci_config['environment']['uploadPath'] as $k=>$v)
								{
									//创建并检权限
									
									if(!file_exists(FCPATH.DIRECTORY_SEPARATOR.$v)){
										if(!dir_create(FCPATH.DIRECTORY_SEPARATOR.$v))
										{
											$check_result[] = array('error'=>FCPATH.DIRECTORY_SEPARATOR.$v."没有创建文件夹权限",'result'=>false);
										}
									}
									
									$chomd_value = octal_permissions(fileperms(FCPATH.DIRECTORY_SEPARATOR.$v));
									if($chomd_value<777){
										$check_result[] = array('error'=>FCPATH.DIRECTORY_SEPARATOR.$v."权限不足，请确保有读写权限",'result'=>false);
									}
									
								}
							}
							
							//4.版本号 判断是升级还是安装 SQL
							if(isset($this->aci_config[$arr_aci_config['moduleName']]))
							{
								//检查是否存在相同的文件 粗暴删减字段 别怪我，最好不要通过这么升级

								$this->Module_menu_model->query("DROP TABLE IF EXISTS t_aci_tmp_created_table");

								$table_name ="t_aci_".strtolower($arr_aci_config['moduleName']);
								$created_sql = str_replace($table_name,"t_aci_tmp_created_table",$arr_aci_config['installSQL']);
								$this->Module_menu_model->query($created_sql);
								$new_table_field_list = $this->Module_menu_model->select_sql("SHOW  FIELDS FROM  t_aci_tmp_created_table ");
								
								$old_table_field_list = $this->Module_menu_model->select_sql("SHOW  FIELDS FROM  {$table_name} ");
								if($new_table_field_list)foreach($new_table_field_list as $k=>$v){
									//如果没有就新增，

									$found=false;
									if($old_table_field_list)
									foreach($old_table_field_list as $kk=>$vv){

										if($vv['Field']==$v['Field']){


											//如果类型不一样，强制修改类型
											if($vv['Type']!=$v['Type']){
												$this->Module_menu_model->query("alter table {$table_name}  change  {$v['Field']}  {$v['Type']} {$vv['Type']}");

											}

											$found = true;
											break;
										}
									}


									if(!$found){
										$this->Module_menu_model->query("alter table {$table_name} add {$v['Field']} {$v['Type']};");
									}
								}


								if($old_table_field_list)foreach($old_table_field_list as $k=>$v){
									//如果没有多的就删除，暴力

									$found=false;
									if($new_table_field_list)
										foreach($new_table_field_list as $kk=>$vv){
											if($vv['Field']==$v['Field']){
												//如果类型不一样，强制修改类型
												if($vv['Type']!=$v['Type']){
													$this->Module_menu_model->query("alter table {$table_name} change {$v['Field']}  {$v['Type']} {$vv['Type']}");

												}
												$found = true;
												break;
											}
										}

									if(!$found){
										$this->Module_menu_model->query("alter table {$table_name} drop column {$v['Field']};");
									}

								}


							}else{
								$this->Module_menu_model->query($arr_aci_config['installSQL']);
							}


								//5.COPY文件
								$status = $this->save_config($arr_aci_config);//保存CONFIG
								if(!$status)
								{
									$check_result[] =array('error'=>'配置文件无法保存，请检查权限！','result'=>false);
								}else
								{
									$this->_install_menu($arr_aci_config);
									
									$result = $this->_install_file($arr_aci_config,$zip); //7.COPY代码
									if($result['result'])
									{
										$this->showmessage('模块安装成功',base_url($arr_aci_config['moduleUrl']));
									}else
									{
										$check_result[] = $result; 
									}
								}
						}
					 }else
					 {
						 $check_result = array('error'=>'非法安装包:配置文件不存在！','result'=>false);
					 }
					
				} else {
					//输出出错的代码
					$check_result[] = array('error'=>"安装包出错:".$res,'result'=>false);
				}
				$zip->close(); 
				
				
			   $this->view('setup_error',array('require_js'=>true,'upload_data'=>$check_result));
		  }
	}
	
	//7.COPY代码
	function _install_file($arr_aci_config,&$zip)
	{
	
		if($arr_aci_config['fileList'])
		foreach($arr_aci_config['fileList'] as $k=>$v)
		{
			$stream_aci = $zip->getStream($v);  
		   //如果存在
		   if($stream_aci)
		   {
			  $str_aci = stream_get_contents($stream_aci); //这里注意获取到的文本编码
			  $_pathinfo = pathinfo(FCPATH.$v);
			  dir_create($_pathinfo['dirname']);
			  if(file_exists(FCPATH.$v)){
			  	 if(SETUP_BACKUP_OVERWRITE_FILES){
				  	@rename(FCPATH.$v,FCPATH.$v.".".date("ymdhis").".bak");
				  }
				  
			  }
			  if ( ! write_file(FCPATH.$v, $str_aci))
			  {
				  return array('tips'=>$v."文件出错","result"=>false);
			  }
		   }
		}

	return array('tips'=>"ok","result"=>true);

	}
	
	//6.安装菜单
	function _install_menu($arr_aci_config)
	{
		$parent_id = 0;
		if($arr_aci_config['menu'])
		foreach($arr_aci_config['menu'] as $k=>$v)
		{
			$flag_id = $v['flag_id'];
			
			$_datainfo = $this->Module_menu_model->get_one(array('flag_id'=>$flag_id));
			if($_datainfo)
			{
				//$parent_id = $_datainfo['menu_id'];
				//$this->Module_menu_model->update($v,array('flag_id'=>$flag_id));
			}else
			{
				if($v['parent_id']==0) $parent_id = 0;
				$v['parent_id'] = $parent_id;
				$v['user_id'] = $this->user_id;
				$newid = $this->Module_menu_model->insert($v);
				if($v['parent_id']==0)$parent_id =$newid;
			}
		}
	}
	
	function save_config($config,$is_remove=false)
	{
		if(isset($this->aci_config[$config['moduleName']]))
		{
			unset($this->aci_config[$config['moduleName']]);
		}
		
		if(!$is_remove)
		{
			$this->aci_config[$config['moduleName']]['version'] = $config['version'];
			$this->aci_config[$config['moduleName']]['charset'] = $config['charset'];
			$this->aci_config[$config['moduleName']]['lastUpdate'] = $config['lastUpdate'];
			$this->aci_config[$config['moduleName']]['moduleName'] = $config['moduleName'];
			$this->aci_config[$config['moduleName']]['modulePath'] =  trim($config['modulePath'],'/');
			$this->aci_config[$config['moduleName']]['moduleCaption'] = $config['moduleCaption'];
			$this->aci_config[$config['moduleName']]['description'] = $config['description'];
			$this->aci_config[$config['moduleName']]['fileList'] = $config['fileList'];
			$this->aci_config[$config['moduleName']]['works'] =  $config['works'];
			$this->aci_config[$config['moduleName']]['moduleUrl'] =  $config['moduleUrl'];
			$this->aci_config[$config['moduleName']]['system'] =  $config['system'];
			$this->aci_config[$config['moduleName']]['coder'] =  $config['coder'];
			$this->aci_config[$config['moduleName']]['website'] =  $config['website'];
			
			if(isset($config['menu']))
			{
				foreach($config['menu'] as $k=>$v)
				{
					$config['menu'][$k] = elements(array('folder','controller', 'method','menu_name'), $v);
					$config['menu'][$k]['caption'] = $config['menu'][$k]['menu_name'];
				}

				$this->aci_config[$config['moduleName']]['moduleDetails'] =  $config['menu'];
			}
		}
		$php_tags  = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n";
		$php_tags .= "\$config['aci_status'] = ".var_export($this->aci_status, TRUE).";\n";
		$php_tags .= "\$config['aci_module'] = ".var_export($this->aci_config, TRUE).";\n";
		$php_tags .= "\n/* End of file aci.php */\n";
		$php_tags .= "/* Location: ./application/config/aci.php */\n";
		
		return write_file(APPPATH.'config'.DIRECTORY_SEPARATOR.'aci.php', $php_tags);
	}
	
	//删除
	function delete($moduleName='')
	{
		if(DEMO_STATUS)$this->showmessage('当前为演示状态，无法删除模块');
		$moduleName=  trim($moduleName);
		if(isset($this->aci_config[$moduleName]))
		{
			$arr = $this->aci_config[$moduleName];
			
			$status = $this->save_config($arr,true);
			
			if($status)
				$this->showmessage('模块删除成功！',base_url($this->page_data['folder_name'].'/moduleManage'));
			else
				$this->showmessage('模块删除失败，请检查config/aci.php 是否可读写',base_url($this->page_data['folder_name'].'/manage'));
		}else
		{
			$this->showmessage('模块不存在，或未正确安装',base_url($this->page_data['folder_name'].'/moduleManage'));
		}
	}
	
	function uninstall($moduleName='')
	{
		
		$moduleName=  trim($moduleName);
		if(isset($this->aci_config[$moduleName]))
		{
			$arr = $this->aci_config[$moduleName];
			$arr['works'] = false;
			$arr['menu'] = $arr['moduleDetails'];
			$status = $this->save_config($arr);
			
			if($status)
				$this->showmessage('模块停用成功，可以通过启用再加使用',base_url($this->page_data['folder_name'].'/moduleManage'));
			else
				$this->showmessage('模块停用失败，请检查config/aci.php 是否可读写',base_url($this->page_data['folder_name'].'/moduleManage'));
		}else
		{
			$this->showmessage('模块不存在，或未正确安装',base_url($this->page_data['folder_name'].'/moduleManage'));
		}
	}
	
	function reinstall($moduleName='')
	{
		$moduleName=  trim($moduleName);
		if(isset($this->aci_config[$moduleName]))
		{
			$arr = $this->aci_config[$moduleName];
			$arr['works'] = true;
			$arr['menu'] = $arr['moduleDetails'];
			$status = $this->save_config($arr);
			
			if($status)
				$this->showmessage('模块启用成功，可以通过启用再加使用',base_url($this->page_data['folder_name'].'/moduleManage'));
			else
				$this->showmessage('模块启用失败，请检查config/aci.php 是否可读写',base_url($this->page_data['folder_name'].'/moduleManage'));
		}else
		{
			$this->showmessage('模块不存在，或未正确安装',base_url($this->page_data['folder_name'].'/moduleManage'));
		}
	}
	
	function index()
	{
		$status = true;
		if(!file_exists(INTALL_UPLOAD_TEMP_PATH)){
			$status = dir_create(INTALL_UPLOAD_TEMP_PATH);
		}
		
		 $install_uploaded_chomd = $status?octal_permissions(fileperms(INTALL_UPLOAD_TEMP_PATH)):0;

		 $install_config_chomd = $status?@octal_permissions(fileperms(APPPATH.'config'.DIRECTORY_SEPARATOR.'aci.php')):0;
	
	
		 $error = array('require_js'=>true,'uploadChomd'=>$install_uploaded_chomd,'configChomd'=>$install_config_chomd,'supportZip'=>class_exists('ZipArchive'));
		 $this->view('index', $error);
		  
	}
	

}