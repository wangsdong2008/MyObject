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
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout - 2);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
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
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
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

function getweburl($s,$val,$u,$url,$url1,$url2){
    $new_url = "";
    if ($s == $u) {
        $new_url = $val;//加了http
    }else{
        if(substr($val,0,5)=="http:"||substr($val,0,5)=="https"||substr($val,0,10)=="javascript"||strlen($val)==1){
            //友情链接地址排除在外
        }else{
            if(substr($val,0,2) == "//"){
                $new_url = explode(":",$u)[0].":".$val;
            }elseif(substr($val,0,1) == "/"){
                $new_url = $u.$val;
            }elseif(substr($val,0,3) == "../"){
                $new_url = $url2."/".substr($val,3,strlen($val)-3);;
            }elseif(substr($val,0,2) == "./"){
                $new_url = $url1."/".substr($val,2,strlen($val)-2);
            }else{
                $new_url = $url.$val;
            }
        }
    }
    return $new_url;
}
