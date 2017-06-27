<?php
return array(
	//'配置项'=>'配置值
	//数据库配置信息
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => '127.0.0.1', // 服务器地址
	'DB_NAME'   => 'phpbc', // 数据库名
	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => 'root', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => 'think_', // 数据库表前缀 
	'DB_CHARSET'=> 'utf8', // 字符集
	'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增
    'SESSION_AUTO_START' => true, //是否开启session
	'DEFAULT_THEME'      =>    'default',
    'TMPL_DETECT_THEME' => true, // 自动侦测模板主题
	'URL_MODEL' => 2,
	'URL_HTML_SUFFIX'=>'.html',
	'DEFAULT_PATH' => '/Public/',
	'ADMIN_DEFAULT_PATH' => 'admin',//后台路径
	'DEFAULT_FILTER' => 'htmlspecialchars',
	'ADMIN_DEFAULT_PAGENUM' => '10', //后台每页数量,
	'CATCH' => '0', //缓存,开启为1
	'CATCH_TIME' => 1,//缓存时间，单位天

);