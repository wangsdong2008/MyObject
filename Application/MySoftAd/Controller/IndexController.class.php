<?php
namespace MySoftAd\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }

    //初始化
    function _initialize()
    {
        //A('Index/_initialize');//实例化Index类并调用_initialize方法
        // 实例化Index控制器与调用方法
        $index = A('Home/Index');
        $index->init();
        unset($index);
    }

    //tp代码生成器广告
    public function TpEditor(){
        $tplist = D("Home/ad")->getAdlist(39);
        $this->assign('tplist',$tplist);
        unset($tplist);
        $this->display('tplist');
    }
}