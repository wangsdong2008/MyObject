<?php
namespace Links\Controller;
use Think\Controller;
class IndexController extends Controller {
    /*public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }*/

    private $flg = 0; //付费情况

    public function getImagesPath($url,$g_url){
        $str = "";
        if($url==""||$g_url==""){
        }else{
            $list1 = explode("/",$g_url);
            $list2 = explode("/",$url);
            $num = 0;
            foreach($list2 as $key => $val){
                if($list2[$key] == $list1[$key]){
                    //不管
                }else{
                    $num = count($list2)-$key-1;
                    break;
                }
            }
            for($i=0;$i<$num;$i++){
                $str .="../";
            }
        }
        //$str .="images/";
        return $str;
    }

    public function index(){
        $this->display('index');
    }

    public function getss($content,$url){
        $domain = geturl($url);
        $pattern="/ (href=|src=|action=|url\()('|\")?([^'\"\) ]+)('|\"|\)| )?/is";//正则
        preg_match_all($pattern, $content, $arr);//匹配内容到arr数组
        $html = preg_split($pattern,$content);
        $str2 = "";
        $j = 0;
        $array = array();
        foreach($html as $key => $val){
            $str2 .= $html[$key]." ".$arr[1][$key] . $arr[2][$key] . $this->getWebUrl($arr[3][$key],$url) . $arr[4][$key];
        }
        $ht = str_replace("</html> ".$url."/","</html>",$str2);
        $ht = str_replace("</html> ".$url,"</html>",$ht);

        print_r($ht);exit;
        //$array['html'] = $ht;
        $arr2 = array();
        print_r($arr[3]);
        foreach($arr[3] as $key => $val){
            $v = $this->getWebUrl($val,$url,1);
            //暂时屏蔽
            if($v != ""){
                $arr2[$j] = $v;
                $j++;
            }
        }
        print_r($arr2);exit;
        $j=0;
        //查询重复
        foreach(array_unique($arr2) as $key => $val){ //重新输入下标
            //去掉自己
           // if($val != $url){// && $val != $url."/"&&geturl($val)==$domain
                $array['link'][$j]['url'] = $val;
                $array['link'][$j]['real_url'] = str_replace($url,'',$val);
                $j++;
           // }
        }
        print_r($array);exit;
        return json_encode($array);
    }
    public function getlinks2(){
        $url = I('url','');
        $u = geturl($url);
        $pagecode = I('pagecode',"utf-8");
        $post = I('post','get');
        if($u == $url){
            $s = $url."/";
            $url1 = $s;
            $url2 = $s;
            $url = $s;
        }else{
            $s = $url."a";
            $url1 = dirname($s)."/";
            if($url1 == $u."/"){
                $url2 = $url1;
            }
            else{
                $url2 = dirname(dirname($s))."/";
            }
        }
        $referer = I('referer','');
        $header = array();
        $data = array();
        $array = array();
        $content = "";
        if($url!=''){
            $content = http($url, $data,$referer, $header,$post,30);
            //补齐链接
            $content = $this->getss($content,$url);


            if($this->flg == 1){
                $pattern="/(a href| action)=('|\")?([^'\"]+)('|\")?/is";//正则
                preg_match_all($pattern, $content, $arr);//匹配内容到arr数组

                //此处扣除费用
                //费用扣除完成
                //获取内部链接
                $j = 0;
                foreach($arr[3] as $key => $val){
                    $s = geturl($val);
                    $new_url = getweburl($s,$val,$u,$url,$url1,$url2);
                    if($new_url != ""&&($new_url!=$url||$new_url!=$url."/")){
                        $array['link'][$j]['url'] = $new_url;
                        $array['link'][$j]['real_url'] = $val;
                        $j++;
                    }
                };


                //获取css
                $j = 0;
                $pattern="/href=('|\")?([^'\"]+\.css)('|\")?/is";//正则
                preg_match_all($pattern, $content, $arr);//匹配内容到arr数组
                foreach($arr[2] as $key => $val){
                    $s = geturl($val);
                    $new_url = getweburl($s,$val,$u,$url,$url1,$url2);
                    if($new_url!=""){
                        $array['css'][$j]['url'] = $new_url;
                        $array['css'][$j]['real_url'] = $val;
                        $j++;
                    }
                }

                //获取images
               /* $j = 0;
                $pattern="/('|\")?([^'\"]+(\.jpg|\.gif|\.png))('|\")?/is";//正则
                preg_match_all($pattern, $content, $arr);//匹配内容到arr数组
                foreach($arr[2] as $key => $val){
                    $s = $this->geturl($val);
                    $new_url = $new_url = getweburl($s,$val,$http,$u,$url,$url1,$url2);
                    if($new_url!=""){
                        $array['img'][$j]['url'] = $new_url;
                        $array['img'][$j]['real_url'] = $val;
                        $j++;
                    }
                }

                //获取js
                $j = 0;
                $pattern="/('|\"|\()([^'\"]+\.js)('|\"|\))/is";//正则
                preg_match_all($pattern, $content, $arr);//匹配内容到arr数组
                foreach($arr[2] as $key => $val){
                    $s = geturl($val);
                    $new_url = getweburl($s,$val,$u,$url,$url1,$url2);
                    if($new_url!=""){
                        $array['js'][$j]['url'] = $new_url;
                        $array['js'][$j]['real_url'] = $val;
                        $j++;
                    }
                }*/
            }

        }

        //除去重复的链接
        $arr = array();
        foreach($array as $key => $val){
            $j = 0;
            foreach($val as $key1 => $val2){
                $url = $val2['url'];
                $p=0;
                for($k = $key1+1; $k < count($val)-1; $k++){
                    $url0 = $val[$k]['url'];
                    if($url == $url0){
                        $p = 1;
                        break;
                    }
                }
                if($p == 0){
                    $arr[$key][$j]['url'] = $url;
                    $arr[$key][$j]['real_url'] = $array[$key][$key1]['real_url'];
                    $content = str_replace($arr[$key][$j]['real_url'],$arr[$key][$j]['url'],$content);
                    $j++;
                }
            }
        }
        //$arr['html'] = $contents=iconv('gbk', 'utf-8', str_replace("\r\n","###",str_replace('"',"@@@",$content)));

        if($pagecode == "gb2312"){
            $arr['html'] = iconv('gbk', 'utf-8', $content);
        }
        else{
            $arr['html'] = $content;
        }
        print_r($arr['html']);exit;
        if(count($arr)>0){
            $arr['status'] = 1;
        }else{
            $arr['status']=0;
        }

        unset($array,$j,$p,$k,$key);
        print_r($arr);exit;
        // echo json_encode($arr);
    }

    public function getlinks(){
        $url = I('url','');
        $g_url = $url;
        $post = I('post','get');
        $referer = I('referer','');
        $pagecode = I('pagecode','utf-8');
        $status = 3;
        //session("ff",null);
        if(session("ff")){//是否登录过
            $this->flg = 1;
        }else{
            $username = I('username','');
            $code = I('codes','');

            $bzUserslist = D('bzusers')->showBzusersFromUsername($username);
            if(!$bzUserslist){//用户不存在
                $status = 0;
            }else{
                if($code != md5($username.$bzUserslist['regtime'].$bzUserslist['mycode'])){
                    $status = 1;
                }else{
                    //检查一下是否采集过
                    if(!session("ff")){ //
                        $pid = D('bzuser_url')->getcaiurl($bzUserslist['id'],$this->getdomain($url));
                        if($pid>0){
                            $status = 3;
                            $this->flg = 1;
                            session("ff",$bzUserslist['id']);
                        }
                        else{
                            if($bzUserslist['num'] <= 0){ //次数必须大于0
                                $status = 2;
                            }else{
                                $status = 3;
                                if($bzUserslist['islock'] == 1){
                                    $this->flg = 0; //测试账号
                                }else{
                                    $this->flg = 1; //正式账号
                                }
                                session("ff",$bzUserslist['id']);
                                //扣除次数
                                D('bzusers')->updatenum($bzUserslist['id']);
                                //记录下来
                                D('bzuser_url')->bzuser_urlSave(array('bzuserid'=>$bzUserslist['id'],'url'=>$this->getdomain($url)));

                            }
                        }
                    }
                }
            }
        }
        $arr['status'] = $status;
        if($status*1 < 3){
            echo json_encode($arr);
            exit;
        }
        $header = array();
        $data = array();
        $array = array();
        $content2 = "";
        if($url!='') {
            $content = http($url, $data, $referer, $header, $post, 30);
            $content2 = $this->get1($content,$url,$this->flg,$g_url);
        }
        unset($array,$j,$p,$k,$key);
        echo json_encode($content2);
    }

    private function get1($content,$url,$flg,$g_url){
        $j=0;
        $array = array();
        $ext = getExt($url);
        if($ext == "no extension")
            $array['filename'] = "index";
        else{
            $array['filename'] = basename($url);//这里要注意
        }

        //补齐图片，js链接
        $pattern="/ (src=|url\()('|\")?([^'\"\) ]+)('|\"|\)| )?/is";//图片正则
        preg_match_all($pattern, $content, $pic_arr);//匹配内容到arr数组
        $html = preg_split($pattern,$content);
        $str2 = "";
        foreach($html as $key => $val){
            $str2 .= $html[$key]." ".$pic_arr[1][$key] . $pic_arr[2][$key] . $this->getWebUrl($pic_arr[3][$key],$url) . $pic_arr[4][$key];
        }
        $content = $str2;
        //补齐图片，js链接结束
        //图片链接
        foreach($pic_arr[3] as $key => $v1){
            $array['Resources'][$j]['url'] = $this->getWebUrl($v1,$url);
            $replace_val = $this->getxdpath($v1,$url);
            $array['Resources'][$j]['real_url'] = $replace_val;
            $content = str_replace($this->getWebUrl($v1,$url),"".$replace_val,$content); //替换图片地址
            $j++;
        }

        //补齐CSS链接
        $pattern="/<link([\w+ '\"\=\/\(\)-:]+)href=('|\")?(([^'\" ]+)\.css)('|\"| )?/is";//css正则
        preg_match_all($pattern, $content, $css_arr);//匹配内容到arr数组
        $html = preg_split($pattern,$content);
        $str2 = "";
        foreach($html as $key => $val){
            $str2 .= $html[$key]."<link". $css_arr[1][$key] ."href=". $css_arr[2][$key] . $this->getWebUrl($css_arr[3][$key],$url) . $css_arr[5][$key];
        }
        $content = $str2;
        //补齐css链接结束       

        //补齐内部链接
        $pattern="/<(a|form)[\w+ '\"\=\/-:]+(href|action)=('|\")?([^'\" ]+)('|\"| )?/is";
        preg_match_all($pattern, $content, $link_arr);//匹配内容到arr数组
        //补齐链接
        $str3 = "";
        $html2 = preg_split($pattern,$content);
        foreach($html2 as $key => $val){
            $str3 .= $html2[$key]."<".$link_arr[1][$key] ." ". $link_arr[2][$key]  ."=". $link_arr[3][$key] .$this->getWebUrl($link_arr[4][$key],$url) . $link_arr[5][$key];
        }
        $content = $str3;
        //补齐内部链接结束
        $arr1 = array();
        $k = 0;
        foreach($link_arr[4] as $key => $val){
            $val = trim($val);
            if(substr($val,0,7)!="mailto:" && geturl($val)!=geturl($g_url) && substr($val,0,11)!="javascript:" && substr($val,0,1) != "#" && $val != $url && $val != $url."/" && $val != "/") {
                if($this->getWebUrl($val,$url)!=""){
                    $arr1[$k]['url'] = $this->getWebUrl($val,$url);
                    $replace_val = $this->getxdpath($val,$url);
                    $arr1[$k]['real_url'] = $replace_val;
                    $k++;
                }
            }
        }

        //二维数据按url长度排序
        usort($arr1, function($a, $b) {
            $al = strlen($a['url']);
            $bl = strlen($b['url']);
            if ($al == $bl)
                return 0;
            return ($al > $bl) ? -1 : 1;
        });

        //查询重复
		$k = 0;
        foreach(array_unique($arr1,SORT_REGULAR) as $key => $val){ //重新输入下标
            $array['links'][$k]['url'] = $val['url'];
            $array['links'][$k]['real_url'] = $val['real_url'];
            $content = str_replace($val['url'],$val['real_url'],$content);
            $k++;
        }

		//获取css
        $ii=0;
        $jj = $j;
        $str3 = "";
        foreach($css_arr[3] as $key => $val){
            $array['css'][$ii]['url'] = $this->getWebUrl($val,$url);
            $current_css = $this->getWebUrl($val,$url);
            $replace_val = $this->getxdpath($val,$url);
            $array['css'][$ii]['real_url'] = $replace_val;
            $content = str_replace($this->getWebUrl($val,$url),"".$replace_val,$content); //替换图片地址
           if($flg == 1){
                //获取替换后的CSS
                $content1 = http($this->getWebUrl($val,$url));
                $pattern="/background(-image)?:( )?url('|\"|\()?([^'\"\) ]+)('|\"|\))?/is";//正则
                preg_match_all($pattern, $content1, $arr3);//匹配内容到arr数组

                //补齐图片链接
                $html2 = preg_split($pattern,$content1);
                foreach($html2 as $key => $val){
                    $str3 .= $html2[$key]." background".$arr3[1][$key] .":url". $arr3[2][$key]  . $arr3[3][$key] .$this->getWebUrl($arr3[4][$key],$url) . $arr3[5][$key];
                }
                $str3 = str_replace('background'.$url.'/','',$str3);
                //补齐图片链接结束

                //使用替换后的图片地址替换掉
                foreach($arr3[4] as $key => $v){
                    $array['Resources'][$jj]['url'] = $this->getWebUrl($v,$current_css);
                    //$replace_val = $this->getxdpath($v,$url);
                    $replace_val = $this->getxdpath($v,$current_css);
                    $array['Resources'][$jj]['real_url'] = $replace_val;
                    $str3 = str_replace($this->getWebUrl($v,$url),"..".$replace_val,$str3); //替换图片地址
                    $jj++;
                }
                $array['css'][$ii]['content']  = urlencode($str3);
                unset($arr3,$str3,$html2);
            }else{
                //获取替换前的CSS
                $array['css'][$ii]['content']  = urlencode(http($val));
            }
            //$content = str_replace($val,$replace_val,$content);
            $ii++;
        }

		
        $array['status'] = 3;
        $ht = explode("</html>",$content);
        $content = $ht[0]."</html>";
        $array['html'] = urlencode($content);
        unset($pattern,$str2,$replace_val);

        return $array;

    }

    private function getxdpath($current_url,$url){
        if($current_url == "") return "";
        $ext = getExt($current_url);
        switch($ext){
            case "jpeg":
            case "jpg":
            case "gif":
            case "png":
            case "ico":
                $new_url = "/images/".basename($current_url,$ext).$ext;
                break;
            case "css":
                $new_url = "/css/".basename($current_url,$ext).$ext;
                break;
            case "js":
                $new_url = "/js/".basename($current_url,$ext).$ext;
                break;
            case "swf":
            case "mp4":
                $new_url = "/upload/".basename($current_url,$ext).$ext;
                break;
            case "html":
            case "htm":
            case "asp":
            case "php":
            case "jsp":
            case "do":
                 $new_url = str_replace(geturl($url)."/","",$this->getWebUrl($current_url,$url));
                 $pathinfo = pathinfo($new_url);
                 if($pathinfo[dirname] == "."){
                     $p2 = "";
                 }else{
                     $p2 = $pathinfo[dirname]."/";
                 }
                 $new_url = "/".$p2.basename($current_url,$ext)."html";
                 unset($pathinfo);
                 break;
            default:{
                $new_url = "/".str_replace(geturl($url)."/","",$this->getWebUrl($current_url,$url));
                //目录
                $new_url .= "/index.html";
                break;
            }
        }
        /*$new_url = str_replace(geturl($url)."/","",$this->getWebUrl($current_url,$url));
        $new_url = str_replace(geturl($url)."/","",$this->getWebUrl($current_url,$url));*/
        return $new_url;
    }


    /*public function t1(){
        $url = "https://bbb.aaa.xinhongru.oss-cn-beijing.aliyuncs.com/upload/13.png";
        $a = $this->getdomain($url);
        print_r($a);
    }*/

    private function getdomain($url){  //获取主域名
        $pattern = "/http(s)?:[\/]{2}([^\.]+\.)*(\w+\.\w+)/is";
        preg_match_all($pattern, $url, $arr);//匹配内容到arr数组
        unset($pattern);
        return  $arr[3][0];
    }

    public function getWebUrl($current_url,$domain_url){ //补齐域名
        $domain = geturl($domain_url);       //域名
        $http = explode(":",$domain_url)[0]; //是http还是https
        $url1 = "";//本级地址
        $url2 = "";//上级地址
        if($domain == $domain_url){
            $url1 = $domain_url."/";
            $url2 = $domain_url."/";
        }else{
            $url1 = dirname($domain_url)."/";
            if($url1 == $domain."/"){
                $url2 = $url1;
            }
            else{
                $url2 = dirname(dirname($domain_url))."/";
            }
        }
        //$new_url = "";
        if ($domain == geturl($current_url)) {
            $new_url = $current_url;//加了http的完整地址
        }else{
            if(substr($current_url,0,5)=="http:" || substr($current_url,0,5)=="https"){
                //友情链接地址排除在外
                if($this->getdomain($current_url != $this->getdomain($domain_url))){ //域名不一样
                    $new_url = $current_url;
                }else{
                    $openhtml = array('jpg','gif','png','js','css','ico'); //外网的图片，js要保留下来
                     if (in_array(getExt($current_url), $openhtml)) {
                         $new_url = $current_url;
                     }
                }
            }else{
                if(substr($current_url,0,2) == "//"){
                    $new_url = $http.":".$current_url;
                }elseif(substr($current_url,0,1) == "/"){
                    $new_url = $domain.$current_url;
                }elseif(substr($current_url,0,3) == "../"){
                    $new_url = $url2."/".substr($current_url,3,strlen($current_url)-3);;
                }elseif(substr($current_url,0,2) == "./"){
                    $new_url = $url1."/".substr($current_url,2,strlen($current_url)-2);
                }else{
                    $new_url = $domain."/".$current_url; //直接就是相对目录
                }
            }
        }
        return $new_url;
    }

}