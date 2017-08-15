<?php
namespace Links\Model;//此处Home是模块，根据自己情况修改
use Think\Model;

class VersionModel extends Model{

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
     * 参数：$version_id为ID
     * @return 单条记录
    */
    public function showversion($id = 0){
        $version = M('version');
        $version_data['id'] = array('eq',$id);
        $versionlist = $version->where($version_data)->limit(1)->find();
        unset($version,$version_data);
        return $versionlist;
    }

    public function versionSave($data)
    {
         $rules = array ( //以下三行根据表实际情况增加和修改,写法参考_auto函数
                  //array('status','1'),  // 新增的时候把status字段设置为1
                  //array('addtime', NOW_TIME, self::MODEL_INSERT),
                  //array('create_time', NOW_TIME, self::MODEL_INSERT),
         );
         $version =  M('version');
         $version->auto($rules)->create($data);
         if(!array_key_exists('id',$data)){
             return $version->add();
         }
         else {
           if ($data['id'] == 0) {
             return $version->add();
           } else {
             return $version->save();
           }
        }
    }

    public function versionDel($id)
    {
        $Model =  M();
        $sql = "delete from think_version where `id` = '$id'";
        $Model->execute($sql);
        unset($id,$sql,$Model);
    }


    public function getMaxId()
    {
        $Model =  M();
        $sql = "select max(id) as id from think_version";
        $result = $Model->query($sql);
        unset($sql,$Model);
        return $result[0]['id'];
    }

}
