<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('is_email'))
	{
		function is_email($email=''){
			
			$regex = '/^[0-9a-z][0-9a-z-._]+@{1}[0-9a-z.-]+[a-z]{2,4}$/i';
			if (preg_match($regex, $email,$match)){
				var_dump($match);
				return true;
			}
		 
			return false;
		}
		
	}
	
	if(!function_exists('is_url'))
	{
		function is_url($url=''){
			 return preg_match("/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"])*$/", $url);
		}
		
	}
	
	if(!function_exists('is_mobile'))
	{
		function is_mobile($mobile=''){

			if (strlen ( $mobile ) != 11 || ! preg_match ( '/^1[2|3|4|5|8|6|7|8|9][0-9]\d{4,8}$/', $mobile )) {
				return false;
			} else {
				return true;
			}
			
		}
		
	}
	
	if(!function_exists('is_date'))
	{
		/** 
		 * 验证日期格式是否正确 
		 * @param string $date 
		 * @param string $format 
		 * @return boolean 
		 */  
		function is_date($date,$format='Y-m-d'){  
			$t=date_parse_from_format($format,$date);  
			if(empty($t['errors'])){  
				return true;  
			}else{  
				return false;  
			}  
		} 
		
	}
	
	if(!function_exists('is_datetime'))
	{
		function is_datetime($date){
			
			if($date == date('Y-m-d H:i:s',strtotime($date)))
			  return true;
			
			 return false;
			
		}
		
	}

	if(!function_exists('site_url_ext'))
	{
		function site_url_ext($str){
			

			if(base_url()==""){
				return base_url($str);
			}
			return site_url($str);
		}
		
	}
	
	/** 
	 * 是否为时间格式
	 * @param time $value 
	 * @return boolean 
	 */ 
	if(!function_exists('is_time'))
	{
		function is_time($value=''){
			if(preg_match('/^\d{2}[:]\s*\d{2}[:]\s*\d{2}$/',$value)){  
				return true;  
			}else{  
				return false;  
			}  
			
		}
		
	}
	
	/** 
	 * 是否为整数 
	 * @param int $number 
	 * @return boolean 
	 */ 
	if(!function_exists('is_number'))
	{
		function is_number($number){
			
			if(preg_match('/^[-\+]?\d+$/',$number)){  
				return true;  
			}else{  
				return false;  
			}  
		}
		
	}
	
	/** 
	 * 是否为价格
	 * @param float $number 
	 * @return boolean 
	 */  
	if(!function_exists('is_price'))
	{
		function is_price($number=0){
			if(preg_match('/^[-\+]?\d+(\.\d+)?$/',$number)){  
				return true;  
			}else{  
				return false;  
			}  
			
		}
		
	}
	
	if(!function_exists('is_card'))
	{
		/** 
		 * 是否为合法的身份证(支持15位和18位) 
		 * @param string $card 
		 * @return boolean 
		 */  
		function is_card($card){  
			if(preg_match('/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$/',$card)||preg_match('/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{4}$/',$card))  
				return true;  
			else   
				return false;  
		} 
	}
		
	
	if(!function_exists('is_english'))
	{
		/** 
		 * 是否为英文 
		 * @param string $str 
		 * @return boolean 
		 */  
		function is_english($str){  
			if(ctype_alpha($str))  
				return true;  
			else  
				return false;  
		}  
	}
	
	if(!function_exists('is_chinese'))
	{
		/** 
		 * 是否为中文 
		 * @param string $str 
		 * @return boolean 
		 */  
		function is_chinese($str){  
			if(preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',$str))  
				return true;  
			else   
				return false;  
		} 
	}
	
	if(!function_exists('is_chinese'))
	{
		/** 
		 * 判断是否为图片 
		 * @param string $file  图片文件路径 
		 * @return boolean 
		 */  
		function is_image($file){  
			if(file_exists($file)&&getimagesize($file===false)){  
				return false;  
			}else{  
				return true;  
			}  
		} 
	}
	
	if ( ! function_exists('dir_create'))
	{
		/**
		* 创建目录
		* 
		* @param	string	$path	路径
		* @param	string	$mode	属性
		* @return	string	如果已经存在则返回true，否则为flase
		*/
		function dir_create($path, $mode = 0777) {
			if(is_dir($path)) return TRUE;
			$ftp_enable = 0;
			$path = dir_path($path);
			$temp = explode('/', $path);
			$cur_dir = '';
			$max = count($temp) - 1;
			for($i=0; $i<$max; $i++) {
				$cur_dir .= $temp[$i].'/';
				if (@is_dir($cur_dir)) continue;
				@mkdir($cur_dir, 0777,true);
				@chmod($cur_dir, 0777);
			}
			return is_dir($path);
		}
	}
	
	if ( ! function_exists('dir_path'))
	{
		/**
		* 转化 \ 为 /
		* 
		* @param	string	$path	路径
		* @return	string	路径
		*/
		function dir_path($path) {
			$path = str_replace('\\', '/', $path);
			if(substr($path, -1) != '/') $path = $path.'/';
			return $path;
		}
	}
	
	if(!function_exists('str_exists'))
	{
		/**
		 * 查询字符是否存在于某字符串
		 * 
		 * @param $haystack 字符串
		 * @param $needle 要查找的字符
		 * @return bool
		 */
		function str_exists($haystack, $needle)
		{
			return !(strpos($haystack, $needle) === FALSE);
		}
	}
	
	if(!function_exists('show_messge'))
	{
		/**
		 * 信息提示
		 * 
		 * @param $haystack 字符串
		 * @param $needle 要查找的字符
		 * @return bool
		 */
		function show_messge($msg, $needle)
		{
			return !(strpos($haystack, $needle) === FALSE);
		}
	}

	if(!function_exists('aci_ui_button'))
	{
		/**
		 * ACI UI BUTTON
		 * 
		 * @param $folder 文件夹
		 * @param $controller 控制器名
		 * @param $method action方法
		 * @param $attr 按钮内属性
		 * @param $html 按钮内文字内容
		 * @return bool
		 */
		function aci_ui_button($folder,$controller,$method,$attr,$html,$is_return=false)
		{

			global $CI;
			if($CI->current_role_priv_arr){
				$found=false;
				if($CI->group_id==SUPERADMIN_GROUP_ID)$found= true;
				if(!$found)
					foreach($CI->current_role_priv_arr as $k=>$v){
						if($v['method']==$method&&$v['controller']==$controller&&$v['folder']==$folder){
							$found=true;
							break;
						}
					}

				if($found){
					if($is_return)
					{
						return sprintf("<button %s>%s</button>",$attr,$html);
					}else
					{
						echo sprintf("<button %s>%s</button>",$attr,$html);
					}
				}
			}else{
				if(!$is_return)
					echo "";
				else
					return "";
			}

		}
	}
	
	if(!function_exists('aci_ui_a'))
	{
		/**
		 * ACI UI A
		 * 
		 * @param $folder 文件夹
		 * @param $controller 控制器名
		 * @param $method action方法
		 * @param $args GET 要有问号
		 * @param $attr 按钮内属性
		 * @param $html 按钮内文字内容
		 * @return bool
		 */
		function aci_ui_a($folder,$controller,$method,$args,$attr,$html,$is_return=false)
		{
			global $CI;
			if($CI->current_role_priv_arr){
				$found=false;
				if($CI->group_id==SUPERADMIN_GROUP_ID)$found= true;
				if(!$found)
				foreach($CI->current_role_priv_arr as $k=>$v){
					if($v['method']==$method&&$v['controller']==$controller&&$v['folder']==$folder){
						$found=true;
						break;
					}
				}

				if($found){
					$url = trim($controller)!=""?"href=\"".base_url(sprintf("%s/%s/%s/%s",trim($folder,"/"),$controller,$method,$args))."\"":"#";
					if(str_exists($method,"delete"))//如果是删除
					{
						$url = base_url(sprintf("%s/%s/%s/%s",trim($folder,"/"),$controller,$method,$args));

						if(!$is_return)
							echo sprintf("<a href=\"javascript:if(confirm('确定要删除吗'))window.location.href='%s';\" %s>%s</a>",$url,$attr,$html);
						else
							return sprintf("<a href=\"javascript:if(confirm('确定要删除吗'))window.location.href='%s';\" %s>%s</a>",$url,$attr,$html);
					}
					else
					{
						if(!$is_return)
							echo sprintf("<a %s %s>%s</a>",$url,$attr,$html);
						else
							return sprintf("<a %s %s>%s</a>",$url,$attr,$html);
					}
				}
			}else{
				if(!$is_return)
					echo "";
				else
					return "";
			}


		}
	}
	
	if(!function_exists('http_get_data'))
	{
		function http_get_data($url){
		
			$curl = curl_init();
			// 2. 设置选项，包括URL
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($curl,  CURLOPT_FOLLOWLOCATION, 1); // 302 redirect
			// 3. 执行并获取HTML文档内容
			$data = curl_exec($curl);
				if (curl_errno($curl)) {
				echo 'Err '.curl_error($curl);//捕抓异常
			}
			
			curl_close($curl);	
			
			return $data; // 返回数据
		}
		
		
		
		
		function  curl_post_302($url, $vars='') {

          $ch = curl_init();
          curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_URL,  $url);
         // curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		  curl_setopt($ch,  CURLOPT_FOLLOWLOCATION, 1); // 302 redirect
          curl_setopt($ch,  CURLOPT_POSTFIELDS, $vars);
          $data = curl_exec($ch);
          $headers =  curl_getinfo($ch);
          curl_close($ch);
          if ($data != $headers)
          return  $headers['url'];
          else
          return false;

     }
	}
	
	if(!function_exists('http_post_data'))
	{
		function http_post_data($url, $data){
			
			$curl = curl_init(); // 启动一个CURL会话
			curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
			curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
			curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
			curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
			curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
			curl_setopt($curl, CURLOPT_HEADER, array('Content-Type: application/json')); // 显示返回的Header区域内容
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
			
			$tmpInfo = curl_exec($curl); // 执行操作
			//$rescode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
			if (curl_errno($curl)) {
			   echo 'Errno'.curl_error($curl);//捕抓异常
			}
			curl_close($curl); // 关闭CURL会话
			return $tmpInfo; // 返回数据
		}
	}
	
		if(!function_exists('form_editor'))
	{
		/**
		 * 编辑器
		 * @param int $textareaid
		 * @param int $toolbar 
		 * @param string $module 模块名称
		 * @param int $catid 栏目id
		 * @param int $color 编辑器颜色
		 * @param boole $allowupload  是否允许上传
		 * @param boole $allowbrowser 是否允许浏览文件
		 * @param string $alowuploadexts 允许上传类型
		 * @param string $height 编辑器高度
		 * @param string $disabled_page 是否禁用分页和子标题
		 */
		function form_editor($textareaid = 'content', $toolbar = 'basic',  $allowupload = 0, $uploadurl = '',$alowuploadexts = '',$height = 400,$disabled_page = 0, $allowuploadnum = '10') {
			$str ='';
			if(!defined('EDITOR_INIT')) {
				$str = '<script type="text/javascript" src="'.base_url(BASE_JS_PATH.'plugs/c_k_e_d_i_t_o_r/ckeditor.js').'"></script>';
				define('EDITOR_INIT', 1);
			}
			if($toolbar == 'basic') {
				$toolbar = defined('IN_ADMIN') ? "['Source']," : '';
				$toolbar .=  "['Bold', 'Italic','Underline','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', 'Link', 'Unlink', 'FontSize', 'TextColor','BGColor'],\r\n";
			} 
			elseif($toolbar == 'blog') {
				$toolbar = defined('IN_ADMIN') ? "['Source']," : '';
				$toolbar .=  "['Source','Bold', 'Italic','Underline','Strike','-'],['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', 'Link', 'Unlink', 'FontSize', 'TextColor','BGColor','Image'],\r\n";
			} 
			elseif($toolbar == 'full') {
				if(defined('IN_ADMIN')) {
					$toolbar = "['Source',";
				} else {
					$toolbar = '[';
				}
				$toolbar .= "'-','Templates'],
			    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print'],
			    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],['ShowBlocks'],['Image','Capture','Flash'],['Maximize'],
			    '/',
			    ['Bold','Italic','Underline','Strike','-'],
			    ['Subscript','Superscript','-'],
			    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
			    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
			    ['Link','Unlink','Anchor'],
			    ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
			    '/',
			    ['Styles','Format','Font','FontSize'],
			    ['TextColor','BGColor']\r\n";
			} elseif($toolbar == 'desc') {
				$toolbar = "['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'Image', '-','Source'],\r\n";
			} else {
				$toolbar = '';
			}
			$str .= "<script type=\"text/javascript\">\r\n";
			$str .= "CKEDITOR.replace( '$textareaid',{";
			$str .= "height:{$height}, enterMode:CKEDITOR.ENTER_BR,shiftEnterMode:CKEDITOR.ENTER_BR,";
		
			$str .="pages:false,subtitle:false,textareaid:'".$textareaid."',\r\n";
			if($allowupload) {
				#$str .="flashupload:true,alowuploadexts:'".$alowuploadexts."',allowbrowser:'".$allowbrowser."',allowuploadnum:'".$allowuploadnum."',\r\n";
			}
			if(defined('IN_ADMIN')) {
				$uploadurl=site_url("adminpanel/attachments/upload/");
			}
			
			if(defined('ATTACHEMENTS_URL')) {
				$uploadurl=ATTACHEMENTS_URL;
			}
			
	        if($allowupload) $str .= "filebrowserUploadUrl :'$uploadurl' ,\r\n";
		
			$str .= "toolbar :\r\n";
			$str .= "[\r\n";
			$str .= $toolbar;
			$str .= "]\r\n";
			//$str .= "fullPage : true";
			$str .= "});\r\n";
			$str .= '</script>';
			$ext_str='';
			if(is_ie()) $ext_str .= "<div style='display:none'><OBJECT id='PC_Capture' classid='clsid:021E8C6F-52D4-42F2-9B36-BCFBAD3A0DE4'><PARAM NAME='_Version' VALUE='0'><PARAM NAME='_ExtentX' VALUE='0'><PARAM NAME='_ExtentY' VALUE='0'><PARAM NAME='_StockProps' VALUE='0'></OBJECT></div>";
			$str .= $ext_str;
			return $str;
		}
	}
	
	
	if(!function_exists('folder_controller_method_options'))
	{
		function folder_controller_method_options($folder='',$controller='',$method=''){
			
			global $CI;
			if(!isset($CI))$CI =& get_instance();
			
			$_html="";
			foreach($CI->aci_config as $k=>$v)
			{
				$_html .="<optgroup label=\"".$v['moduleCaption']."\">\n";
				foreach($v['moduleDetails'] as $mvc)
				{
					if($folder == $mvc['folder'] && $controller == $mvc['controller'] && $method == $mvc['method'])
						$_html .="<option value=\"{$mvc['folder']},{$mvc['controller']},{$mvc['method']}\" selected=\"selected\">{$mvc['folder']} > {$mvc['controller']} > {$mvc['method']}</option>\n";
					else
						$_html .="<option value=\"{$mvc['folder']},{$mvc['controller']},{$mvc['method']}\" >{$mvc['folder']} > {$mvc['controller']} > {$mvc['method']}</option>\n";
				}
				$_html .="</optgroup>\n";
			}
			return $_html;
			
		}
		
	}
	
	if(!function_exists('show_photo'))
	{
		function show_photo($url){
		
			if(str_exists($url,UPLOAD_URL))
			{
				$imgurl_replace= str_replace(UPLOAD_URL, '', $url);	
				
				if(!is_file(UPLOAD_PATH.$imgurl_replace))return IMG_PATH.'nopic.gif';
				if(!file_exists(UPLOAD_PATH.$imgurl_replace)) return IMG_PATH.'nopic.gif';
				
				return $url;
			}else
			{
				return $url;
			}
		}
	}
	
	
	if(!function_exists('process_datasource'))
	{
		function process_datasource($datalist){
			
			$new_datalist = NULL;
			if($datalist)
			{
				foreach($datalist as $k=>$v)
				{
					$n =0;
					$text_arr = $row= NULL;
				
					foreach($v as $vv)
					{
						if(count($v)>1){
							if($n==0) $row['val'] = $vv;
							else
							{
								$text_arr[]= $vv;
							}
						}
						else{
							
							$row['val'] = $vv;
							$text_arr[]= $vv;
						}
						
						$n++;
					}
					
					$row['text']  = implode("-",$text_arr);
					$new_datalist[] = $row;
				}
			}
			
			return $new_datalist;
		}
	}
	
	
	
	if(!function_exists('show_hot'))
	{
		function show_hot($v)
		{
			return  $v?"<span class='glyphicon glyphicon-heart-empty'></span>":"";
		}
	}
	
	
	if(!function_exists('show_home'))
	{
		function show_home($v)
		{
			return  $v?"<span class='glyphicon glyphicon-home'></span>":"";
		}
	}
	

	/**
	 * @检测是否开始了mod_rewite
	 * 
	 * @author Pierre-Henry Soria <ph7software@gmail.com>
	 * @copyright (c) 2013, Pierre-Henry Soria. All Rights Reserved.
	 * @return boolean
	 */
	function isRewriteMod()
	{
	  if (function_exists('apache_get_modules'))
	  {
	    $aMods = apache_get_modules();
	    $bIsRewrite = in_array('mod_rewrite', $aMods);
	  }
	  else
	  {
	    $bIsRewrite = (strtolower(getenv('HTTP_MOD_REWRITE')) == 'on');
	  }
	  return $bIsRewrite;
	}

	function curPageURL()
	{
	    $pageURL = 'http://';

	    if ($_SERVER["SERVER_PORT"] != "80")
	    {
	        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	    }
	    else
	    {
	        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	    }
	    return $pageURL;
	}
		
	
	
	