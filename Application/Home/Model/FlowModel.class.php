<?php
namespace Home\Model;
use Think\Model;

class FlowModel extends Model{

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
    * 参数：$flow_id为ID
    * @return 单条记录
    */
	public function showflow($userid,$pid = 0){
		//读取此用户的所有产品
		$flow1 = M('flow');
		$flow1_data[''.C('DB_PREFIX').'flow.user_id'] = array('eq',$userid);
		if($pid != ""){
			$flow1_data[''.C('DB_PREFIX').'flow.flow_id'] = array('in',$pid);
		}
		$flow1_data[''.C('DB_PREFIX').'goods_img.is_show'] = 1;
		$flow1_list = $flow1->join( C('DB_PREFIX').'goods on '.C('DB_PREFIX').'goods.goods_id='.C('DB_PREFIX').'flow.goods_id')
			->join(''.C('DB_PREFIX').'goods_img on '.C('DB_PREFIX').'goods_img.goods_id = '.C('DB_PREFIX').'flow.goods_id and goods_key = 1')
			->join(C('DB_PREFIX').'category on '.C('DB_PREFIX').'category.cat_id = '.C('DB_PREFIX').'goods.cat_id')
			->field('goods_sn,flow_id,goods_img,'.C('DB_PREFIX').'flow.goods_id,'.C('DB_PREFIX').'flow.goods_price,goods_name,root_id')
			->order('flow_id desc')
			->where($flow1_data)
			->select();
		unset($flow1,$flow1_data);
		return $flow1_list;
	}

	//加入购物车
	public function fun_addflow($userid,$goods_id){
		$Goods=D('Home/Goods');
		$goods_price = $Goods->getprices($goods_id);

		//查询此商品是否存在
		$flow = M('flow');
		$flow_data['goods_id'] = array('eq',$goods_id);
		$flow_data['user_id'] = array('eq',$userid);
		$flowlist = $flow->where($flow_data)->field('flow_id')->find();
		if(!$flowlist) {

			$flow_data['goods_id'] = $goods_id;
			$flow_data['user_id'] = $userid;
			$flow_data['addtime'] = time();
			$flow_data['goods_price'] = $goods_price;
			$flow->add($flow_data);
			unset($flow, $flow_data);
			unset($goods_environment, $goods_version, $goods_years, $goods_price, $goods_id);
			return true;//可以加入
		}else{
			//已经存在就不用写入购物车
			unset($flow, $flow_data);
			unset($goods_environment, $goods_version, $goods_years, $goods_price, $goods_id,$Goods);
			return false;//已存在
		}
	}

	//删除购物车中产品
	public function delflowAll(){
		$id = I('goods_id');
		print_r($id);exit;
		/*if($id == 0){
			return 0;
		}
		$m = M('flow');
		$m_data['flow_id'] = array('eq',$id);
		$m_data['user_id'] = session("userid");
		$m->where($m_data)->delete();*/
	}

	//获取购物车中的产品
	public function getflowgoods(){
		$userid = 0;
		if(session("userid")){
			$userid=session('userid');
		}
		$flow = M('flow');
		$flow_data[C('DB_PREFIX').'flow.user_id'] = array('eq',$userid);
		$flowlist = $flow->where($flow_data)->join(C('DB_PREFIX').'goods on '.C('DB_PREFIX').'goods.goods_id ='.C('DB_PREFIX').'flow.goods_id' )->join(C('DB_PREFIX').'goods_img on '.C('DB_PREFIX').'goods_img.goods_id = '.C('DB_PREFIX').'flow.goods_id')->order('flow_id desc')->field(C('DB_PREFIX').'flow.goods_id,goods_name,'.C('DB_PREFIX').'flow.goods_price,goods_img,flow_id')->select();
		unset($userid,$flow,$flow_data);
		return $flowlist;
	}
}
