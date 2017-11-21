<?php
namespace TaximeterApi\Controller;
use Think\Controller;

class IndexController extends Controller {
    private $unit = '个|条|斤|份|碗|袋|头|本|块|根|封|枝|只';
    private $split = '元|块';
    private $numstr = '[\\d\\.一二三四五六七八九十两]+';
    private $aunit = '花了|用了|用去|花掉|花去|用掉|收到';

    public function index(){
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background:
        #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
        echo '<meta charset="UTF-8">';
        echo '<a href="AccountingList?kw='.urlencode("查看从2005年到2016年11月").'" target="_blank">打开11111</a>';
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
        $patterns = "/([^']+)(每|一)(".$this->unit.")(".$this->numstr.")(".$this->split.")/u";

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
                $goods_data['goods_price'] = NumtoNum($arr[4][0]);
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
        $patterns = "/([^\\d]+)(".$this->numstr.")(".$this->unit.")(".$this->numstr.")(".$this->split.")/u";
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
                $nums = NumtoNum($arr[2][0]);
                $goodsinput_data['goods_id'] = $goods_id;
                $goodsinput_data['inum'] = $nums;
                $goodsinput_data['company_id'] = $companyid;
                $goodsinput_data['goods_price'] = NumtoNum($arr[4][0]);
                $pid = D("goods_input")->goods_inputSave($goodsinput_data);
                if($pid>0){
                    //更新产品数量
                    D("goods")->goodsUpdate($goods_id,$nums,$companyid);
                    $jj ++;
                }
                unset($nums);
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
        $patterns = "/([^\\d]+)(".$this->numstr.")(".$this->unit.")/u";
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
                    $num = NumtoNum($arr[2][0]);
                    $sum = $sum + $goodslist['goods_price']*$num;
                    $arrlist['list'][$i]['goods_id'] = $goodslist['goods_id'];
                    $arrlist['list'][$i]['goods_price'] = $goodslist['goods_price']*1;
                    $arrlist['list'][$i]['goods_num'] = $num;
                    $arrlist['list'][$i]['goods_count'] = $num*1*$goodslist['goods_price']*1;
                }
            }
        }
        $arrlist['count_price'] = $sum;
        unset($str,$patterns,$goods_id,$companyid);
        echo json_encode($arrlist);
    }

    public function Accounting(){
        //格式：超市用去100元，报名费收到50元
        $str = I('get.str');
        $companyid = I("id");
        $patterns = "/([^\\d]+)(".$this->aunit.")(".$this->numstr.")(".$this->split.")/u";
        $list = preg_split("/(".$this->split.")/u",$str);
        $arrlist = array();
        $status = 0;
        for($i=0;$i<count($list)-1;$i++){
            $str2 = $list[$i]."元";
            preg_match_all($patterns,$str2,$arr);
            if(strpos($str2,"收到")){
                $fh = 1;
            }else{
                $fh = -1;
            }
            $data['content'] = $arr[1][0];
            $data['price'] = $fh*NumtoNum($arr[3][0]);
            $data['companyid'] = $companyid;
            $data['addtime'] = time();
            $fid = D('accounting')->accountingSave($data);
            if($fid > 0 ){
                $status = 3;
            }
        }
        $arrlist['status'] = $status;
        unset($str,$str2,$patterns,$companyid,$list,$data,$status);
        echo json_encode($arrlist);
    }

    //列有页
    public function AccountingList(){
       // echo '<meta charset="UTF-8">';
        $pages = I('page',1);
        $companyid = I('id',0);
        $pagesize = 100;
        $str = urldecode((I('str')));
        $v = getStrDate($str);
        //print_r($v);exit;
        $starttime = strtotime($v['starttime']);
        $endtime = strtotime($v['endtime']);
        if(!strpos($str,"每")){
            //查看某段时间的营业
            $result = D('accounting')->pageaccountinglist($pages,$pagesize,$starttime,$endtime,$companyid);
        }
        else{
            //查看每个月/天的营业
        }
        echo json_encode($result);
    }

    //删除
    public function AccountingDel(){
        $id = I('pid',0);
        D('accounting')->accountingDel($id);

        $arr['pid'] = $id;
        echo json_encode($arr);
    }

    //上传图片
    public function upload(){
        $base_path = "./upload/"; //存放目录
        if(!is_dir($base_path)){
            mkdir($base_path,0777,true);
        }
        $target_path = $base_path . basename ( $_FILES ['attach'] ['name'] );
        if (move_uploaded_file ( $_FILES ['attach'] ['tmp_name'], $target_path )) {
            $array = array (
                "status" => true,
                "msg" => $_FILES ['attach'] ['name']
            );
            echo json_encode ( $array );
        } else {
            $array = array (
                "status" => false,
                "msg" => "There was an error uploading the file, please try again!" . $_FILES ['attach'] ['error']
            );
            echo json_encode ( $array );
        }

    }

    public function upload2(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728 ;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = './Uploads/'; // 设置附件上传根目录
        $upload->savePath = ''; // 设置附件上传（子）目录
        // 上传文件
        $info = $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $this->success('上传成功！');
        }
    }


}