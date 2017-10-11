<?php
namespace TaximeterApi\Model;
use Think\Model;

class GoodsInputModel extends Model{

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
     * 参数：$goods_input_id为ID
     * @return 单条记录
    */
    public function showgoods_input($id = 0){
        $goods_input = M('goods_input');
        $goods_input_data['id'] = array('eq',$id);
        $goods_inputlist = $goods_input->where($goods_input_data)->limit(1)->find();
        unset($goods_input,$goods_input_data);
        return $goods_inputlist;
    }

    /*
     * 分页显示所有记录
     * $pages为当前页数，$pagesize每页数量
     * @return 分页记录
    */
    public function pagegoods_inputlist($pages = 1,$pagesize = 10){
        $goods_input = M('goods_input');
        $goods_input_data['id'] = array('gt',0);
        $count = $goods_input->where($goods_input_data)->count();
        $goods_inputlist['count'] = $count;
        $Page = new \Think\Page($count,$pagesize);
        $goods_inputlist['list'] = $goods_input->where($goods_input_data)->order('id desc')->page($pages.','.$Page->listRows)->select();
        $objPage = array();
        $goods_inputlist['pagefooter'] = showpage($pages,$count,$objPage);
        unset($goods_input,$goods_input_data,$count,$Page,$objPage);
        return $goods_inputlist;
    }

    public function goods_inputSave($data)
    {
         $rules = array ( //以下三行根据表实际情况增加和修改,写法参考_auto函数
                  //array('status','1'),  // 新增的时候把status字段设置为1
                 array('addtime', NOW_TIME, self::MODEL_INSERT),
                  //array('create_time', NOW_TIME, self::MODEL_INSERT),
         );
         $goods_input =  D('goods_input');
         $goods_input->auto($rules)->create($data);
         if(!array_key_exists('id',$data)){
             return $goods_input->add();
         }
         else {
           if ($data['id'] == 0) {
             return $goods_input->add();
           } else {
             return $goods_input->save();
           }
        }
    }

    public function goods_inputDel($id)
    {
        $Model =  M();
        $sql = "delete from my_goods_input where `id` = '$id'";
        $Model->execute($sql);
        unset($id,$sql,$Model);
    }


    public function getMaxId()
    {
        $Model =  M();
        $sql = "select max(id) as id from my_goods_input";
        $result = $Model->query($sql);
        unset($sql,$Model);
        return $result[0]['id'];
    }

}
