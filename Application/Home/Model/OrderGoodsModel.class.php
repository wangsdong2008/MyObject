<?php
namespace Home\Model;
use Think\Model;

class OrderGoodsModel extends Model{

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
    * 参数：$order_goods_id为ID
    * @return 单条记录
    */
    public function showorder_goods($order_goods_id = 0){

    }

    /*
    * 分页显示所有记录
    * @return 分页记录
    */
    public function pageorder_goodslist($page = 1){

    }

    /*
     * 通过order_id得到所有产品
     */
    public function getOrderGoodsList($order_id=0){
        if($order_id==0) exit;
        $order_goods = M('order_goods');
        $order_goods_data[C('DB_PREFIX').'order_goods.order_id'] = array('eq',$order_id);
        $order_goodslist = $order_goods
            ->join('inner join think_goods on think_goods.goods_id = think_order_goods.goods_id')
            ->where($order_goods_data)
            ->field('`think_order_goods`.`goods_id`,`think_order_goods`.`goods_number`,`think_order_goods`.`shop_price`,`think_goods`.`goods_name`')
            ->select();
        unset($order_goods,$order_goods_data);
        return $order_goodslist;

    }

    //检查这个订单和这个产品是否对应
    public function checkOrderGoods($orderid=0,$goodsid=0){
        $order_goods = M('order_goods');
        $order_goods_data['order_id'] = array('eq',$orderid);
        $order_goods_data['goods_id'] = array('eq',$goodsid);
        $order_goodslist = $order_goods
            ->where($order_goods_data)
            ->field('rec_id')
            ->limit(1)
            ->find();
        unset($order_goods,$order_goods_data);
        return $order_goodslist;
    }


}
