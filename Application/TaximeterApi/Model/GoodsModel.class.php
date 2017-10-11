<?php
namespace TaximeterApi\Model;
use Think\Model;

class GoodsModel extends Model{

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
    public function findGoods($goods_name,$company_id = 0){
        if($goods_name=='') return;
        $goods = M('goods');
        $goods_data['goods_name'] = array('eq',$goods_name);
        $goods_data['company_id'] = array('eq',$company_id);
        $goodslist = $goods->where($goods_data)->limit(1)->find();
        unset($goods,$goods_data);
        if($goodslist){
            return $goodslist['goods_id'];
        }else{
            return 0;
        }
    }
    /*
     * 函数输出单条记录
     * 参数：$goods_id为ID
     * @return 单条记录
    */
    public function showgoods($goods_id = 0,$company_id = 0){
        $goods = M('goods');
        $goods_data['goods_id'] = array('eq',$goods_id);
        $goods_data['company_id'] = array('eq',$company_id);
        $goodslist = $goods->where($goods_data)->limit(1)->find();
        unset($goods,$goods_data);
        return $goodslist;
    }

    /*
     * 分页显示所有记录
     * $pages为当前页数，$pagesize每页数量
     * @return 分页记录
    */
    public function pagegoodslist($pages = 1,$pagesize = 10,$company_id = 0){
        $goods = M('goods');
        $goods_data['goods_id'] = array('gt',0);
        $goods_data['company_id'] = array('eq',$company_id);
        $count = $goods->where($goods_data)->count();
        $goodslist['count'] = $count;
        $Page = new \Think\Page($count,$pagesize);
        $goodslist['list'] = $goods->where($goods_data)->order('goods_id desc')->page($pages.','.$Page->listRows)->select();
        $objPage = array();
        $goodslist['pagefooter'] = showpage($pages,$count,$objPage);
        unset($goods,$goods_data,$count,$Page,$objPage);
        return $goodslist;
    }

    public function goodsSave($data)
    {
         $rules = array ( //以下三行根据表实际情况增加和修改,写法参考_auto函数
                  array('is_show','1'),  // 新增的时候把status字段设置为1
                  array('addtime', NOW_TIME, self::MODEL_INSERT),
                  //array('create_time', NOW_TIME, self::MODEL_INSERT),
         );
         $goods =  D('goods');
         $goods->auto($rules)->create($data);
         if(!array_key_exists('goods_id',$data)){
             return $goods->add();
         }
         else {
           if ($data['goods_id'] == 0) {
             return $goods->add();
           } else {
             return $goods->save();
           }
        }
    }

    public function goodsUpdate($goods_id,$num){
        $Model =  M();
        $sql = "update my_goods set goods_num = goods_num + $num where `goods_id` = '$goods_id'";
        $Model->execute($sql);
        unset($goods_id,$sql,$Model);
    }

    public function goodsDel($goods_id,$company_id)
    {
        $Model =  M();
        $sql = "delete from my_goods where `goods_id` = '$goods_id' and company_id = $company_id";
        $Model->execute($sql);
        unset($goods_id,$sql,$Model);
    }


    public function getMaxId($company_id)
    {
        $Model =  M();
        $sql = "select max(goods_id) as id from my_goods where company_id = $company_id";
        $result = $Model->query($sql);
        unset($sql,$Model);
        return $result[0]['id'];
    }

}
