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
function getHTML($url, $data=array(), $header=array(), $referer='', $timeout=30){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    // 模拟来源
    curl_setopt($ch, CURLOPT_REFERER, $referer);
    $response = curl_exec($ch);
    if($error=curl_error($ch)){
        die($error);
    }
    curl_close($ch);
    return $response;
}

function getHTTPS($url, $data=array(), $header=array(), $referer='', $timeout=30) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    // 模拟来源
    curl_setopt($ch, CURLOPT_REFERER, $referer);


    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

/**
 * 模拟提交参数，支持https提交 可用于各类api请求
 * @param string $url ： 提交的地址
 * @param array $data :POST数组
 * @param string $method : POST/GET，默认GET方式
 * @return mixed
 */
function http($url, $data=array(),$referer=array(), $method='GET',$timeout=30){
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout - 2);
    // 模拟来源
    curl_setopt($curl, CURLOPT_REFERER, $referer);
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

/**
 * 为方便说明，先上代码吧~ 这是今天重新封装的一个函数代码如下
 * curl POST
 * @param   string  url
 * @param   array   数据
 * @param   int     请求超时时间
 * @param   bool    HTTPS时是否进行严格认证
 * @return  string
 */
function curlPost($url, $data = array(), $timeout = 30, $CA = true) {
    $cacert = getcwd() . '/cacert.pem'; //CA根证书
    $SSL = substr($url, 0, 8) == "https://" ? true : false;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout - 2);
    if ($SSL && $CA) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书
        curl_setopt($ch, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布）
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配
    } else if ($SSL && !$CA) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //避免data数据过长问题
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}

//获取域名
function geturl($content){
    $pattern = "/(http(s)?:[\/]{2}\w+\.\w+(\.\w+)*)/is";
    preg_match_all($pattern, $content, $arr);//匹配内容到arr数组
    unset($pattern);
    return  $arr[0][0];
}

function getweburl($s,$val,$http,$u,$url,$url1,$url2){
    $new_url = "";
    if ($s == $u) {
        $new_url = $val;//加了http
    }else{
        if(substr($val,0,4)=="http"){
            //友情链接地址排除在外
        }else{
            if(substr($val,0,2) == "//"){
                $new_url = $http.$val;
            }elseif(substr($val,0,1) == "/" && strlen($val) > 1 ){
                $new_url = $u.$val;
            }elseif(substr($val,0,3) == "../"){
                $new_url = $url2."/".substr($val,3,strlen($val)-3);;
            }elseif(substr($val,0,2) == "./"){
                $new_url = $url1."/".substr($val,2,strlen($val)-2);
            }else{
                $new_url = dirname($url)."/".$val;
            }
        }
    }
    return $new_url;
}
