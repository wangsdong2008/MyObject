<?php
namespace Home\Model;
use Think\Model;

class UsersBrowseHistoryModel extends Model{
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
    * 参数：$users_browse_history_id为ID
    * @return 单条记录
    */
    public function showusers_browse_history($users_browse_history_id = 0){

    }

    /*
    * 分页显示所有记录
    * @return 分页记录
    */
    public function pageusers_browse_historylist($page = 1){

    }

    /*
     * 写入到浏览记录表
     * $ptype 1教程 3源码 4软件
     */
    public function users_browse_history($userid=0,$pid=0,$ptype=0){
        if($userid == 0||$userid == null) return;
        if($pid == 0) return;
        if($ptype ==0 ) return;
        $ptime = time();
        $users_browse_history = M('users_browse_history');
        $users_browse_history_data['pid'] = $pid;
        $users_browse_history_data['ptype'] = $ptype;
        $users_browse_history_data['userid'] = $userid;
        $users_browse_history_data['ptime'] = $ptime;
        $users_browse_history->add($users_browse_history_data);
        unset($pid,$ptype,$userid,$ptime,$users_browse_history,$users_browse_history_data);
    }



}
