<?php
namespace TaximeterApi\Controller;
use Think\Controller;

class IndexController extends Controller {
    private $unit = '个|条|斤|份|碗|袋|头|本|块|根|封|枝|只';
    private $split = '元|块';

    public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }

    //初始化类
    public function _initialize() {
        //if(!is_mobile()){ echo "只允许手机访问"; exit;}
    }

    //设置产品价格
    public function addgoods(){
        //格式：小青菜每斤1.1元
        $str = I('get.str');
        $companyid = I("id");
        $patterns = "/([^']+)(每|一)(".$this->unit.")([\\d\\.]+)(".$this->split.")/";

        $status = 0;
        $jj = 0;
        $ii = 0;
        $list = preg_split("/(".$this->split.")/",$str);

       for($i=0;$i<count($list)-1;$i++){
            $str2 = $list[$i]."元";
            preg_match_all($patterns,$str2,$arr);
            //检查重复
           if(D("goods")->findGoods($arr[1][0],$companyid) > 0){
                $status = 1;
                $ii ++;
            }else{
                $goods_data['goods_name'] = $arr[1][0];
                $goods_data['goods_price'] = $arr[4][0];
                $goods_data['company_id'] = $companyid;
                $pid = D("goods")->GoodsSave($goods_data);
                if($pid>0){
                    $jj ++;
                }
            }
            $arr = array();
        }

        if( $jj == count($list)-1 && count($list)>1){
            $status = 2;
        }else{
            if($ii>0){
                $status = 1;
            }
        }
        $arr1['status'] = $status;
        unset($str,$patterns,$goods_data,$pid,$status);
        echo json_encode($arr1);
    }

    //入库
    public function addgoodsinput(){
        //格式：小青菜50斤1.1元
        $str = I('get.str');
        $companyid = I("id");
        $patterns = "/([^\\d]+)(\\d+)(".$this->unit.")([\\d\\.]+)(".$this->split.")/";
        $list = preg_split("/(".$this->split.")/",$str);
        $status = 0;
        $ii = 0;
        $jj = 0;
        for($i=0;$i<count($list)-1;$i++){
            $str2 = $list[$i]."元";
            preg_match_all($patterns,$str2,$arr);

            //查找此产品
            $goods_id = D("goods")->findGoods($arr[1][0],$companyid);
            if($goods_id > 0){
                $goodsinput_data['goods_id'] = $goods_id;
                $goodsinput_data['inum'] = $arr[2][0];
                $goodsinput_data['company_id'] = $companyid;
                $goodsinput_data['goods_price'] = $arr[4][0];
                $pid = D("goods_input")->goods_inputSave($goodsinput_data);
                if($pid>0){
                    //更新产品数量
                    D("goods")->goodsUpdate($goods_id,$arr[2][0],$companyid);
                    $jj ++;
                }
                $arr = array();
            }
            else{
                $ii ++;
            }
        }
        if( $jj == count($list)-1 && count($list)>1){
            $status = 2;
        }else{
            if($ii>0){
                $status = 1;
            }
        }
        $arr1['status'] = $status;
        unset($str,$patterns,$goods_data,$pid,$status,$companyid);
        echo json_encode($arr1);
    }

    //查询价格
    public function findPrice(){
        //格式：小青菜50斤
        $str = I('get.str');
        $companyid = I("id");
        $patterns = "/([^\\d]+)(\\d+)(".$this->unit.")/";
        $list = preg_split("/(".$this->unit.")/",$str);

        $sum = 0;
        $arrlist = array();
        for($i=0;$i<count($list)-1;$i++){
            $str2 = $list[$i]."个";
            preg_match_all($patterns,$str2,$arr);

            $goods_name = $arr[1][0];
            $goods_id = D("goods")->findGoods($goods_name,$companyid);
            if($goods_id>0){
                $arrlist['list'][$i]['goods_name'] = $goods_name;
                $goodslist = D("goods")->showgoods($goods_id,$companyid);
                if($goodslist){
                    $sum = $sum + $goodslist['goods_price']*$arr[2][0];
                    $arrlist['list'][$i]['goods_price'] = $goodslist['goods_price']*1;
                    $arrlist['list'][$i]['goods_num'] = $arr[2][0];
                    $arrlist['list'][$i]['goods_count'] = $arr[2][0]*1*$goodslist['goods_price']*1;
                }
            }
        }
        $arrlist['count_price'] = $sum;
        unset($str,$patterns,$goods_id,$companyid);
        echo json_encode($arrlist);
    }


}