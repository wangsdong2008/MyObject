<?php
namespace Links\Controller;
use Think\Controller;
class IndexController extends Controller {
    /*public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }*/

    public function index(){
        $this->display('index');
    }

    public function getlinks(){
        $url = I('url','');
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
        $list = explode(":",$u);
        $http = $list[0].":";
        $referer = I('referer','');
        $header = array();
        $data = array();
        $array = array();
        if($url!=''){
            $content = http($url);

            $pattern="/<a href=('|\")?([^'\"]+)('|\")?/is";//正则
            preg_match_all($pattern, $content, $arr);//匹配内容到arr数组
            //此处扣除费用
            //费用扣除完成
            //获取内部链接
            $j = 0;
            foreach($arr[2] as $key => $val){
                $s = geturl($val);
                $new_url = getweburl($s,$val,$http,$u,$url,$url1,$url2);
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
                $new_url = getweburl($s,$val,$http,$u,$url,$url1,$url2);
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
                $new_url = getweburl($s,$val,$http,$u,$url,$url1,$url2);
                if($new_url!=""){
                    $array['js'][$j]['url'] = $new_url;
                    $array['js'][$j]['real_url'] = $val;
                    $j++;
                }
            }

        }

        //除去重复的链接
        $arr = array();
        foreach($array as $key => $val){
            echo $key."<br>";
            $j = 0;
            foreach($val as $key1 => $val2){
                $url = $val2['url'];
                $p=0;
                for($k=$key+1;$k<count($val2);$k++){
                    $url0 = $val2[$k]['url'];
                    if($url == $url0){
                        $p = 1;
                        break;
                    }
                }
                if($p == 0){
                    $arr[$key][$j]['url'] = $url;
                    $arr[$key][$j]['real_url'] = $array[$key][$key1]['real_url'];
                    $j++;
                }
            }
        }
        print_r($arr);exit;

        unset($array,$j,$p,$k,$key);
        //print_r($arr);exit;
        echo json_encode($arr);
    }

}