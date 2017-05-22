<?php
//邮件发送
return array(
	'MAIL_HOST' =>'smtp.qiye.163.com',//smtp服务器的名称
	'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
	'MAIL_USERNAME' =>'markwaymall@tenly.com',//发件人的邮箱名
	'MAIL_PASSWORD' =>'JmNBWWSJJ8tbXDu6',//163邮箱发件人授权密码
	'MAIL_FROM' =>'markwaymall@tenly.com',//发件人邮箱地址
	'MAIL_FROMNAME'=>'Markwaymall',//发件人姓名
	'MAIL_CHARSET' =>'utf-8',//设置邮件编码
	'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件
	'DEFAULT_MODULE' => 'Home',//默认访问路径
	'MODULE_ALLOW_LIST' => array('Home','Admin','MySoftAd'),

	//redis配置参数
	'redis_config' => array(
		'redis_host' => '127.0.0.1',
		'redis_port' => 6379,
		'redis_auth' => 123456
	),

	//支付宝配置参数
	'alipay_config'=>array(
		'partner' =>'2088801910914335',   //这里是你在成功申请支付宝接口后获取到的PID；2088102181686607',2088801910914335
		'key'=>'',//这里是你在成功申请支付宝接口后获取到的Key
		'sign_type'=>strtoupper('MD5'),
		'input_charset'=> strtolower('utf-8'),
		'cacert'=> getcwd().'\\cacert.pem',
		'transport'=> 'http',
	),
	//以上配置项，是从接口包中alipay.config.php 文件中复制过来，进行配置；

	'alipay'   =>array(
		//这里是卖家的支付宝账号，也就是你申请接口时注册的支付宝账号
		'seller_email'=>'gxapme6443@sandbox.com',

		//这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
		'notify_url'=>'http://www.markwaymall.com/Pay/notifyurl',

		//这里是页面跳转通知url，提交到项目的Pay控制器的returnurl方法；
		'return_url'=>'http://www.markwaymall.com/Pay/returnurl',

		//支付成功跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参payed（已支付列表）
		'successpage'=>'/User/usercenter/status/2.html',

		//支付失败跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参unpay（未支付列表）
		'errorpage'=>'/User/usercenter/status/0.html',
	),

	//微信支付
	'WEIXINPAY_CONFIG'   => array(
		'APPID'              => '', // 微信支付APPID
		'MCHID'              => 'xww@tenly.com', // 微信支付MCHID 商户收款账号
		'KEY'                => '', // 微信支付KEY
		'APPSECRET'          => '', // 公众帐号secert (公众号支付专用)
		'NOTIFY_URL'         => 'http://www.markwaymall.com/Api/Weixinpay/notify', // 接收支付状态的连接
	),

	//微博配置参数
	'WB_config'=>array(
		'WB_AKEY' =>'2850893691',   //这里是你在成功申请微博接口后获取到的PID；
		'WB_SKEY'=>'6435164e7429af1a1a5dc7cfd671ab0e',//这里是你在成功申请微博接口后获取到的Key
		'WB_CALLBACK_URL' =>'http://www.markwaymall.com/User/callback.html',//回调地址
	),

	//微信登录参数
	'weixinlogin_config' => array(
		'AppID'        => 'wx2cd895b5e2031789',
		'AppSecret'    => '9469d32422b110fb730c6a984968b387',
	),

	//QQ登录参数
	'QQlogin_config' => array(
		'appid' => '101362045',
		'appkey' =>'a8b6acec7ade74be556a27159a87e5f7',
		'callback' => 'http://www.markwaymall.com/User/qqcallback.html',
		"scope" => "get_user_info",
		"errorReport"=>true,
		"storageType"=>"file",
		"host"=>"localhost",
		"user"=>"root",
		"password"=>"root",
		"database"=>"test"
	)
);

