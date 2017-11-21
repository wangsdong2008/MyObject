<?php
namespace Version\Model;
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

    /*
     * 显示最后一条记录
     */
    public function showTopVersion($cat_id=1){
        $version = M('version');
        $version_data['cat_id'] = array('eq',$cat_id);
        $versionlist = $version->where($version_data)->limit(1)->order('id desc')->find();
        unset($version,$version_data);
        return $versionlist;
    }

    /*
     * 显示多条记录
     * $num为显示的数量
     * @return 多条记录
    */
    public function versionList($num = 10){
        $version = M('version');
        $version_data['id'] = array('gt',0);
        $versionlist = $version->where($version_data)->order('id desc')->limit($num)->select();
        unset($version,$version_data);
        return $versionlist;
    }

    /*
     * 分页显示所有记录
     * $pages为当前页数，$pagesize每页数量
     * @return 分页记录
    */
    public function pageversionlist($pages = 1,$pagesize = 10){
        $version = M('version');
        $version_data['id'] = array('gt',0);
        $count = $version->where($version_data)->count();
        $versionlist['count'] = $count;
        $Page = new \Think\Page($count,$pagesize);
        $versionlist['list'] = $version->where($version_data)->order('id desc')->page($pages.','.$Page->listRows)->select();
        $objPage = array();
        $versionlist['pagefooter'] = showpage($pages,$count,$objPage);
        unset($version,$version_data,$count,$Page,$objPage);
        return $versionlist;
    }

    /*
     * 函数保存记录
     * 参数：$data
     * @return 单条记录ID
    */
    public function versionSave($data)
    {
         $rules = array ( //以下三行根据表实际情况增加和修改,写法参考_auto函数
                  //array('status','1'),  // 新增的时候把status字段设置为1
                  //array('addtime', NOW_TIME, self::MODEL_INSERT),
                  //array('create_time', NOW_TIME, self::MODEL_INSERT),
         );
         $version =  D('version');
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

    /*
     * 删除某条记录
    */
    public function versionDel($id)
    {
        $Model =  M();
        $sql = "delete from think_version where `id` = '$id'";
        $Model->execute($sql);
        unset($id,$sql,$Model);
    }


    /*
     * 获取表中最大的ID
     * @return 数字
    */
    public function getMaxId()
    {
        $Model =  M();
        $sql = "select max(id) as id from think_version";
        $result = $Model->query($sql);
        unset($sql,$Model);
        return $result[0]['id'];
    }

}
