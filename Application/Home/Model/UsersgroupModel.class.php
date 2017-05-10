<?php
namespace Home\Model;
use Think\Model;

class UsersgroupModel extends Model{

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
    * 参数：$usersgroup_id为ID
    * @return 单条记录
    */
    public function showusersgroup($groupid = 0){
        $usersgroup = M('usersgroup');
        $usersgroup_data['groupid'] = array('eq',$groupid);
        $usersgrouplist = $usersgroup
            ->where($usersgroup_data)
            ->field('`groupid`,`groupname`,`groupDiscount`,`grouporder`,`grouptime`')
            ->limit(1)
            ->find();
        unset($usersgroup,$usersgroup_data);
        return $usersgrouplist;
    }

    /*
    * 分页显示所有记录
    * @return 分页记录
    */
    public function pageusersgrouplist($page = 1){

    }

    /*
     * 显示所有记录
     */
    public function grouplist(){
        $usersgroup = M('usersgroup');
        $usersgrouplist = $usersgroup
            ->order('grouporder asc')
            ->field('`groupid`,`groupname`')
            ->select();
        unset($usersgroup,$usersgroup_data);
        return $usersgrouplist;
    }
}
