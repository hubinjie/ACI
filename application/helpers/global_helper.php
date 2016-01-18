<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('new_addslashes'))
{
	/**
	 * 返回经addslashes处理过的字符串或数组
	 * @param $string 需要处理的字符串或数组
	 * @return mixed
	 */
	function new_addslashes($string){
		if(!is_array($string)) return addslashes($string);
		foreach($string as $key => $val) $string[$key] = new_addslashes($val);
		return $string;
	}
}

if( ! function_exists('is_ie'))
{
	function is_ie()
	{
		$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		if((strpos($useragent, 'opera') !== false) || (strpos($useragent, 'konqueror') !== false)) return false;
		if(strpos($useragent, 'msie ') !== false) return true;
		return false;
	}
}

if ( ! function_exists('new_stripslashes'))
{
	/**
	 * 返回经stripslashes处理过的字符串或数组
	 * @param $string 需要处理的字符串或数组
	 * @return mixed
	 */
	function new_stripslashes($string) {
		if(!is_array($string)) return stripslashes($string);
		foreach($string as $key => $val) $string[$key] = new_stripslashes($val);
		return $string;
	}
}

if ( ! function_exists('template'))
{
	/**
	 * 模板调用
	 * 
	 * @param $module
	 * @param $template
	 * @param $istag
	 * @return unknown_type
	 */
	function template($module = 'aci', $template = 'index', $data = array()) {
		global $CI;
		if(!isset($CI))$CI =& get_instance();
		$tplfile= $module.DIRECTORY_SEPARATOR.$template;

		return $CI->parser->parse($tplfile,$data,true);
	}
}

if ( ! function_exists('upload_key'))
{
	/**
	 * 生成上传附件验证
	 * @param $args   参数
	 * @param $operation   操作类型(加密解密)
	 */
	
	function upload_key($args, $operation = 'ENCODE') {
		$encryption_key=get_config_item("encryption_key");
		$pc_auth_key = md5($encryption_key.$_SERVER['HTTP_USER_AGENT']);
		$authkey = sys_auth($args, $operation, $pc_auth_key);
		return $authkey;
	}
}

if(! function_exists('load_get_config_itemconfig'))
{
	function get_config_item($item) {
		global $CI;
		if(!isset($CI))$CI =& get_instance();
		return $CI->config->item($item);
	}
}

if ( ! function_exists('upload_key'))
{
	/**
	* 字符串加密、解密函数
	*
	*
	* @param	string	$txt		字符串
	* @param	string	$operation	ENCODE为加密，DECODE为解密，可选参数，默认为ENCODE，
	* @param	string	$key		密钥：数字、字母、下划线
	* @return	string
	*/
	function upload_key($txt, $operation = 'ENCODE', $key = '') {
		if($key=='')
		{
			global $CI;
			if(!isset($CI))$CI =& get_instance();
			$key=$CI->config->item("encryption_key");
		}
		$txt	= $operation == 'ENCODE' ? (string)$txt : base64_decode($txt);
		$len	= strlen($key);
		$code	= '';
		for($i=0; $i<strlen($txt); $i++){
			$k		= $i % $len;
			$code  .= $txt[$i] ^ $key[$k];
		}
		$code = $operation == 'DECODE' ? $code : base64_encode($code);
		return $code;
	}
}

if ( ! function_exists('sys_auth'))
{
	/**
	* 字符串加密、解密函数
	*
	*
	* @param	string	$txt		字符串
	* @param	string	$operation	ENCODE为加密，DECODE为解密，可选参数，默认为ENCODE，
	* @param	string	$key		密钥：数字、字母、下划线
	* @return	string
	*/
	function sys_auth($txt, $operation = 'ENCODE', $key = '') {
		if($key=='')
		{
			$key=get_config_item("encryption_key");
		}
		
		
		$txt	= $operation == 'ENCODE' ? (string)$txt : base64_decode($txt);
		$len	= strlen($key);
		$code	= '';
		for($i=0; $i<strlen($txt); $i++){
			$k		= $i % $len;
			$code  .= $txt[$i] ^ $key[$k];
		}
		$code = $operation == 'DECODE' ? $code : base64_encode($code);
		return $code;
	}
}

if ( ! function_exists('thumb'))
{
	/**
	 * 生成缩略图函数
	 * @param  $imgurl 图片路径
	 * @param  $width  缩略图宽度
	 * @param  $height 缩略图高度
	 * @param  $autocut 是否自动裁剪 默认裁剪，当高度或宽度有一个数值为0是，自动关闭
	 * @param  $smallpic 无图片是默认图片路径
	 */
	function thumb($imgurl, $width = 100, $height = 100 ,$autocut = 1, $smallpic = 'nophoto.gif')
	{
		if(empty($imgurl)||$imgurl==UPLOAD_URL||"/".$imgurl==UPLOAD_URL||trim($imgurl)=="") return IMG_PATH.$smallpic;
		if(strpos($imgurl,"/")==1)
			$imgurl_replace= str_replace(UPLOAD_URL, '', $imgurl);	
		else
			$imgurl_replace= str_replace(UPLOAD_URL, '', "/".$imgurl);	
		
		if( strpos($imgurl_replace, '://')) return $imgurl;
		
		$disk_path=str_replace('//','/',UPLOAD_PATH.$imgurl_replace);
		#echo $disk_path."<br/>";
		if(!file_exists($disk_path)) return IMG_PATH.$smallpic;
		#echo $disk_path."<br/>";
		$pt=strrpos($imgurl_replace, ".");
		
		$newimgurl = dirname($imgurl_replace).'/thumb_'.$width.'_'.$height.'_'.basename($imgurl_replace);
		if(file_exists(UPLOAD_PATH.$newimgurl))
		{
			return UPLOAD_URL.$newimgurl;
		}
		
		
		if ($pt){
			//global $CI;
			if(!isset($CI))$CI =& get_instance();
			$CI->load->library('image_lib');
			
			
			$config =array();
			$config['image_library'] = 'gd2';//(必须)设置图像库  
	        $config['source_image'] = UPLOAD_PATH.$imgurl_replace;//(必须)设置原始图像的名字/路径  
	        $config['dynamic_output'] = FALSE;//决定新图像的生成是要写入硬盘还是动态的存在  
	        $config['quality'] = '100%';//设置图像的品质。品质越高，图像文件越大  
	        $config['new_image'] = UPLOAD_PATH.$newimgurl;//设置图像的目标名/路径。  
	        $config['width'] = $width;//(必须)设置你想要得图像宽度。  
	        $config['height'] = $height;//(必须)设置你想要得图像高度  
	        $config['create_thumb'] = FALSE;//让图像处理函数产生一个预览图像(将_thumb插入文件扩展名之前)  
	       // $config['thumb_marker'] = '_thumb';//指定预览图像的标示。它将在被插入文件扩展名之前。例如，mypic.jpg 将会变成 mypic_thumb.jpg  
	        $config['maintain_ratio'] = TRUE;//维持比例  
	        $config['master_dim'] = 'auto';//auto, width, height 指定主轴线  

	        $CI->image_lib->initialize($config);  
			if (!$CI->image_lib->resize())  
        	{  
				 return IMG_PATH.$smallpic;
        	}else {
        		return UPLOAD_URL.$newimgurl;
        	}
		
		}
	}
	
	if ( ! function_exists('str_cut'))
	{
		
		/**
		 * 字符截取 支持UTF8/GBK
		 * @param $string
		 * @param $length
		 * @param $dot
		 */
		function str_cut($string, $length) {
			$string=strip_tags($string);
			$string=str_replace(array("\r", "\n","'",'"'), array('', '', '\'', '\"'), $string);
			return subString($string , 0, $length);
		}
				
	}
	
	
	if ( ! function_exists('is_ajax'))
	{
		function is_ajax()
		{
		    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
		}
	}
	
	if ( ! function_exists('format_textarea'))
	{
		function format_textarea($string)
		{
			return nl2br(str_replace('  ', '&nbsp;', htmlspecialchars($string)));
		}
	}	
	
	if ( ! function_exists('br2nl'))
	{
		function br2nl($text)
		{
		    return preg_replace('/<br\\s*?\/??>/i', '', str_replace('&nbsp;', ' ',$text));    
		}
	}
	
	if ( ! function_exists('pages'))
	{
		/**
		 * 分页函数
		 * 
		 * @param $num 信息总数
		 * @param $curr_page 当前分页
		 * @param $perpage 每页显示数
		 * @param $urlrule URL规则
		 * @param $array 需要传递的数组，用于增加额外的方法
		 * @return 分页
		 */
		function pages($num, $curr_page, $perpage = 20, $urlrule = '', $array = array(),$setpages = 10) {
			$setpages=10;
			$multipage = '<nav><ul class="pagination pagination-sm">';
			if($num > $perpage) {
				$page = $setpages+1;
				$offset = ceil($setpages/2-1);
				$pages = ceil($num / $perpage);
				
				$from = $curr_page - $offset;
				$to = $curr_page + $offset;
				$more = 0;
				if($page >= $pages) {
					$from = 1;
					$to = $pages-1;
				} else {
					if($from <= 1) {
						$to = $page-1;
						$from = 1;
					}  elseif($to >= $pages) { 
						$from = $pages-($page-2);  
						$to = $pages-1;  
					}
					$more = 1;
				} 
				$multipage .= '<li class="disabled"><span> 共 : '.$num.' 条记录</span></li>';
				if($curr_page>0) {
					//$multipage .= ' <a href="'.pageurl($urlrule, $curr_page-1, $array).'" class="previouspage"> &lt;&lt;</a>';
					if($curr_page==1) {
						//$multipage .= ' <li class="active"><span>1</span></li>';
					} elseif($curr_page>11 && $more) {
						$multipage .= ' <li><a href="'.pageurl($urlrule, 1, $array).'" class="firstpage">首页</a> <a href="'.pageurl($urlrule, $curr_page-1, $array).'" class="previouspage"> &lt;&lt;</a></li>';
					} else {
						$multipage .= ' <li><a href="'.pageurl($urlrule, 1, $array).'" class="firstpage">首页</a>  <a href="'.pageurl($urlrule, $curr_page-1, $array).'" class="previouspage"> &lt;&lt;</a></li>';
					}
				}
				for($i = $from; $i <= $to; $i++) { 
					if($i != $curr_page) { 
						$multipage .= ' <li><a href="'.pageurl($urlrule, $i, $array).'">'.$i.'</a></li>'; 
					} else { 
						$multipage .= ' <li class="active"><span>'.$i.'</span></li>'; 
					} 
				} 
				if($curr_page<$pages) {
					if($curr_page<$pages-10 && $more) {
						$multipage .= ' <li><a href="'.pageurl($urlrule, $curr_page+1, $array).'" class="nextpage">&gt;&gt;</a> <a href="'.pageurl($urlrule, $pages, $array).'">末页</a></li> ';
					} else {
						$multipage .= ' <li><a href="'.pageurl($urlrule, $pages, $array).'">'.$pages.'</a> <a href="'.pageurl($urlrule, $curr_page+1, $array).'" class="nextpage">&gt;&gt;</a></li>';
					}
				} elseif($curr_page==$pages) {
					$multipage .= ' <li class="active"><a >'.$pages.'</a></li> ';
				} else {
					$multipage .= ' <li><a href="'.pageurl($urlrule, $pages, $array).'">'.$pages.'</a> <a href="'.pageurl($urlrule, $curr_page+1, $array).'" class="nextpage"">&gt;&gt;</a></li>';
				}
			}
			return $multipage."</ul></nav>";
		}
		
		/**
		 * 返回分页路径
		 * 
		 * @param $urlrule 分页规则
		 * @param $page 当前页
		 * @param $array 需要传递的数组，用于增加额外的方法
		 * @return 完整的URL路径
		 */
		function pageurl($urlrule, $page, $array = array()) {
			
			if(strpos($urlrule, '~')) {
				$urlrules = explode('~', $urlrule);
				$urlrule = $page < 2 ? $urlrules[0] : $urlrules[1];
			}
			$findme = array('{$page}','[page]');
			$replaceme = array($page,$page);
			if (is_array($array)) foreach ($array as $k=>$v) {
				$findme[] = '{$'.$k.'}';
				$replaceme[] = $v;
			}
			
			$url = str_replace($findme, $replaceme, $urlrule);
			$url = str_replace(array('http://','//','~',' '), array('~','/','http://','+'), $url);
			
			if(str_exists($url, '?'))
			{
			}else 
			if(!empty($_SERVER["QUERY_STRING"]))$url .='?'.$_SERVER["QUERY_STRING"];
			
			return $url;
		}
	}
	
	if(! function_exists('get_url'))
	{
			/**
		 * 获取当前页面完整URL地址
		 */
		function get_url() {
			$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
			$php_self = $_SERVER['PHP_SELF'] ? safe_replace($_SERVER['PHP_SELF']) : safe_replace($_SERVER['SCRIPT_NAME']);
			$path_info = isset($_SERVER['PATH_INFO']) ? safe_replace($_SERVER['PATH_INFO']) : '';
			$relate_url = isset($_SERVER['REQUEST_URI']) ? safe_replace($_SERVER['REQUEST_URI']) : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.safe_replace($_SERVER['QUERY_STRING']) : $path_info);
			return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
		}
	}
	
	if(! function_exists('url_par'))
	{
		/**
		 * URL路径解析，pages 函数的辅助函数
		 *
		 */
		function url_par() {
			$string = $_SERVER["QUERY_STRING"];
			$pattern = '/search\=([^&]+)?/i';
			$replacement = '';
			return preg_replace($pattern, $replacement, $string);
		}
	}
	
	if(! function_exists('safe_replace'))
	{
		function _safe_replace($string) {
			
			$string = str_replace('%20','',$string);
			
			$string = str_replace('%27','',$string);
			$string = str_replace('%2527','',$string);
			$string = str_replace('*','',$string);
			$string = str_replace('"','&quot;',$string);
			$string = str_replace("'",'',$string);
			$string = str_replace('"','',$string);
			$string = str_replace(';','',$string);
			$string = str_replace('<','&lt;',$string);
			$string = str_replace('>','&gt;',$string);
			$string = str_replace("{",'',$string);
			$string = str_replace('}','',$string);
			return $string;
		}
		
		/**
		 * 安全过滤函数
		 *
		 * @param $string
		 * @return string
		 */
		function safe_replace($string) {
			
			if(!is_array($string)) return _safe_replace($string);
			foreach($string as $key => $val) $string[$key] = _safe_replace($val);
			return $string;
		}
	}
	
	if(!function_exists('is_date'))
	{
		function is_date($date,$format='Y-m-d'){  
			$t=date_parse_from_format($format,$date);  

			if(empty($t['errors'])){  
				return true;  
			}else{  
				return false;  
			}  
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
	
	if(!function_exists('link_title'))
	{
		/**
		 * 查询字符是否存在于某字符串
		 * 
		 * @param $haystack 字符串
		 * @param $needle 要查找的字符
		 * @return bool
		 */
		function link_title($title,$id=0, $date=SYS_TIME)
		{
/*			$url_title="";
			if($date<mktime(0,0,0,1,1,2012))
			{
				$url_title = str_replace('_','',$title);
				$url_title = urlencode($url_title);
			}
			else*/
				$url_title = url_title($title, 'dash', TRUE);
			
			return $url_title."_".$id;
		}
	}

	if(!function_exists('string2array'))
	{
		/**
		* 将字符串转换为数组
		*
		* @param	string	$data	字符串
		* @return	array	返回数组格式，如果，data为空，则返回空数组
		*/
		function string2array($data) {
			
			if($data == '') return array();
			
			
			return unserialize(trim($data));
		}
	}
	
	if(!function_exists('array2string'))
	{
		/**
		* 将数组转换为字符串
		*
		* @param	array	$data		数组
		* @param	bool	$isformdata	如果为0，则不使用new_stripslashes处理，可选参数，默认为1
		* @return	string	返回字符串，如果，data为空，则返回空
		*/
		function array2string($data, $isformdata = 1) {
			if($data == '') return '';
			return serialize($data);
		}
	}
	
	if(!function_exists('area_info'))
	{
		/**
		 * 得到地区信息
		 * 
		 * @param int $areaid
		 * @param int $arealist
		 */
		function area_info($areaid,$arealist=array()) {
			if(intval($areaid)==0) return '';
			global $cache_area_list;
			
			if(empty($arealist))$arealist=$cache_area_list;
			if(empty($arealist))return '';
			return isset($arealist[$areaid])?$arealist[$areaid]:NULL;
		}
		
		/**
		 * 得到地区上级信息
		 *  ...
		 * @param int $areaid
		 * @param int $arealist
		 */
		function area_parent_info($areaid,$arealist=array()) {
			if(intval($areaid)==0) return '';
			global $cache_area_list;
			
			if(empty($arealist))$arealist=$cache_area_list;
			if(empty($arealist))return '';
			return $arealist[$areaid];
		}
		
		function subarea($parentid = 0,$arealist=array()) {

			global $cache_area_list;
			if(empty($arealist))$arealist=$cache_area_list;
			if(empty($arealist))return '';
			$subarea = array();
			foreach($arealist as $id=>$area)
			{
				if($area['parentid'] == $parentid) $subarea[$id] = $area;
			}
			return $subarea;
		}
	}
	
	if(!function_exists('cat_info'))
	{
		/**
		 * 得到地区信息
		 * 
		 * @param int $areaid
		 * @param int $arealist
		 */
		function cat_info($catid,$catlist=array()) {
			if(intval($catid)==0) return '';
			global $menu_catdir_list;
			
			if(empty($catlist))$catlist=$menu_catdir_list;
			if(empty($catlist))return '';
			return $catlist[$catid];
		}
		
		/**
		 * 得到地区上级信息
		 *  ...
		 * @param int $areaid
		 * @param int $arealist
		 */
		function cat_parent_info($areaid,$arealist=array()) {
			if(intval($areaid)==0) return '';
			global $cache_area_list;
			
			if(empty($arealist))$arealist=$cache_area_list;
			if(empty($arealist))return '';
			return $arealist[$areaid];
		}
		
		function subcats($parentid = 0,$arealist=array()) {

			global $cache_area_list;
			if(empty($arealist))$arealist=$cache_area_list;
			if(empty($arealist))return '';
			$subarea = array();
			foreach($arealist as $id=>$area)
			{
				if($area['parentid'] == $parentid) $subarea[$id] = $area;
			}
			return $subarea;
		}
	}
	
	if(!function_exists('filterPid'))
	{
		/**
		 * 过滤父id
		 * 
		 */
		function filterPid($var)
		{
			return $var['parentid']==0?$var:false;
		}
	}
	
	if(!function_exists('getcache'))
	{
		function getcache($cache_name)
		{
			global $CI;
			if(!isset($CI))$CI =& get_instance();
			return $CI->cache->file->get($cache_name);
		}
	}
	
	if(!function_exists('setcache'))
	{
		function setcache($name,$data, $timesec=315576000) {
			global $CI;
			if(!isset($CI))$CI =& get_instance();
			 $CI->cache->file->save($name, $data, $timesec);
		}
	}
	
	
	if(!function_exists('sizecount'))
	{
		/**
		* 转换字节数为其他单位
		*
		*
		* @param	string	$filesize	字节大小
		* @return	string	返回大小
		*/
		function sizecount($filesize) {
			if ($filesize >= 1073741824) {
				$filesize = round($filesize / 1073741824 * 100) / 100 .' GB';
			} elseif ($filesize >= 1048576) {
				$filesize = round($filesize / 1048576 * 100) / 100 .' MB';
			} elseif($filesize >= 1024) {
				$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
			} else {
				$filesize = $filesize.' Bytes';
			}
			return $filesize;
		}
	}
	
	if(!function_exists('is_email'))
	{
		/**
		 * 判断email格式是否正确
		 * @param $email
		 */
		function is_email($email) {
			return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
		}
	}
	
	if(!function_exists('set_cookie'))
	{
		/**
		 * 设置 cookie
		 * @param string $var     变量名
		 * @param string $value   变量值
		 * @param int $time    过期时间
		 */
		function set_cookie($var, $value = '', $time = 0) {
			$time = $time > 0 ? $time : ($value == '' ? SYS_TIME - 3600 : 0);
			$s = $_SERVER['SERVER_PORT'] == '443' ? 1 : 0;

			$var = get_config_item("cookie_prefix").$var;
			$cookie_path= get_config_item("cookie_path");
			$cookie_domain= get_config_item("cookie_domain");
			$_COOKIE[$var] = $value;
			if (is_array($value)) {
				foreach($value as $k=>$v) {
					setcookie($var.'['.$k.']', sys_auth($v, 'ENCODE'), $time, $cookie_path, $cookie_domain, $s);
				}
			} else {
				setcookie($var, sys_auth($value, 'ENCODE'), $time, $cookie_path, $cookie_domain, $s);
			}
		}
	}

	if(!function_exists('get_cookie'))
	{
		/**
		 * 获取通过 set_cookie 设置的 cookie 变量 
		 * @param string $var 变量名
		 * @param string $default 默认值 
		 * @return mixed 成功则返回cookie 值，否则返回 false
		 */
		function get_cookie($var, $default = '') {
			$var = get_config_item("cookie_prefix").$var;
			return isset($_COOKIE[$var]) ? sys_auth($_COOKIE[$var], 'DECODE') : $default;
		}
	}
	
	/**
	 * ck编辑器返回
	 * @param $fn 
	 * @param $fileurl 路径
	 * @param $message 显示信息
	 */
	
	function mkhtml($fn,$fileurl,$message) {
		$str='<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$fn.', \''.$fileurl.'\', \''.$message.'\');</script>';
		exit($str);
	}
	
	/**
	 * ck编辑器返回
	 * @param $fn 
	 * @param $fileurl 路径
	 * @param $message 显示信息
	 */
	
	function alert($message) {
		$str='<script type="text/javascript">alert(\''.$message.'\');</script>';
		exit($str);
	}
	
	if(!function_exists('tags'))
	{
		function tags($value)
		{
	   	 	if($value == '') return '';
			$v = '';
			if(strpos($value, ',')===false)
			{
				$tags = explode(',', $value);
			}
			else
			{
				$tags = explode(',', $value);
			}
			foreach($tags as $tag)
			{
        		$tag=trim($tag);
				$v .= '<a href="/tag/'.urlencode($tag).'" class="keyword">'.$tag.'</a>';
			}
			return $v;
		}
	}
	
	if(!function_exists('page_list_url'))
	{
		/**
		 * 列表url规则
		 *  ...
		 * @param int $typeid
		 * @param int $catid
		 * @param int $areaid
		 * @param int $pageno
		 */
		function page_list_url($base_url,$use_baseurl=false)
		{
			if($use_baseurl)
			return SITE_URL. $base_url . '/{$page}' ;
			else
			return SITE_URL. $base_url  ;
		}
	}
	
	
	//以下四个函数为必须函数。
	function htmlSubString($content,$maxlen=300){
		 //把字符按HTML标签变成数组。
		 $content = preg_split("/(<[^>]+?>)/si",$content, -1,PREG_SPLIT_NO_EMPTY| PREG_SPLIT_DELIM_CAPTURE);
		 $wordrows=0; //中英字数
		 $outstr="";  //生成的字串
		 $wordend=false; //是否符合最大的长度
		 $beginTags=0; //除<img><br><hr>这些短标签外，其它计算开始标签，如<div*>
		 $endTags=0;  //计算结尾标签，如</div>，如果$beginTags==$endTags表示标签数目相对称，可以退出循环。
		 //print_r($content);
		 foreach($content as $value){
		  if (trim($value)=="") continue; //如果该值为空，则继续下一个值
		  if (strpos(";$value","<")>0){
		   //如果与要载取的标签相同，则到处结束截取。
		   if (trim($value)==$maxlen) {
			$wordend=true;
			continue;
		   }
		   if ($wordend==false){
			$outstr.=$value;
			if (!preg_match("/<img([^>]+?)>/is",$value) && !preg_match("/<param([^>]+?)>/is",$value) && !preg_match("/<!([^>]+?)>/is",$value) && !preg_match("/<br([^>]+?)>/is",$value) && !preg_match("/<hr([^>]+?)>/is",$value)) {
			 $beginTags++; //除img,br,hr外的标签都加1
			}
		   }else if (preg_match("/<\/([^>]+?)>/is",$value,$matches)){
			$endTags++;
			$outstr.=$value;
			if ($beginTags==$endTags && $wordend==true) break; //字已载完了，并且标签数相称，就可以退出循环。
		   }else{
			if (!preg_match("/<img([^>]+?)>/is",$value) && !preg_match("/<param([^>]+?)>/is",$value) && !preg_match("/<!([^>]+?)>/is",$value) && !preg_match("/<br([^>]+?)>/is",$value) && !preg_match("/<hr([^>]+?)>/is",$value)) {
			 $beginTags++; //除img,br,hr外的标签都加1
			 $outstr.=$value;
			}
		   }
		  }else{
		   if (is_numeric($maxlen)){ //截取字数
			$curLength=getStringLength($value);
			$maxLength=$curLength+$wordrows;
			if ($wordend==false){
			 if ($maxLength>$maxlen){ //总字数大于要截取的字数，要在该行要截取
			  $outstr.=subString($value,0,$maxlen-$wordrows);
			  $wordend=true;
			 }else{
			  $wordrows=$maxLength;
			  $outstr.=$value;
			 }
			}
		   }else{
			if ($wordend==false) $outstr.=$value;
		   }
		  }
		 }
		 //循环替换掉多余的标签，如<p></p>这一类
		 while(preg_match("/<([^\/][^>]*?)><\/([^>]+?)>/is",$outstr)){
		  $outstr=preg_replace_callback("/<([^\/][^>]*?)><\/([^>]+?)>/is","strip_empty_html",$outstr);
		 }
		 //把误换的标签换回来
		 if (strpos(";".$outstr,"[html_")>0){
		  $outstr=str_replace("[html_&lt;]","<",$outstr);
		  $outstr=str_replace("[html_&gt;]",">",$outstr);
		 }
		 //echo htmlspecialchars($outstr);
		 return $outstr;
	}
	//去掉多余的空标签
	function strip_empty_html($matches){
		 $arr_tags1=explode(" ",$matches[1]);
		 if ($arr_tags1[0]==$matches[2]){ //如果前后标签相同，则替换为空。
		  return "";
		 }else{
		  $matches[0]=str_replace("<","[html_&lt;]",$matches[0]);
		  $matches[0]=str_replace(">","[html_&gt;]",$matches[0]);
		  return $matches[0];
		 }
	}
	//取得字符串的长度，包括中英文。
	function getStringLength($text){
		 if (function_exists('mb_substr')) {
		  $length=mb_strlen($text,'UTF-8');
		 } elseif (function_exists('iconv_substr')) {
		  $length=iconv_strlen($text,'UTF-8');
		 } else {
		  preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $text, $ar);  
		  $length=count($ar[0]);
		 }
		 return $length;
	}
	/***********按一定长度截取字符串（包括中文）*********/
	function subString($text, $start=0, $limit=12) {
		 if (function_exists('mb_substr')) {
		  $more = (mb_strlen($text,'UTF-8') > $limit) ? TRUE : FALSE;
		  $text = mb_substr($text, 0, $limit, 'UTF-8');
		  return $text;
		 } elseif (function_exists('iconv_substr')) {
		  $more = (iconv_strlen($text,'UTF-8') > $limit) ? TRUE : FALSE;
		  $text = iconv_substr($text, 0, $limit, 'UTF-8');
		  //return array($text, $more);
		  return $text;
		 } else {
		  preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $text, $ar);  
		  if(func_num_args() >= 3) {  
		   if (count($ar[0])>$limit) {
			$more = TRUE;
			$text = join("",array_slice($ar[0],0,$limit));
		   } else {
			$more = FALSE;
			$text = join("",array_slice($ar[0],0,$limit));
		   }
		  } else {
		   $more = FALSE;
		   $text =  join("",array_slice($ar[0],0));
		  }
		  return $text;
		 }
	}
	
	function fix_count_view($datetime,$count)
	{
		$diff_day=floor((SYS_TIME-$datetime)/86400);
		$diff_hour=floor((SYS_TIME-$datetime)%86400/3600);
		
		if(SYS_TIME-$datetime>84600)
		{
			//10 X 已发布的天数+最后发布时间的秒数+现在时间中的小时数+实际查看的人数
			return 10*$diff_day+intval(date("s",$datetime))+intval(date("H",SYS_TIME))+$count;
		}
		//当前时间-当天发布小时差 + 实际查看的人数
		return $diff_hour+$count;
	}
}

	function get_object_vars_final($obj){
		if(is_object($obj)){
			$obj=get_object_vars($obj);
		}
		if(is_array($obj)){
			foreach ($obj as $key=>$value){
				$obj[$key]=get_object_vars_final($value);
			}
		}
		return $obj;
	}
	
	if(!function_exists('no_js'))
	{
		function no_js($str)
		{
			if(is_array($str)){
				foreach ($str as $key => $val){
					$str[$key] = nojs($val);
				}
			}else{
				$str = preg_replace ( '/\<([\/]?)script([^\>]*?)\>/si', '&lt;\\1script\\2&gt;', $str );
				
				$str = preg_replace ( '/]]\>/si', ']] >', $str );
			}
			return $str;
		}
	}
	
	if(!function_exists('convert_url_query'))
	{

		/** 
		 * Returns the url query as associative array 
		 * 
		 * @param    string    query 
		 * @return    array    params 
		 */ 
		function convert_url_query($query)
		{ 
			$queryParts = explode('&', $query); 
			
			$params = array(); 
			foreach ($queryParts as $param) 
			{ 
				$item = explode('=', $param); 
				$params[$item[0]] = htmlentities($item[1]); 
			} 
			
			return $params; 
		}
	}
	
	if(!function_exists('get_url_query'))
	{
		function get_url_query($array_query)
		{
			$tmp = array();
			 foreach($array_query as $k=>$param)
				  $tmp[] = $k.'='.$param;
			$params = implode('&',$tmp);
			 return $params;
		}
	}


	if(!function_exists('save_img_by_url'))
	{
		function save_img_by_url($url,$savePath='', $keepFileName=false,$forceExtnsion='',$overWrite=false,$enabledWatermark=false, $watermark = 'nophoto.gif'){
			
			
			$filePathInfo  =pathinfo($url);
			
			$suffix = (trim($forceExtnsion)=="")?$filePathInfo['extension']:trim($forceExtnsion);
			$extension = get_mime_by_extension($url);
			echo $extension;
			
			if(!defined("SKIP_CHECK_EXTENSION"))
			if(!in_array($extension,array('image/png','image/jpeg','image/gif','image/pjpeg'))) return NULL;
		
			if(trim($savePath)=="")$savePath = UPLOAD_TEMP_PATH.date('Y/md').'/';
			dir_create($savePath);
			
			$imgSavePath = $savePath.$filePathInfo['filename'].".".$suffix;
			if(!$keepFileName) $imgSavePath = $savePath.random_string('alnum', 6).date("Hi").$suffix;
		
			if (is_file($imgSavePath)&&$overWrite) {
				 unlink($imgSavePath);
			}else
			{
				//$data = file_get_contents($url);
				
				// 1. 初始化  
				$ch = curl_init();  
				// 2. 设置选项，包括URL  
				curl_setopt($ch, CURLOPT_URL, $url);  
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);  
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
				curl_setopt($ch, CURLOPT_HEADER, 0);  
				// 3. 执行并获取HTML文档内容  
				$data = curl_exec($ch);  
				// 4. 释放curl句柄  
				curl_close($ch);  
	
				 if(! write_file($imgSavePath, $data))
				 {
					 return NULL;
				 }
			}
			 
			 if ($enabledWatermark){
				//global $CI;
				if(!isset($CI))$CI =& get_instance();
				$CI->load->library('image_lib');
				
				$config =array();
				$config['image_library'] = 'gd2';//(必须)设置图像库  
				$config['source_image'] = $imgSavePath;//(必须)设置原始图像的名字/路径  
				$config['dynamic_output'] = FALSE;//决定新图像的生成是要写入硬盘还是动态的存在  
				$config['quality'] = '100%';//设置图像的品质。品质越高，图像文件越大  
				$config['new_image'] = $imgSavePath;//设置图像的目标名/路径。  
				$config['width'] = $width;//(必须)设置你想要得图像宽度。  
				$config['height'] = $height;//(必须)设置你想要得图像高度  
				$config['create_thumb'] = FALSE;//让图像处理函数产生一个预览图像(将_thumb插入文件扩展名之前)  
			   // $config['thumb_marker'] = '_thumb';//指定预览图像的标示。它将在被插入文件扩展名之前。例如，mypic.jpg 将会变成 mypic_thumb.jpg  
				$config['maintain_ratio'] = TRUE;//维持比例  
				$config['master_dim'] = 'auto';//auto, width, height 指定主轴线  
	
				$CI->image_lib->initialize($config);  
				if (!$CI->image_lib->resize())  
				{  
					 return UPLOAD_TEMP_URL.date('Y/md').'/'.random_string('alnum', 6).date("Hi").".".$suffix;
				}else {
					return UPLOAD_TEMP_URL.date('Y/md').'/w'.random_string('alnum', 6).date("Hi").".".$suffix;
				}
			
			}
			return str_replace(UPLOAD_TEMP_PATH,UPLOAD_TEMP_URL,$imgSavePath);
		 }
	}

	if(!function_exists('callback_json_js'))
	{
		function callback_json_js($callback_name,$data)
		{
			if($callback_name=="") return  json_encode($data);

			return $callback_name."(".(json_encode($data).")");
		}
	}
		

	

