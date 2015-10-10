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
define('SITE_URL', DIRECTORY_SEPARATOR);
define('SKIN_PATH', SITE_URL.'css'.DIRECTORY_SEPARATOR);
define('ADMIN_JS_PATH',SITE_URL.'js/adminpanel'.DIRECTORY_SEPARATOR);
define('SYS_STYLE',  'default');
define('EXT',  '.php');



define('BASE_CSS_PATH',  SITE_URL.'css'.DIRECTORY_SEPARATOR);
define('BASE_JS_PATH', SITE_URL.'scripts'.DIRECTORY_SEPARATOR);
define('IMG_PATH', SITE_URL.'images'.DIRECTORY_SEPARATOR);
define('UPLOAD_URL', '/uploadfile'.DIRECTORY_SEPARATOR);
define('UPLOAD_TEMP_URL', '/uploadfile'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR);
define('UPLOAD_PATH',FCPATH.DIRECTORY_SEPARATOR.'uploadfile'.DIRECTORY_SEPARATOR);
define('UPLOAD_TEMP_PATH',''.FCPATH.DIRECTORY_SEPARATOR.'uploadfile'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR);
define('INTALL_UPLOAD_TEMP_PATH',''.FCPATH.DIRECTORY_SEPARATOR.'uploadfile'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR.'install');

define('SYS_TIME', time());

define('TOM_APP_KEY','23059279');
define('TOM_SECRET_KEY','bbc18b0e1a02aa3185dc5d87a0c68299');
define('SITE_NAME','塔齐管理系统 ');
define('WEBSITE_BASE_NAME','塔齐管理系统');


define('SUPERADMIN_GROUP_ID',  1);

define('ADMIN_URL_PATH',  SITE_URL.'/adminpanel'.DIRECTORY_SEPARATOR);
define('ADMIN_CSS_PATH',  SITE_URL.'css/adminpanel'.DIRECTORY_SEPARATOR);
define('ADMIN_IMG_PATH', SITE_URL.'images/adminpanel'.DIRECTORY_SEPARATOR);



/* End of file constants.php */
/* Location: ./application/config/constants.php */