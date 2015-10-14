<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Step extends Front_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('file','array'));

	}

	private function check_chomd($return_result=false){
		$status = true;
		if(!file_exists(INTALL_UPLOAD_TEMP_PATH)){
			$status = dir_create(INTALL_UPLOAD_TEMP_PATH);
			$status = dir_create(UPLOAD_TEMP_PATH);
		}

		 $install_uploaded_chomd = $status?octal_permissions(fileperms(INTALL_UPLOAD_TEMP_PATH)):0;

		 $install_config_chomd = $status?octal_permissions(fileperms(APPPATH.'config'.DIRECTORY_SEPARATOR.'aci.php')):0;

		 $mysql_version = mysql_get_client_info();

		 $supportZip = class_exists('ZipArchive');
		 $error = array('uploadChomd'=>$install_uploaded_chomd,'configChomd'=>$install_config_chomd,'supportZip'=>$supportZip);

		 if(!$status||!$install_uploaded_chomd||!$install_config_chomd||!$supportZip){
		 	if(!$return_result)
		 	{
		 		redirect(base_url('setup/step/error'));
		 		exit();
		 	}
		 }

		 return $error;
	}

	function error(){
		$error = $this->check_chomd(1);
		$this->view('error',$error);
	}

	function index(){
		$this->check_chomd(0);
		$this->view('index');
	}

	private function split_sql($sql) {
	    $sql = trim($sql);

	    $sql = preg_replace("/\n#[^\n]*\n/i", "\n", $sql);

	    $buffer = array();
	    $ret = array();
	    $in_string = false;

	    for($i=0; $i<strlen($sql)-1; $i++) {
	        if($sql[$i] == ";" && !$in_string) {
	            $ret[] = substr($sql, 0, $i);
	            $sql = substr($sql, $i + 1);
	            $i = 0;
	        }

	        if($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\") {
	            $in_string = false;
	        }
	        elseif(!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset($buffer[0]) || $buffer[0] != "\\")) {
	            $in_string = $sql[$i];
	        }
	        if(isset($buffer[1])) {
	            $buffer[0] = $buffer[1];
	        }
	        $buffer[1] = $sql[$i];
	    }

	    if(!empty($sql)) {
	        $ret[] = $sql;
	    }
	    return($ret);
	}

	function done(){
		$this->reload_all_cache();

		$this->aci_status['installED'] = true;
		//更新config
		$php_tags  = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n";
		$php_tags .= "\$config['base_url'] = ".var_export(base_url(), TRUE).";\n";
		$php_tags .= "\$config['index_page'] = '';\n";
		$php_tags .= "\$config['aci_status'] = ".var_export($this->aci_status, TRUE).";\n";
		$php_tags .= "\$config['aci_module'] = ".var_export($this->aci_config, TRUE).";\n";
		$php_tags .= "\n/* End of file aci.php */\n";
		$php_tags .= "/* Location: ./application/config/aci.php */\n";

		write_file(APPPATH.'config/aci.php', $php_tags);

		redirect(site_url());
	}

	function install(){

		$this->check_chomd(0);
		//如果是AJAX请求
    	if($this->input->is_ajax_request())
		{
        	//接收POST参数
			$_arr['site_url'] = isset($_POST["site_url"])?trim(safe_replace($_POST["site_url"])):exit(json_encode(array('status'=>false,'tips'=>'安装首页网址 不能为空')));
			if($_arr['site_url']=='')exit(json_encode(array('status'=>false,'tips'=>'安装首页网址 不能为空')));

			$_arr['mysql_url'] = isset($_POST["mysql_url"])?trim(safe_replace($_POST["mysql_url"])):exit(json_encode(array('status'=>false,'tips'=>'MYSQL 主机地址 不能为空')));
			if($_arr['mysql_url']=='')exit(json_encode(array('status'=>false,'tips'=>'MYSQL 主机地址 不能为空')));

			$_arr['mysql_account'] = isset($_POST["mysql_account"])?trim(safe_replace($_POST["mysql_account"])):exit(json_encode(array('status'=>false,'tips'=>'MYSQL 主机帐号 不能为空')));
			if($_arr['mysql_account']=='')exit(json_encode(array('status'=>false,'tips'=>'MYSQL 主机帐号 不能为空')));

			$_arr['mysql_password'] = isset($_POST["mysql_password"])?trim(safe_replace($_POST["mysql_password"])):exit(json_encode(array('status'=>false,'tips'=>'MYSQL 主机密码 不能为空')));
			if($_arr['mysql_password']=='')exit(json_encode(array('status'=>false,'tips'=>'MYSQL 主机密码 不能为空')));

			$_arr['mysql_db_name'] = isset($_POST["mysql_db_name"])?trim(safe_replace($_POST["mysql_db_name"])):exit(json_encode(array('status'=>false,'tips'=>'MYSQL 数据库名称 不能为空')));
			if($_arr['mysql_db_name']=='')exit(json_encode(array('status'=>false,'tips'=>'MYSQL 数据库名称 不能为空')));

			$_arr['flag'] = isset($_POST["flag"])?intval($_POST["flag"]):exit(json_encode(array('status'=>false,'tips'=>'安装出错')));
			if($_arr['flag']==0)exit(json_encode(array('status'=>false,'tips'=>'安装出错')));

            #测试MYSQL帐号

            $con=@mysql_connect($_arr['mysql_url'],$_arr['mysql_account'],$_arr['mysql_password']);
			if(!$con)
				exit(json_encode(array('status'=>false,'tips'=>'MYSQL连接错误，请检查输入信息是否正确')));
			else{

				$db_selected = mysql_select_db($_arr['mysql_db_name'], $con);

				if (!$db_selected)
				{
					exit(json_encode(array('status'=>false,'tips'=>'数据库:'.$_arr['mysql_db_name'].'不存在')));
				}


				if($_arr['flag']==1){

					//更新config
					$php_tags  = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n";
					$php_tags .= "\$config['base_url'] = ".var_export($_arr['site_url'], TRUE).";\n";
					$php_tags .= "\$config['aci_status'] = ".var_export($this->aci_status, TRUE).";\n";
					$php_tags .= "\$config['aci_module'] = ".var_export($this->aci_config, TRUE).";\n";
					$php_tags .= "\n/* End of file aci.php */\n";
					$php_tags .= "/* Location: ./application/config/aci.php */\n";

					write_file(APPPATH.'config/aci.php', $php_tags);

					$db['default'] = array(
						'dsn'	=> '',
						'hostname' => $_arr['mysql_url'],
						'username' => $_arr['mysql_account'],
						'password' => $_arr['mysql_password'],
						'database' => $_arr['mysql_db_name'],
						'dbdriver' => 'mysqli',
						'dbprefix' => '',
						'pconnect' => FALSE,
						'db_debug' => TRUE,
						'cache_on' => FALSE,
						'cachedir' => '',
						'char_set' => 'utf8',
						'dbcollat' => 'utf8_general_ci',
						'swap_pre' => '',
						'encrypt' => FALSE,
						'compress' => FALSE,
						'stricton' => FALSE,
						'failover' => array(),
						'save_queries' => TRUE
					);
					$php_tags  = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n";
					$php_tags .= "\$active_group = 'default';\n";
					$php_tags .= "\$query_builder = TRUE;\n";
					$php_tags .= "\$db['default'] = ".var_export($db['default'], TRUE).";\n";
					$php_tags .= "\n/* End of file aci.php */\n";
					$php_tags .= "/* Location: ./application/config/database.php */\n";

					write_file(APPPATH.'config/database.php', $php_tags);

					exit(json_encode(array('status'=>true,'tips'=>'OK')));

				}else{
					global $errors;


				    $sqlfile = UPLOAD_PATH."/setup/".$this->aci_status['systemVersion'].".sql";

				    if(!file_exists($sqlfile)){
				    	exit(json_encode(array('status'=>false,'tips'=>'安装SQL文件不存在')));
				    }
				    mysql_query("SET NAMES utf8");
				    $mqr = @get_magic_quotes_runtime();
				    @set_magic_quotes_runtime(0);
				    $query = fread(fopen($sqlfile, "r"), filesize($sqlfile));
				    @set_magic_quotes_runtime($mqr);
				    $pieces  = $this->split_sql($query);

				    for ($i=0; $i<count($pieces); $i++) {
				        $pieces[$i] = trim($pieces[$i]);
				        if(!empty($pieces[$i]) && $pieces[$i] != "#") {

				            if (!$result = @mysql_query ($pieces[$i])) {
				                $errors[] = array ( mysql_error(), $pieces[$i] );
				            }
				        }
				    }

				    mysql_close($con);
				    if( $errors)
				    	exit(json_encode(array('status'=>false,'tips'=>$errors)));
				    else{
				    	

						$autoload_php = UPLOAD_PATH."/setup/autoload.php";
						$string = read_file($autoload_php);

						write_file(APPPATH.'config/autoload.php', $string);
				
						//删除安装文件

						exit(json_encode(array('status'=>true,'tips'=>"安装完成")));
				    }

				}


			}



        }else
        {
        	$this->view('install');
        }
	}
}
