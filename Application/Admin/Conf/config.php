<?php
return array(
	//'配置项'=>'配置值
	//数据库配置信息
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => '10.1.254.91', // 服务器地址
	'DB_NAME'   => 'sq_aspbc123', // 数据库名
	'DB_USER'   => 'sq_aspbc123', // 用户名
	'DB_PWD'    => 'asp123123', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => 'think_', // 数据库表前缀 
	'DB_CHARSET'=> 'utf8', // 字符集
	'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增
    'SESSION_AUTO_START' => true, //是否开启session
	'DEFAULT_THEME'      =>    'admin', //默认模版
	'ADMIN_DEFAULT_PAGENUM' => '10', //后台每页数量
	'DEFAULT_PATH' => __ROOT__.'/Public/admin',
	'DB_FIELDS_CACHE'=>false,
	'UPlOAD_TMP' => 'upload_tmp', //临时上传目录
	'CATCH' => 1
);