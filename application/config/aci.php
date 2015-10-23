<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['aci_status'] = array (
  'systemVersion' => '1.0.0',
  'installED' => false,
);
$config['aci_module'] = array (
  'welcome' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2015-10-09 20:10:10',
    'moduleName' => 'welcome',
    'modulePath' => '',
    'moduleCaption' => '首页',
    'description' => '由autoCodeigniter 系统的模块',
    'fileList' => NULL,
    'works' => true,
    'moduleUrl' => '',
    'system' => true,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => '',
        'controller' => 'welcome',
        'method' => '',
        'caption' => '欢迎界面',
      ),
    ),
  ),
  'adminpanel' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2015-10-09 20:10:10',
    'moduleName' => 'user',
    'modulePath' => 'adminpanel',
    'moduleCaption' => '后台管理中心',
    'description' => '由autoCodeigniter 系统的模块',
    'fileList' => NULL,
    'works' => true,
    'moduleUrl' => 'adminpanel/user',
    'system' => true,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'manage',
        'method' => 'index',
        'caption' => '管理中心-首页',
      ),
      1 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'manage',
        'method' => 'login',
        'caption' => '管理中心-登录',
      ),
      2 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'manage',
        'method' => 'logout',
        'caption' => '管理中心-注销',
      ),
      3 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'profile',
        'method' => 'change_pwd',
        'caption' => '管理中心-修改密码',
      ),
      4 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'manage',
        'method' => 'login',
        'caption' => '管理中心-登录',
      ),
      5 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'manage',
        'method' => 'go',
        'caption' => '管理中心-URL转向',
      ),
      6 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'manage',
        'method' => 'cache',
        'caption' => '管理中心-全局缓存',
      ),
    ),
  ),
  'user' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2015-10-09 20:10:10',
    'moduleName' => 'user',
    'modulePath' => 'adminpanel',
    'moduleCaption' => '用户 / 用户组管理',
    'description' => '由autoCodeigniter 系统的模块',
    'fileList' => NULL,
    'works' => true,
    'moduleUrl' => 'adminpanel/user',
    'system' => true,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'user',
        'method' => 'index',
        'caption' => '用户管理-列表',
      ),
      1 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'user',
        'method' => 'check_username',
        'caption' => '用户管理-检测用户名',
      ),
      2 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'user',
        'method' => 'delete',
        'caption' => '用户管理-删除',
      ),
      3 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'user',
        'method' => 'lock',
        'caption' => '用户管理-锁定',
      ),
      4 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'user',
        'method' => 'edit',
        'caption' => '用户管理-编辑',
      ),
      5 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'user',
        'method' => 'add',
        'caption' => '用户管理-新增',
      ),
      6 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'user',
        'method' => 'upload',
        'caption' => '用户管理-上传图像',
      ),
      7 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'role',
        'method' => 'index',
        'caption' => '用户组管理-列表',
      ),
      8 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'role',
        'method' => 'setting',
        'caption' => '用户组管理-权限设置',
      ),
      9 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'role',
        'method' => 'add',
        'caption' => '用户组管理-新增',
      ),
      10 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'role',
        'method' => 'edit',
        'caption' => '用户组管理-编辑',
      ),
      11 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'role',
        'method' => 'delete_one',
        'caption' => '用户组管理-删除',
      ),
    ),
  ),
  'member' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2015-10-09 20:10:10',
    'moduleName' => 'user',
    'modulePath' => 'member',
    'moduleCaption' => '用户中心',
    'description' => '由autoCodeigniter 系统的模块',
    'fileList' => NULL,
    'works' => true,
    'moduleUrl' => 'member/manage',
    'system' => true,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => 'member',
        'controller' => 'manage',
        'method' => 'index',
        'caption' => '用户中心-首页',
      ),
      1 => 
      array (
        'folder' => 'member',
        'controller' => 'manage',
        'method' => 'login',
        'caption' => '用户中心-登录',
      ),
      2 => 
      array (
        'folder' => 'member',
        'controller' => 'manage',
        'method' => 'logout',
        'caption' => '用户中心-注销',
      ),
      3 => 
      array (
        'folder' => 'member',
        'controller' => 'profile',
        'method' => 'change_pwd',
        'caption' => '用户中心-修改密码',
      ),
      4 => 
      array (
        'folder' => 'member',
        'controller' => 'manage',
        'method' => 'public_go_[0-9+]',
        'caption' => '管理中心-URL转向',
      ),
    ),
  ),
  'moduleMenu' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2015-10-09 20:10:10',
    'moduleName' => 'moduleMenu',
    'modulePath' => 'adminpanel',
    'moduleCaption' => '菜单管理',
    'description' => '由autoCodeigniter 系统的模块',
    'fileList' => NULL,
    'works' => true,
    'moduleUrl' => 'adminpanel/moduleMenu',
    'system' => true,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleMenu',
        'method' => 'index',
        'caption' => '菜单管理-列表',
      ),
      1 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleMenu',
        'method' => 'add',
        'caption' => '菜单管理-新增',
      ),
      2 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleMenu',
        'method' => 'edit',
        'caption' => '菜单管理-编辑',
      ),
      3 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleMenu',
        'method' => 'delete',
        'caption' => '菜单管理-删除',
      ),
      4 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleMenu',
        'method' => 'set_menu',
        'caption' => '菜单管理-设置菜单',
      ),
    ),
  ),
  'moduleManage' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2015-10-09 20:10:10',
    'moduleName' => 'module',
    'modulePath' => 'adminpanel',
    'moduleCaption' => '模块安装管理',
    'description' => '由autoCodeigniter 系统的模块',
    'fileList' => NULL,
    'works' => true,
    'moduleUrl' => 'adminpanel/moduleManage',
    'system' => true,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleManage',
        'method' => 'index',
        'caption' => '模块管理',
      ),
      1 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleInstall',
        'method' => 'index',
        'caption' => '模块管理-开始',
      ),
      2 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleInstall',
        'method' => 'check',
        'caption' => '模块管理-检查',
      ),
      3 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleInstall',
        'method' => 'setup',
        'caption' => '模块管理-安装',
      ),
      4 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleInstall',
        'method' => 'uninstall',
        'caption' => '模块管理-卸载',
      ),
      5 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleInstall',
        'method' => 'reinstall',
        'caption' => '模块管理-重新安装',
      ),
      6 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleInstall',
        'method' => 'delete',
        'caption' => '模块管理-删除',
      ),
    ),
  ),
  'helloWorld' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2015-10-09 20:10:10',
    'moduleName' => 'helloWorld',
    'modulePath' => 'adminpanel',
    'moduleCaption' => 'Hello World',
    'description' => '这里一个演示模块，来自于吸心大法第三章',
    'fileList' => NULL,
    'works' => true,
    'moduleUrl' => 'adminpanel/helloWorld',
    'system' => false,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'helloWorld',
        'method' => 'index',
        'menu_name' => NULL,
        'caption' => NULL,
      ),
    ),
  ),
  'loudong' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2015-10-17 18:03:52',
    'moduleName' => 'loudong',
    'modulePath' => 'adminpanel',
    'moduleCaption' => '楼栋信息',
    'description' => '由autoCodeigniter 自动生成的模块',
    'fileList' => 
    array (
      0 => 'application/views/adminpanel/loudong/edit.php',
      1 => 'scripts/adminpanel/loudong/edit.js',
      2 => 'application/views/adminpanel/loudong/readonly.php',
      3 => 'application/views/adminpanel/loudong/lists.php',
      4 => 'scripts/adminpanel/loudong/lists.js',
      5 => 'application/views/adminpanel/loudong/choose.php',
      6 => 'application/controllers/adminpanel/loudong.php',
      7 => 'application/models/loudong_model.php',
    ),
    'works' => true,
    'moduleUrl' => 'adminpanel/loudong',
    'system' => false,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'loudong',
        'method' => 'index',
        'menu_name' => '管理楼栋信息',
        'caption' => '管理楼栋信息',
      ),
      1 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'loudong',
        'method' => 'index',
        'menu_name' => '楼栋信息列表',
        'caption' => '楼栋信息列表',
      ),
      2 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'loudong',
        'method' => 'add',
        'menu_name' => '新增',
        'caption' => '新增',
      ),
      3 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'loudong',
        'method' => 'edit',
        'menu_name' => '修改',
        'caption' => '修改',
      ),
      4 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'loudong',
        'method' => 'choose',
        'menu_name' => '选择弹窗',
        'caption' => '选择弹窗',
      ),
      5 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'loudong',
        'method' => 'delete_one',
        'menu_name' => '删除单个',
        'caption' => '删除单个',
      ),
      6 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'loudong',
        'method' => 'delete_all',
        'menu_name' => '删除多个',
        'caption' => '删除多个',
      ),
      7 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'loudong',
        'method' => 'readonly',
        'menu_name' => '查看',
        'caption' => '查看',
      ),
    ),
  ),
);

/* End of file aci.php */
/* Location: ./application/config/aci.php */
