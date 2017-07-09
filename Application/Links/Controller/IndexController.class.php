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

    public function getss($content,$url,$http){
        //$content = "aaaa<a href='/users/' rel='a'>t1</a>bbbbbb<a  rel='b' href='/ttttes/index.html'>t2</a>eeeee";
        //echo $content."\r\n";

        //$http="http";
        //$url = "http://www.jb51.net/list/list_2_1.htm";
        //$http = explode(":",$url)[0];
        $u = geturl($url);
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

        if($this->flg == 1){
            //链接
            $pattern="/href=('|\")?([^'\"]+)('|\")?/is";//正则
            preg_match_all($pattern, $content, $arr);//匹配内容到arr数组
            $str = "";
            $brr = preg_split($pattern, $content);
            foreach($brr as $key =>$val){
                $s = geturl($arr[2][$key]);
                if($key < count($arr)){
                    $str .= $brr[$key]."href=\"".getweburl($s,$arr[2][$key],$u,$url,$url1,$url2)."\"";
                }else{
                    $str .= $brr[$key];
                }
            }

            //图片
            $content = $str;
        }

        //js
        $pattern="/('|\")?([^'\"]+\.js)('|\")?/is";//正则
        preg_match_all($pattern, $content, $arr);//匹配内容到arr数组
        //print_r($arr);
        $str = "";
        $brr = preg_split($pattern, $content);
        foreach($brr as $key =>$val){
            $s = geturl($arr[2][$key]);
            if($key < count($arr)){
                $str .= $brr[$key]."\"".getweburl($s,$arr[2][$key],$u,$url,$url1,$url2)."\"";
            }else{
                $str .= $brr[$key];
            }
        }


        /*$pattern="/('|\"|\()+([^'\)\"]+(\.jpg|\.gif|\.png))('|\"|\))+/is";//正则
        preg_match_all($pattern, $content, $arr);//匹配内容到arr数组
        $str = "";
        $brr = preg_split($pattern, $content);
        foreach($brr as $key =>$val){
            $s = geturl($arr[2][$key]);
            if($key < count($arr[2])){
                $str .= $brr[$key]."\"".getweburl($s,$arr[2][$key],$u,$url,$url1,$url2)."\"";
            }else{
                $str .= $brr[$key];
            }
        }*/
        print_r($str);exit;





        return ($str);

    }

    public function getlinks(){

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
                    if($new_url != ""){
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