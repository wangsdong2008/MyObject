<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/6
 * Time: 13:29
 */
function get_moni($url){
    // 设置IP
    $header = array(
        'CLIENT-IP: 192.168.1.100',
        'X-FORWARDED-FOR: 192.168.1.100'
    );
    $data = array();
    // 设置来源
    $referer = 'http://query.sse.com.cn';
    $response = $this->moni($url, $data, $header, $referer, 5);
    return $response;
}

/**
 * 模拟提交参数，支持https提交 可用于各类api请求
 * @param string $url ： 提交的地址
 * @param array $data :POST数组
 * @param array $header: 模拟头部
 * @param string $method : POST/GET，默认GET方式
 * @return mixed
 */
function http($url, $data=array(),$referer=array(), $header=array(),$method='GET',$timeout=30){
    $curl = curl_init(); // 启动一个CURL会话
    //$user_agent = "Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)";//这里模拟的是百度蜘蛛
    $user_agent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36';
    $user_agent =  $_SERVER['HTTP_USER_AGENT'];
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT,$user_agent ); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout - 2);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回

    // 模拟来源
    if($referer){
        curl_setopt($curl, CURLOPT_REFERER, $referer);// 设置Referer
    }else{
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    }

    if($method=='POST'){
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        if($data.count()>0){
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }
    }
    $tmpInfo = curl_exec($curl); // 执行操作

    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据
}

//获取域名
function geturl($content){
    $pattern = "/(http(s)?:[\/]{2}\w+\.\w+(\.\w+)*)/is";
    preg_match_all($pattern, $content, $arr);//匹配内容到arr数组
    unset($pattern);
    return  $arr[0][0];
}


function request_get($url='',$param=''){
    if (empty($url) || empty($param)) {
        return false;
    }
    $postUrl = $url;
    $curlPost = $param;
    //初始化
    $ch = curl_init();
    //设置抓取的url
    curl_setopt($ch, CURLOPT_URL, $postUrl);
    //设置头文件的信息作为数据流输出
    curl_setopt($ch, CURLOPT_HEADER, 1);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //执行命令
    $data = curl_exec($ch);
    //关闭URL请求
    curl_close($curlPost);
    //显示获得的数据
    return $data;
}

/**
 * 模拟post进行url请求
 * @param string $url
 * @param string $param
 */
function request_post($url = '', $param = '') {
    if (empty($url) || empty($param)) {
        return false;
    }

    $postUrl = $url;
    $curlPost = $param;
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    $data = curl_exec($ch);//运行curl
    curl_close($ch);

    return $data;
}

//获取扩展名
function getExt($url){
    $urlinfo =  parse_url($url);
    $file = basename($urlinfo['path']);
    if(strpos($file,'.')!=false){
        $ext = explode('.',$file);
        return $ext[count($ext)-1];
     }
    return 'no extension';
}