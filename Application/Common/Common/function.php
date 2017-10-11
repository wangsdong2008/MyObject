<?php
/**
 * 验证码检查
 */
function check_verify($code, $id = ""){
 $verify = new \Think\Verify();
 return $verify->check($code, $id);
}

//会员登录状态
function loginstatus(){
 $str = '';
 $username = '';
 $nameall = '';
 if(!session("userid")){
  $str = '您好，欢迎进入ASP编程网！您好，<a href="/User/login.html" class="login">请登录</a> <a href="/User/reg.html">立即注册</a>';
 }else{
  $user_data['id'] = session("userid");
  $user = M('users')->where($user_data)->field('username,phone,email')->find();
  if($user['username']) {
   if(strlen($user['username']) > 11) {
    $username = msubstr($user['username'], 0, 6);
   } else {
    $username = $user['username'];
   }
   $nameall = $user['username'];
  }
  elseif($user['email']) {
   if(strlen($user['email']) > 11) {
    $username = msubstr($user['email'], 0, 8);
   } else {
    $username = $user['email'];
   }
   $nameall = $user['email'];
  }
  elseif($user['phone']) {
   $username = substr_replace($user['phone'], '****', 3, 4);
   $nameall = $user['phone'];
  }
  $str = ' <span>您好，<a title="'.$nameall.'" href="'.U('User/index').'">'.$username.'</a>，欢迎进入ASP编程网！</span>&nbsp;&nbsp;|&nbsp;&nbsp;<span><a href="'.U('User/loginout').'">退出 </a></span>';
 }
 return $str;
}
/*
 * 发送邮件
 * @param $to string
 * @param $title string
 * @param $content string
 * @return bool
 * */
function SendMail($to, $title, $content) {
 Vendor('PHPMailer.PHPMailerAutoload');
 $mail = new PHPMailer(); //实例化
 $mail->IsSMTP(); // 启用SMTP
 $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
 $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
 $mail->Username = C('MAIL_USERNAME'); //发件人邮箱名
 $mail->Password = C('MAIL_PASSWORD') ; //163邮箱发件人授权密码
 $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
 $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
 $mail->AddAddress($to,"尊敬的客户");
 $mail->WordWrap = 50; //设置每行字符长度
 $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
 $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
 $mail->Subject =$title; //邮件主题
 $mail->Body = $content; //邮件内容
 $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
 return($mail->Send());
}

function socket_data($url){  //抓取远程html页面
 $ch = curl_init();
 $timeout = 5;
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
 $contents = curl_exec($ch);
 curl_close($ch);
 return $contents;
}

/*
* 远程抓取数据函数
*
* $url 远程URL地址 必选
* $way 1为file_get_contents抓取 2为CURL抓取 默认为1 可留空
* $$coding 编码 1为UTF-8转GBK 1为GBK转UTF-8 留空为不转换*/

function GetFile($url,$way=1,$coding){
 if($way==1){
  $str=file_get_contents($url);
 }else if($way==2){
  @$ch=curl_init();
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_HEADER,0);
  curl_setopt($ch,CURLOPT_NOBODY,false);
  curl_setopt($ch,CURLOPT_TIMEOUT,3);
  curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
  curl_setopt($ch,CURLOPT_MAXREDIRS,20);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.0)");
  $orders=@curl_exec($ch);
  @curl_close($ch);
  $str=$orders;
 }
 if($coding=="1"){
  $str=iconv("UTF-8", "GBK", $str);
 }elseif ($coding=="2"){
  $str=iconv("GBK", "UTF-8", $str);
 }
 return $str;
}

function getpagenum($count=0,$pagenum=10){
 $num = 1;
 if($count==0){
 }
 else{
  if($count % $pagenum == 0) $num = $count / $pagenum;
  else $num = (int)($count / $pagenum) + 1;
 }
 return $num;
}

//截取字符串
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)
{
 if(function_exists("mb_substr")){
  if($suffix)
   return mb_substr($str, $start, $length, $charset)."...";
  else
   return mb_substr($str, $start, $length, $charset);
 }
 elseif(function_exists('iconv_substr')) {
  if($suffix)
   return iconv_substr($str,$start,$length,$charset)."...";
  else
   return iconv_substr($str,$start,$length,$charset);
 }
 $re['utf-8'] = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";
 $re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";
 $re['gbk'] = "/[x01-x7f]|[x81-xfe][x40-xfe]/";
 $re['big5'] = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";
 preg_match_all($re[$charset], $str, $match);
 $slice = join("",array_slice($match[0], $start, $length));
 if($suffix) return $slice."…";
 return $slice;

}

//下载文件
//$file为相对路径
// $file = 'test/data2.rar' ;
function downloadfile($file){
 if ( file_exists ( $file )) {
  header ( 'Content-Description: File Transfer' );
  header ( 'Content-Type: application/octet-stream' );
  header ( 'Content-Disposition: attachment; filename=' . basename ( $file ));
  header ( 'Content-Transfer-Encoding: binary' );
  header ( 'Expires: 0' );
  header ( 'Cache-Control: must-revalidate' );
  header ( 'Pragma: public' );
  header ( 'Content-Length: ' . filesize ( $file ));
  ob_clean ();
  flush ();
  readfile ( $file );
  exit;
 }
}

//生成随机数
function myRands($num=5){
 $randArr = array();
 for($i = 0; $i < $num; $i++){
  $randArr[$i] = rand(0, 9);
  $randArr[$i + $num] = chr(rand(0, 25) + 97);
 }
 shuffle($randArr);
 return implode('', $randArr);
}

//fname为要下载的文件名
//$path为下载文件路径
function download($path=""){
 //避免中文文件名出现检测不到文件名的情况，进行转码utf-8->gbk
 $list = explode("/",$path);
 $filename=iconv('utf-8', 'gb2312', $list[count($list)-1]);
 //$path=$fpath.$filename;
 if(!file_exists($path)){//检测文件是否存在
  echo "文件不存在！";
  die();
 }
 $fp=fopen($path,'r');//只读方式打开
 $filesize=filesize($path);//文件大小
 //返回的文件(流形式)
 header("Content-type: application/octet-stream");
 //按照字节大小返回
 header("Accept-Ranges: bytes");
 //返回文件大小
 header("Accept-Length: $filesize");
 //这里客户端的弹出对话框，对应的文件名
 header("Content-Disposition: attachment; filename=".$filename);
 //================重点====================
 ob_clean();
 flush();
 //=================重点===================
 //设置分流
 $buffer=1024;
 //来个文件字节计数器
 $count=0;
 while(!feof($fp)&&($filesize-$count>0)){
  $data=fread($fp,$buffer);
  $count+=$data;//计数
  echo $data;//传数据给浏览器端
 }
 fclose($fp);
}

function gettoken(){
 $token = md5(uniqid(rand(), true));
 session("token",$token);
 return $token;
}

/**
 * 删除目录及目录下所有文件或删除指定文件
 * @param str $path   待删除目录路径
 * @param int $delDir 是否删除目录，1或true删除目录，0或false则只删除文件保留目录（包含子目录）
 * @return bool 返回删除状态
 */
function delDirAndFile($path, $delDir = FALSE) {
 $handle = opendir($path);
 if ($handle) {
  while (false !== ( $item = readdir($handle) )) {
   if ($item != "." && $item != "..")
    is_dir("$path/$item") ? delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
  }
  closedir($handle);
  if ($delDir)
   return rmdir($path);
 }else {
  if (file_exists($path)) {
   return unlink($path);
  } else {
   return FALSE;
  }
 }
}

function is_mobile(){
 $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
 $mobile_browser = '0';
 if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
  $mobile_browser++;
 if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false))
  $mobile_browser++;
 if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
  $mobile_browser++;
 if(isset($_SERVER['HTTP_PROFILE']))
  $mobile_browser++;
 $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
 $mobile_agents = array(
     'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
     'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
     'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
     'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
     'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
     'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
     'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
     'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
     'wapr','webc','winw','winw','xda','xda-'
 );
 if(in_array($mobile_ua, $mobile_agents))
  $mobile_browser++;
 if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
  $mobile_browser++;
// Pre-final check to reset everything if the user is on Windows
 if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
  $mobile_browser = 0;
// But WP7 is also Windows, with a slightly different characteristic
 if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
  $mobile_browser++;
 if($mobile_browser > 0)
  return true;
 else
  return false;
}


?>