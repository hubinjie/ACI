<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
define('SITE_URL', '/');#初始安装，请在这里修改,为实际目录
define('SKIN_PATH', SITE_URL.'css/');
define('SYS_STYLE',  'default');
define('EXT',  '.php');



define('BASE_CSS_PATH',  SITE_URL.'css/');
define('BASE_JS_PATH', SITE_URL.'scripts/');
define('IMG_PATH', SITE_URL.'images/');
define('UPLOAD_URL', SITE_URL.'uploadfile/');
define('UPLOAD_TEMP_URL', SITE_URL.'uploadfile/temp/');
define('UPLOAD_PATH',FCPATH.'/uploadfile/');
define('UPLOAD_TEMP_PATH',''.FCPATH.'/uploadfile/temp/');
define('INTALL_UPLOAD_TEMP_PATH',''.FCPATH.'/uploadfile/temp/install');

define('SYS_TIME', time());

define('SITE_NAME','ACI-WEB管理系统 ');
define('WEBSITE_BASE_NAME','ACI-WEB管理系统');


define('SUPERADMIN_GROUP_ID',  1);
define('REGISTER_GROUP_ID',  3);
define('DEMO_STATUS',  FALSE);//演示版本状态，有权限控制
define('SETUP_BACKUP_OVERWRITE_FILES', FALSE);#是否备份存在的模块文件


define('ADMIN_URL_PATH',  SITE_URL.'adminpanel/');
define('ADMIN_CSS_PATH',  SITE_URL.'css/adminpanel/');
define('ADMIN_IMG_PATH', SITE_URL.'images/adminpanel/');



/* End of file constants.php */
/* Location: ./application/config/constants.php */