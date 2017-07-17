<?php
namespace Links\Controller;
use Think\Controller;
class IndexController extends Controller {
    /*public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }*/

    private $flg = 0;  //用来控制是否返回CSS，js,img

    public function index(){
        $this->display('index');
    }

    public function getWebUrl($current_url,$domain_url,$flg=0){
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
            if(substr($current_url,0,5)=="http:" || substr($current_url,0,5)=="https"||substr($current_url,0,11)=="javascript:"|| $current_url == "#"){
                //友情链接地址排除在外
                if($flg == 0){
                    $new_url = $current_url;
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
                    //$new_url = $domain."/".$current_url;
                }
            }
        }
        return $new_url;
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
        $array['html'] = $ht;
        //$array['html'] = "123213";
        $arr2 = array();
        foreach($arr[3] as $key => $val){
            $v = $this->getWebUrl($val,$url,1);
            //暂时屏蔽
            if($v != ""){
                $arr2[$j] = $v;
                $j++;
            }
        }
        $j=0;
        //查询重复
        foreach(array_unique($arr2) as $key => $val){ //重新输入下标
            //去掉自己
            if($val != $url && $val != $url."/"&&geturl($val)==$domain){
                $array['link'][$j]['url'] = $val;
                $array['link'][$j]['real_url'] = $val;
                $j++;
            }
        }
        //print_r($array);exit;
        return json_encode($array);
    }

    public function getlinks(){
        $url = I('url','');
        $u = geturl($url);
        $pagecode = I('pagecode',"utf-8");
        $post = I('post','get');
        $referer = I('referer','');
        $header = array();
        $data = array();
        $array = array();
        if($url!='') {
            $content = "";
            $content = http($url, $data, $referer, $header, $post, 30);

            //补齐内容
            $content2 = $this->getss($content, $url);
            //生成页面
            print_r($content2);
        }
        unset($array,$j,$p,$k,$key);
        //print_r($arr);exit;
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
                $j = 0;
                $pattern="/('|\")?([^'\"]+(\.jpg|\.gif|\.png))('|\")?/is";//正则
                preg_match_all($pattern, $content, $arr);//匹配内容到arr数组
                foreach($arr[2] as $key => $val){
                    $s = geturl($val);
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
                }
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

}