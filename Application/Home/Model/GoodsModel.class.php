<?php
namespace Home\Model;
use Think\Model;

/**
 * 产品模型
 */
class GoodsModel extends Model{
    /*
     * 获取最新的模版
     * $cat_id分类，$num为数量
     */
    public function getTopGoodsList($num,$cat_id){
        $goods = M('goods');
        $goods_data['cat_id'] = array('eq',$cat_id);
        $goods_data[C('DB_PREFIX').'goods.is_show'] = array('eq',1);
        $goods_data[C('DB_PREFIX').'goods.isdel'] = array('eq',0);
        $goodslist = $goods->join(C('DB_PREFIX').'goods_img on '.C('DB_PREFIX').'goods_img.goods_id = '.C('DB_PREFIX').'goods.goods_id')->where($goods_data)->order('goods_id desc')->field(C('DB_PREFIX').'goods.goods_id,goods_name,goods_img')->limit($num)->select();
        unset($goods,$goods_data);
        return $goodslist;
    }

    /*
     * 获取最新的源码
     * $num为数量
     * $data为分类数组
     */
    public function getNewGoodsNum($data,$num){
        $goods = M('goods');
        $goods_data['is_show'] = array('eq',1);
        $goods_data['isdel'] = array('eq',0);
        $goods_data['cat_id'] = array('in',implode(',',$data));
        $goodslist = $goods
            ->where($goods_data)
            ->order('goods_id desc')
            ->field('goods_id,goods_name')
            ->limit($num)
            ->select();
        unset($goods,$goods_data);
        return $goodslist;
    }

    /*
     * 显示某条产品信息
     */
    public function getGoodsDetail($goods_id = 0){
        if($goods_id == 0){ unset($goods_id); exit; }
        $goods = M('goods');
        $goods_data[C('DB_PREFIX').'goods.goods_id'] = array('eq',$goods_id);
        $goods_data[C('DB_PREFIX').'goods.is_show'] = array('eq',1);
        $goods_data[C('DB_PREFIX').'goods.isdel'] = array('eq',0);
        unset($goods_id);
        $goodslist = $goods
            ->join('join '.C(DB_PREFIX).'category on '.C(DB_PREFIX).'category.cat_id = '.C(DB_PREFIX).'goods.cat_id')
            ->join(C(DB_PREFIX).'users on id = '.C(DB_PREFIX).'goods.user_id')
            ->join('left join '.C(DB_PREFIX).'goods_img on '.C(DB_PREFIX).'goods_img.goods_id = '.C(DB_PREFIX).'goods.goods_id')
            ->where($goods_data)
            ->field(C(DB_PREFIX).'category.cat_id,cat_name,floor(goods_price) as goods_price,sy_url,true_name,'.C(DB_PREFIX).'goods.goods_description,'.C(DB_PREFIX).'goods.goods_keyword,'.C(DB_PREFIX).'goods.goods_title,'.C(DB_PREFIX).'goods.goods_name,'.C(DB_PREFIX).'goods.goods_id,'.C(DB_PREFIX).'goods.goods_environment,'.C(DB_PREFIX).'goods.goods_keyword,'.C(DB_PREFIX).'goods.goods_description,'.C(DB_PREFIX).'goods.cat_id,'.C(DB_PREFIX).'goods.goods_content,'.C(DB_PREFIX).'goods.goods_time,'.C(DB_PREFIX).'goods_img.goods_small_img,'.C(DB_PREFIX).'goods_img.goods_img')
            ->limit(1)
            ->find();
        unset($goods,$goods_data);
        return $goodslist;
    }

    /*
     * 获取某条产品的前一条产品
     */
    public function getPrevNext($cat_id=0,$goods_id=0){
        if($goods_id == 0) return;
        if($cat_id == 0) return ;
        $arr = array();

        //前一个
        $goods = M('goods');
        $goods_data['goods_id'] = array('gt',$goods_id);
        $goods_data['cat_id'] = array('eq',$cat_id);
        $goods_data['is_show'] = array('eq',1);
        $goods_data['isdel'] = array('eq',0);
        $goodslist = $goods
            ->where($goods_data)
            ->order('goods_id asc')
            ->field('goods_id,goods_name')
            ->limit(1)
            ->find();
        unset($goods,$goods_data);
        if(count($goodslist)>0){
            $arr[0]['goods_id'] = $goodslist['goods_id'];
            $arr[0]['goods_name'] = $goodslist['goods_name'];
        }
        else{
            $arr[0]['goods_id'] = 0;
            $arr[0]['goods_name'] = '无';
        }
        unset($goods,$goods_data,$goodslist);

        //后一个
        $goods = M('goods');
        $goods_data['goods_id'] = array('lt',$goods_id);
        $goods_data['cat_id'] = array('eq',$cat_id);
        $goods_data['is_show'] = array('eq',1);
        $goods_data['isdel'] = array('eq',0);
        unset($goods_id,$cat_id);
        $goodslist = $goods
            ->where($goods_data)
            ->order('goods_id desc')
            ->field('goods_id,goods_name')
            ->limit(1)
            ->find();
        unset($goods,$goods_data);
        if(count($goodslist)>0){
            $arr[1]['goods_id'] = $goodslist['goods_id'];
            $arr[1]['goods_name'] = $goodslist['goods_name'];
        }
        else{
            $arr[1]['goods_id'] = 0;
            $arr[1]['goods_name'] = '无';
        }
        unset($goods_id,$cat_id,$goods,$goods_data,$goodslist);

        return $arr;
    }


    //更新点击量
    public function updateGoodsHits($goods_id=0){
        if($goods_id == 0) exit;
        $Model = M();
        $sql = "update ".C('DB_PREFIX')."goods set `goods_hits` = `goods_hits`+1 where `goods_id` = '$goods_id'";
        $Model->execute($sql);
        unset($sql,$Model);
    }

    //获取产品价格
    public function getprices($goods_id){
        $goods = M('goods');
        $goods_data['isdel'] = 0;
        $goods_data['is_show'] = 1;
        $goods_data['goods_id'] = array('eq',$goods_id);
        $goods_list = $goods->where($goods_data)->limit(1)->find();
        $goods_price = $goods_list['goods_price'];
        return $goods_price;
    }

    //获取此分类的热门产品
    public function gethotgoods($cat_id=0,$num=10){
        if($cat_id == 0) return;
        $goods = M('goods');
        $goods_data['cat_id'] = array('eq',$cat_id);
        $goods_data['isdel'] = array('eq',0);
        $goods_data['is_show'] = array('eq',1);
        unset($cat_id);
        $goodslist = $goods
            ->where($goods_data)
            ->order('goods_hits desc')
            ->field('goods_id,goods_name')
            ->limit($num)
            ->select();
        unset($goods,$goods_data);
        return $goodslist;
    }

    /*
    * 分页显示某分类产品
    * $cat_id 分类ID
    * $page 当前页
    * @return 返回多条记录集
    */
    public function getPageGoods($cat_id,$nowPage,$pagenum){
        $fname = 'goods_id,goods_name,goods_time';
        $goods = M('goods');
        $goods_data['is_show'] = array('eq',1);
        if($cat_id > 0){
            $goods_data['cat_id'] = array('eq',$cat_id);
        }
        $goods_data['isdel'] = array('eq',0);
        $nowPage = $nowPage?$nowPage:1;
        $count = $goods->where($goods_data)->count();
        $Page = new \Think\Page($count,$pagenum);
        $goodslist['list'] = $goods->where($goods_data)->order('goods_time desc')->field($fname)->page($nowPage.','.$Page->listRows)->select();
        $goodslist['count'] = $count;
        $goodslist['pagecount'] = getpagenum($count,$pagenum);
        unset($goods,$goods_data,$nowPage,$count,$fname);
        return $goodslist;
    }



}