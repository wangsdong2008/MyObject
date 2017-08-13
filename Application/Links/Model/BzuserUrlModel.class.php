<?php
namespace Links\Model;//此处Home是模块，根据自己情况修改
use Think\Model;

class BzuserUrlModel extends Model{

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

    public function getcaiurl($bzuserid,$url){
        $fid = 0;
        $Bzuser_url = M('Bzuser_url');
        $Bzuser_url_data['bzuserid'] = array('eq',$bzuserid);
        $Bzuser_url_data['url'] = array('eq',$url);
        $Bzuser_urllist = $Bzuser_url
            ->where($Bzuser_url_data)
            ->field('`id`')
            ->limit(1)
            ->find();
        if($Bzuser_urllist){
            $fid = $Bzuser_urllist['id'];
        }
        unset($Bzuser_url,$Bzuser_url_data,$Bzuser_urllist);
        return $fid;
    }

    /*
     * 函数输出单条记录
     * 参数：$bzuser_url_id为ID
     * @return 单条记录
    */
    public function showbzuser_url($id = 0){
        $bzuser_url = M('bzuser_url');
        $bzuser_url_data['id'] = array('eq',$id);
        $bzuser_urllist = $bzuser_url->where($bzuser_url_data)->limit(1)->find();
        unset($bzuser_url,$bzuser_url_data);
        return $bzuser_urllist;
    }


    public function bzuser_urlSave($data)
    {
         $rules = array (
                  array('addtime', NOW_TIME, self::MODEL_INSERT),
         );
         $bzuser_url =  M('bzuser_url');
         $bzuser_url->auto($rules)->create($data);
         if(!array_key_exists('id',$data)){
             return $bzuser_url->add();
         }
         else {
           if ($data['id'] == 0) {
             return $bzuser_url->add();
           } else {
             return $bzuser_url->save();
           }
        }
    }

    public function bzuser_urlDel($id)
    {
        $Model =  M();
        $sql = "delete from think_bzuser_url where `id` = '$id'";
        $Model->execute($sql);
        unset($id,$sql,$Model);
    }


    public function getMaxId()
    {
        $Model =  M();
        $sql = "select max(id) as id from think_bzuser_url";
        $result = $Model->query($sql);
        unset($sql,$Model);
        return $result[0]['id'];
    }

}
