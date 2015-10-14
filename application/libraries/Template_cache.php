<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  模板解析缓存
 */
final class Template_cache {

	public $cache_path;
	public function __construct()
	{
		//$CI =& get_instance();
		$this->cache_path = APPPATH.'views';
	}

	/**
	 * 编译模板
	 *
	 * @param $module	模块名称
	 * @param $template	模板文件名
	 * @param $istag	是否为标签模板
	 * @return unknown
	 */

	public function template_compile($module, $template, $style = 'default') {

		$tplfile= APPPATH.'views'.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.$template.'.php';

		if (! file_exists ( $tplfile )) {
			show_error($tplfile ,  500 ,  'Template does not exist(1)');
		}

		$content = @file_get_contents ( $tplfile );

		$filepath = $this->cache_path.DIRECTORY_SEPARATOR.'caches_template'.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR;


	    if(!is_dir($filepath)) {
			mkdir($filepath, 0777, true);
	    }
		$compiledtplfile = $filepath.$template.'.php';
		$content = $this->template_parse($content);
		$strlen = file_put_contents ( $compiledtplfile, $content );
		chmod ( $compiledtplfile, 0777 );
		return $strlen;
	}

	/**
	 * 编译模板
	 *
	 * @param $module	模块名称
	 * @param $template	模板文件名
	 * @param $istag	是否为标签模板
	 * @return unknown
	 */

	public function template_compile_ext($source_file,$to_file) {

		$tplfile= $source_file;

		if (! file_exists ( $tplfile )) {
			show_error($tplfile ,  500 ,  'Template does not exist(1)');
		}

		$content = @file_get_contents ( $tplfile );

		$content = $this->template_parse($content);
		$strlen = file_put_contents ( $to_file, $content );
		chmod ( $to_file, 0777 );
		return $strlen;
	}

	/**
	 * 更新模板缓存
	 *
	 * @param $tplfile	模板原文件路径
	 * @param $compiledtplfile	编译完成后，写入文件名
	 * @return $strlen 长度
	 */
	public function template_refresh($tplfile, $compiledtplfile) {
		$str = @file_get_contents ($tplfile);
		$str = $this->template_parse ($str);
		$strlen = file_put_contents ($compiledtplfile, $str );
		chmod ($compiledtplfile, 0777);
		return $strlen;
	}


	/**
	 * 解析模板
	 *
	 * @param $str	模板内容
	 * @return ture
	 */
	public function template_parse($str) {
		$str = preg_replace ( "/\{template\s+(.+)\}/", "<?php include template(\\1); ?>", $str );
		$str = preg_replace ( "/\{include\s+(.+)\}/", "<?php include \\1; ?>", $str );
		$str = preg_replace ( "/\{view\s+(.+)\}/", "<?php \$this->load->view(\\1); ?>", $str );
		$str = preg_replace ( "/\{php\s+(.+)\}/", "<?php \\1?>", $str );
		//alex fix
		$str = preg_replace ( "/\{{if\s+(.+?)\}}/", "``if \\1``", $str );
		$str = preg_replace ( "/\{{else\}}/", "``else``", $str );
		$str = preg_replace ( "/\{{\/if\}}/", "``/if``", $str );

		$str = preg_replace ( "/\{if\s+(.+?)\}/", "<?php if(\\1) { ?>", $str );
		$str = preg_replace ( "/\{else\}/", "<?php } else { ?>", $str );
		$str = preg_replace ( "/\{elseif\s+(.+?)\}/", "<?php } elseif (\\1) { ?>", $str );
		$str = preg_replace ( "/\{\/if\}/", "<?php } ?>", $str );

		//for 循环
		$str = preg_replace("/\{for\s+(.+?)\}/","<?php for(\\1) { ?>",$str);
		$str = preg_replace("/\{\/for\}/","<?php } ?>",$str);
		//++ --
		$str = preg_replace("/\{\+\+(.+?)\}/","<?php ++\\1; ?>",$str);
		$str = preg_replace("/\{\-\-(.+?)\}/","<?php ++\\1; ?>",$str);
		$str = preg_replace("/\{(.+?)\+\+\}/","<?php \\1++; ?>",$str);
		$str = preg_replace("/\{(.+?)\-\-\}/","<?php \\1--; ?>",$str);
		//alex fix
		$str = preg_replace ( "/\``if\s+(.+?)\``/", "{{if \\1}}", $str );
		$str = preg_replace ( "/\``else``/", "{{else}}", $str );
		$str = preg_replace ( "/\``\/if\``/", "{{/if}}", $str );

		$str = preg_replace ( "/\{loop\s+(\S+)\s+(\S+)\}/", "<?php \$n=1;if(is_array(\\1)) foreach(\\1 AS \\2) { ?>", $str );
		$str = preg_replace ( "/\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}/", "<?php \$n=1; if(is_array(\\1)) foreach(\\1 AS \\2 => \\3) { ?>", $str );
		$str = preg_replace ( "/\{\/loop\}/", "<?php \$n++;}unset(\$n); ?>", $str );
		$str = preg_replace ( "/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/", "<?php echo \\1;?>", $str );
		$str = preg_replace ( "/\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/", "<?php echo \\1;?>", $str );
		$str = preg_replace ( "/\{(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/", "<?php echo \\1;?>", $str );
		$str = preg_replace("/\{(\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)\}/es", "\$this->addquote('<?php echo \\1;?>')",$str);
		$str = preg_replace ( "/\{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)\}/s", "<?php echo \\1;?>", $str );
		$str = preg_replace("/\{pc:(\w+)\s+([^}]+)\}/ie", "self::pc_tag('$1','$2', '$0')", $str);
		$str = preg_replace("/\{\/pc\}/ie", "self::end_pc_tag()", $str);

		$str = "<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>" . $str;
		return $str;
	}

	/**
	 * 转义 // 为 /
	 *
	 * @param $var	转义的字符
	 * @return 转义后的字符
	 */
	public function addquote($var) {
		return str_replace ( "\\\"", "\"", preg_replace ( "/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var ) );
	}

	/**
	 * 解析PC标签
	 * @param string $op 操作方式
	 * @param string $data 参数
	 * @param string $html 匹配到的所有的HTML代码
	 */
	public static function pc_tag($op, $data, $html) {
		preg_match_all("/([a-z]+)\=[\"]?([^\"]+)[\"]?/i", stripslashes($data), $matches, PREG_SET_ORDER);
		$arr = array('action','num','cache','page', 'pagesize', 'urlrule', 'return', 'start','setpages','toid');
		$tools = array('json', 'xml', 'block', 'get');
		$datas = array();
		$tag_id = md5(stripslashes($html));
		//可视化条件
		$str_datas = 'op='.$op.'&tag_md5='.$tag_id;
		foreach ($matches as $v) {
			$str_datas .= $str_datas ? "&$v[1]=".($op == 'block' && strpos($v[2], '$') === 0 ? $v[2] : urlencode($v[2])) : "$v[1]=".(strpos($v[2], '$') === 0 ? $v[2] : urlencode($v[2]));
			if(in_array($v[1], $arr)) {
				$$v[1] = $v[2];
				continue;
			}
			$datas[$v[1]] = $v[2];
		}
		$str = '';
		$setpages = isset($setpages) && intval($setpages) ? intval($setpages) : 10;
		$num = isset($num) && intval($num) ? intval($num) : 20;
		$cache = isset($cache) && intval($cache) ? intval($cache) : 0;
		$return = isset($return) && trim($return) ? trim($return) : 'data';
		if (!isset($urlrule)) $urlrule = '';
		if (!empty($cache) && !isset($page)) {
			$str .= '$tag_cache_name = md5(implode(\'&\','.self::arr_to_html($datas).').\''.$tag_id.'\');if(!$'.$return.' = tpl_cache($tag_cache_name,'.$cache.')){';
		}
		if (in_array($op,$tools)) {
			switch ($op) {
				case 'json':
						if (isset($datas['url']) && !empty($datas['url'])) {
							$str .= '$json = @file_get_contents(\''.$datas['url'].'\');';
							$str .= '$'.$return.' = json_decode($json, true);';
						}
					break;

				case 'block':
					$str .= '$block_tag = pc_base::load_app_class(\'block_tag\', \'block\');';
					$str .= 'echo $block_tag->pc_tag('.self::arr_to_html($datas).');';
					break;
			}
		} else {
			if (!isset($action) || empty($action)) return false;
			if ( file_exists(APPPATH.'libraries'.DIRECTORY_SEPARATOR.$op.'_tag.php')) {
				$str .= 'if(!isset($CI))$CI =& get_instance();$CI->load->library("'.$op.'_tag");if (method_exists($CI->'.$op.'_tag, \''.$action.'\')) {';
				if (isset($start) && intval($start)) {
					$datas['limit'] = intval($start).','.$num;
				} else {
					$datas['limit'] = $num;
				}
				if (isset($page)) {
					$str .= '$pagesize = '.$num.';';
					$str .= '$page = intval('.$page.') ? intval('.$page.') : 1;if($page<=0){$page=1;}';
					$str .= '$offset = ($page - 1) * $pagesize;$urlrule="'.$urlrule.'";';
					$datas['limit'] = '$offset.",".$pagesize';
					$datas['action'] = $action;
					$str .= '$'.$op.'_total = $CI->'.$op.'_tag->count('.self::arr_to_html($datas).');';

					$str .= 'if($'.$op.'_total>$pagesize){ $pages = pages($'.$op.'_total, $page, $pagesize, $urlrule); } else { $pages="" ;}';
				}
				$str .= '$'.$return.' = $CI->'.$op.'_tag->'.$action.'('.self::arr_to_html($datas).');';
				$str .= '}';
			}
		}
		if (!empty($cache) && !isset($page)) {
			$str .= 'if(!empty($'.$return.')){setcache($tag_cache_name, $'.$return.', \'tpl_data\');}';
			$str .= '}';
		}
		return "<"."?php ".$str."?".">";
	}

	/**
	 * PC标签结束
	 */
	static private function end_pc_tag() {
		return '<?php if(defined(\'IN_ADMIN\') && !defined(\'HTML\')) {if(isset($data))unset($data);echo \'</div>\';}?>';
	}

	/**
	 * 转换数据为HTML代码
	 * @param array $data 数组
	 */
	private static function arr_to_html($data) {
		if (is_array($data)) {
			$str = 'array(';
			foreach ($data as $key=>$val) {
				if (is_array($val)) {
					$str .= "'$key'=>".self::arr_to_html($val).",";
				} else {
					if (strpos($val, '$')===0) {
						$str .= "'$key'=>$val,";
					} else {
						$str .= "'$key'=>'".self::new_addslashes($val)."',";
					}
				}
			}
			return $str.')';
		}
		return false;
	}

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
