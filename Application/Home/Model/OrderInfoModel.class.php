<?php
namespace Home\Model;
use Think\Model;

class OrderInfoModel extends Model{

    /* 自动验证规则 */
    protected $_validate = array(
        /*
            array('name', 'require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
            array('name', '', '标识已经存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
            array('title', 'require', '名称不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        */
    );

    /* 自动完成规则 */
    protected $_auto = array(
        /*
           array('model', 'arr2str', self::MODEL_BOTH, 'function'),
           array('model', null, self::MODEL_BOTH, 'ignore'),
           array('extend', 'json_encode', self::MODEL_BOTH, 'function'),
           array('extend', null, self::MODEL_BOTH, 'ignore'),
           array('create_time', NOW_TIME, self::MODEL_INSERT),
           array('update_time', NOW_TIME, self::MODEL_BOTH),
           array('status', '1', self::MODEL_BOTH),
        */
    );

    //下面是你要定义的函数

    /*
    * 函数输出单条记录
    * 参数：$order_info_id为ID
    * @return 单条记录
    */
    public function showorder_info($order_id = 0){
        $order_info = M('order_info');
        $order_info_data['order_id'] = array('eq',$order_id);
        $order_info_data['isdel'] = array('eq',0);
        $order_infolist = $order_info
            ->where($order_info_data)
            ->limit(1)
            ->find();
        unset($order_info,$order_info_data);
        return $order_infolist;
    }

    /*
     * 检查订单是不是当前用户的
     */
    public function checkOrder($order_id){
        $order_info = M('order_info');
        $order_info_data['order_id'] = array('eq',$order_id);
        $order_info_data['user_id'] = array('eq',session('userid'));
        $order_infolist = $order_info
            ->where($order_info_data)
            ->field('`order_id`')
            ->limit(1)
            ->find();
        unset($order_info,$order_info_data);
        if(count($order_infolist)>0){
            return 1;
        }else{
            return 0;
        }
    }

    /*
    * 分页显示所有记录
    * @return 分页记录
    */
    public function pageorder_infolist($page = 1,$status = 3,$keyword=''){
        $order_info = M('order_info');
        $order_info_data['user_id'] = array('eq',session('userid'));
        $order_info_data['isdel'] = array('eq',0);
        if($status != 3){
            $order_info_data['order_status'] = array('eq',$status);
        }
        if($keyword!=""){
            $order_info_data['order_sn'] = array('like','%'.$keyword.'%');
        }
        $nowPage = I('page')?I('page'):1;
        $count = $order_info->where($order_info_data)->count();
        $order_infolist['count'] = $count;
        $Page = new \Think\Page($count,1);
        $order_infolist['list'] = $order_info
            ->where($order_info_data)
            ->order('addtime desc')
            ->field('order_id,order_sn,order_mount,order_status,addtime')
            ->page($nowPage.','.$Page->listRows)->select();
        $objPage = array();
        $order_infolist['pagefooter'] = showpage($nowPage,getpagenum($count,10),$objPage);
        unset($order_info,$order_info_data);
        return $order_infolist;
    }

    //下订单
    public function addorderinfo($userid,$flowid,$paystatus){
        $flow = M('flow');
        $flow_data['user_id'] = $userid;
        $flow_data['flow_id'] = array('in',$flowid);
        $flowlist = $flow->where($flow_data)->field('count(flow_id) as num')->find();
        if($flowlist['num']*1>0) { //购物车中有选中的产品才提交
            M()->startTrans();//开启事务
            $result = true;
            //获取产品总价格
            $flowlist = $flow->lock(true)->where($flow_data)->field('sum(goods_price) as sumprice')->find();
            if (!$flowlist) {
                $result = false;
            }

            $price = $flowlist['sumprice'];
            unset($flowlist);

            //写入订单
            $orderinfo = M('order_info');
            if ($price == 0) {
                $orderinfo_data['order_status'] = 2;
            } else {
                $orderinfo_data['order_status'] = 0;
            }

            $orderinfo_data['pay_status'] = $paystatus;
            $orderinfo_data['order_mount'] = $price;
            //获取用户信息
            $m = M('users');
            $m_data['id'] = $userid;
            $mlist = $m->lock(true)->where($m_data)->field('phone,email,true_name')->find();
            if ($mlist) {
                $orderinfo_data['consignee'] = $mlist['true_name'];
                $orderinfo_data['mobile'] = $mlist['phone'];
                $orderinfo_data['email'] = $mlist['email'];
            } else {
                $result = false;
            }

            $orderinfo_data['order_sn'] = "T" . date("YmdHis") . myRands(4);
            $orderinfo_data['user_id'] = $userid;
            $orderinfo_data['addtime'] = time();
            $order_id = $orderinfo->lock(true)->add($orderinfo_data);
            if (!$order_id) {
                $result = false;
            }

            //写入order_goods表
            $arr = explode(",", $flowid);
            $order_goods = M('order_goods');
            foreach ($arr as $key => $val) {
                $flows = $this->getflowprice($val);
                //写入order_goods表
                $order_goods_data['goods_id'] = $flows['goods_id'];
                $order_goods_data['order_id'] = $order_id;
                $order_goods_data['goods_number'] = 1;
                $order_goods_data['shop_price'] = $flows['goods_price'];
                $order_goods_data['order_time'] = time();
                $pid = $order_goods->lock(true)->add($order_goods_data);
                if (!$pid) {
                    $result = false;
                }
                unset($flows, $order_goods_data);
            }

            //删除flow表
            $flow->where($flow_data)->delete();
            unset($flow, $flow_data);
            if (!result) {
                M()->rollback();//回滚
                return false;exit;
            }
            M()->commit();//事务提交
            $attr['order_id']=$order_id;
            $attr['price']=$price;
            unset($userid,$paystatus,$flowid,$flow,$flow_data,$flowlist,$result,$orderinfo,$orderinfo_data,$m,$m_data,$mlist,$arr,$order_goods,$order_goods_data,$pid);
            return $attr;
        }else{
            return false;
        }
    }

    //获取订单中产品价格
    private function getflowprice($flow_id){
        $flow = M('flow');
        $flow_data['flow_id'] = $flow_id;
        $flowlist = $flow->where($flow_data)->limit(1)->field('goods_id,goods_price')->find();
        return $flowlist;
    }


}
