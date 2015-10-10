<?php 
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

if ( ! function_exists('dir_copy'))
{
	/**
	* 拷贝目录及下面所有文件
	* 
	* @param	string	$fromdir	原路径
	* @param	string	$todir		目标路径
	* @return	string	如果目标路径不存在则返回false，否则为true
	*/
	function dir_copy($fromdir, $todir) {
		$fromdir = dir_path($fromdir);
		$todir = dir_path($todir);
		if (!is_dir($fromdir)) return FALSE;
		if (!is_dir($todir)) dir_create($todir);
		$list = glob($fromdir.'*');
		if (!empty($list)) {
			foreach($list as $v) {
				$path = $todir.basename($v);
				if(is_dir($v)) {
					dir_copy($v, $path);
				} else {
					copy($v, $path);
					@chmod($path, 0777);
				}
			}
		}
	    return TRUE;
	}
}	

if ( ! function_exists('dir_iconv'))
{
	/**
	* 转换目录下面的所有文件编码格式
	* 
	* @param	string	$in_charset		原字符集
	* @param	string	$out_charset	目标字符集
	* @param	string	$dir			目录地址
	* @param	string	$fileexts		转换的文件格式
	* @return	string	如果原字符集和目标字符集相同则返回false，否则为true
	*/
	function dir_iconv($in_charset, $out_charset, $dir, $fileexts = 'php|html|htm|shtml|shtm|js|txt|xml') {
		if($in_charset == $out_charset) return false;
		$list = dir_list($dir);
		foreach($list as $v) {
			if (preg_match("/\.($fileexts)/i", $v) && is_file($v)){
				file_put_contents($v, iconv($in_charset, $out_charset, file_get_contents($v)));
			}
		}
		return true;
	}
}


if ( ! function_exists('dir_list'))
{
	/**
	* 列出目录下所有文件
	* 
	* @param	string	$path		路径
	* @param	string	$exts		扩展名
	* @param	array	$list		增加的文件列表
	* @return	array	所有满足条件的文件
	*/
	function dir_list($path, $exts = '', $list= array()) {
		$path = dir_path($path);
		$files = glob($path.'*');
		foreach($files as $v) {
			$fileext = fileext($v);
			if (!$exts || preg_match("/\.($exts)/i", $v)) {
				$list[] = $v;
				if (is_dir($v)) {
					$list = dir_list($v, $exts, $list);
				}
			}
		}
		return $list;
	}
}


if ( ! function_exists('dir_touch'))
{
	/**
	* 设置目录下面的所有文件的访问和修改时间
	* 
	* @param	string	$path		路径
	* @param	int		$mtime		修改时间
	* @param	int		$atime		访问时间
	* @return	array	不是目录时返回false，否则返回 true
	*/
	function dir_touch($path, $mtime = TIME, $atime = TIME) {
		if (!is_dir($path)) return false;
		$path = dir_path($path);
		if (!is_dir($path)) touch($path, $mtime, $atime);
		$files = glob($path.'*');
		foreach($files as $v) {
			is_dir($v) ? dir_touch($v, $mtime, $atime) : touch($v, $mtime, $atime);
		}
		return true;
	}
}

if ( ! function_exists('dir_tree'))
{
	/**
	* 目录列表
	* 
	* @param	string	$dir		路径
	* @param	int		$parentid	父id
	* @param	array	$dirs		传入的目录
	* @return	array	返回目录列表
	*/
	function dir_tree($dir, $parentid = 0, $dirs = array()) {
		global $id;
		if ($parentid == 0) $id = 0;
		$list = glob($dir.'*');
		foreach($list as $v) {
			if (is_dir($v)) {
	            $id++;
				$dirs[$id] = array('id'=>$id,'parentid'=>$parentid, 'name'=>basename($v), 'dir'=>$v.'/');
				$dirs = dir_tree($v.'/', $id, $dirs);
			}
		}
		return $dirs;
	}
}

if ( ! function_exists('dir_delete'))
{
	/**
	* 删除目录及目录下面的所有文件
	* 
	* @param	string	$dir		路径
	* @return	bool	如果成功则返回 TRUE，失败则返回 FALSE
	*/
	function dir_delete($dir) {
		$dir = dir_path($dir);
		if (!is_dir($dir)) return FALSE;
		$list = glob($dir.'*');
		foreach($list as $v) {
			is_dir($v) ? dir_delete($v) : @unlink($v);
		}
	    return @rmdir($dir);
	}
}

if ( ! function_exists('file2zip'))
{

	/**
	*@desc  生成zip压缩文件的函数
	*
	*@param $dir             string 需要压缩的文件夹名
	*@param $filename     string 压缩后的zip文件名  包括zip后缀
	*@param $exts      array   允许的文件扩展
	*@param $addFiles  array   额外自定义压缩文件    
	*/
	function file2zip($dir,$filename,$exts=array(),$addFiles=array()){
		if(!file_exists($dir) || !is_dir($dir)){
			die(' can not exists dir '.$dir);
		}
		
		$dir = str_replace('\\','/',$dir);
		$filename = str_replace('\\','/',$filename);
		$files = array();
		getfiles($dir,$files);
		
		if(empty($files)){
			die(' the dir is empty');
		}
		
		
			$zip = new ZipArchive;
			$res = $zip->open($filename, ZipArchive::OVERWRITE);
			if ($res === TRUE) {
					foreach($files as $v){
						$_pathinfo = pathinfo($v);
						$extension = $_pathinfo['extension'];
						if(!empty($exts))
						{
							 if(in_array($extension,$exts)) 
							{
								if(file_exists($v))
								{
									$_path = str_replace($dir,'zip',$v);
									
									$zip->addFile($v,$_path);
								}
								 
							}
						}
					}
					if(!empty($addFiles)){
						foreach($addFiles as $k=>$v){
							
							$_path = str_replace($dir,'',$v);
							if(file_exists($k))$zip->addFile($k,$_path);
					}
				}
			
				$zip->close();
				return true;
			} else {
				
				return false;
			}
	}
}

if ( ! function_exists('getfiles'))
{
	function getfiles($dir,&$files=array()){
		if(!file_exists($dir) || !is_dir($dir)){return;}
		if(substr($dir,-1)=='/'){
			$dir = substr($dir,0,strlen($dir)-1);
		}
		
		$_files = scandir($dir);
		foreach($_files as $v){
			if($v != '.' && $v!='..'){
				if(is_dir($dir.'/'.$v)){
					getfiles($dir.'/'.$v,$files);
				}
				else
				{
					$files[] = ($dir=='.'?'':$dir.'/'.$v);
				}
			}
		}
		return $files;
	} 
}

if ( ! function_exists('file_download'))
{

	/**
	 * 文件下载
	 * @param $filepath 文件路径
	 * @param $filename 文件名称
	 */
	
	function file_download($filepath, $filename = '') {
		if(!$filename) $filename = basename($filepath);
		if(is_ie()) $filename = rawurlencode($filename);
		$filetype = strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
		$filesize = sprintf("%u", filesize($filepath));
		if(ob_get_length() !== false) @ob_end_clean();
		header('Pragma: public');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: pre-check=0, post-check=0, max-age=0');
		header('Content-Transfer-Encoding: binary');
		header('Content-Encoding: none');
		header('Content-type: '.$filetype);
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		header('Content-length: '.$filesize);
		readfile($filepath);
		exit;
	}
}

	
