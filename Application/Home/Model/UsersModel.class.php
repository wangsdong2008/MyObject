<?php
namespace Home\Model;
use Think\Model;

class UsersModel extends Model{
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
    * 参数：$users_id为ID
    * @return 单条记录
    */
    public function showUsers($users_id = 0){
        if($users_id == 0) exit;
        $users = M('users');
        $users_data['id'] = array('eq',$users_id);
        $users_data['isdel'] = array('eq',0);
        $users_data['islock'] = array('eq',0);
        $userslist = $users->where($users_data)->limit(1)->find();
        unset($users,$users_data);
        return $userslist;
    }

    /*
     * 输出最新$num个用户
     */
    public function getTopUsers($num=10){
        $users = M('users');
        $users_data['isdel'] = array('eq',0);
        $users_data['islock'] = array('eq',0);
        $userslist = $users->where($users_data)->order('regtime desc')->field('id,username,face')->limit($num)->select();
        unset($users,$users_data);
        return $userslist;

    }

    /*
     * 用户推荐的教程
     */
    public function getusernews($uid=0){
        if($uid == 0) exit;
        $users_browse_history = M('users_browse_history');
        $users_browse_history_data[C('DB_PREFIX').'news.userid'] = array('eq',$uid);
        $users_browse_history_data['ptype'] = array('eq',1);
        unset($userid);
        $users_browse_historylist = $users_browse_history
            ->join(C('DB_PREFIX').'news on pid = '.C('DB_PREFIX').'news.news_id')
            ->join(C('DB_PREFIX').'category on '.C('DB_PREFIX').'category.cat_id = '.C('DB_PREFIX').'news.cat_id')
            ->where($users_browse_history_data)
            ->order('ptime desc')
            ->field('news_id,news_title,'.C('DB_PREFIX').'category.cat_id,cat_name')
            ->limit(10)
            ->select();
        unset($users_browse_history,$users_browse_history_data);
        return $users_browse_historylist;
    }

    /*
     * 用户推荐软件
     */
    public function getusersoft($uid=0){
        if($uid == 0) exit;
        $users_browse_history = M('users_browse_history');
        $users_browse_history_data['userid'] = array('eq',$uid);
        $users_browse_history_data['ptype'] = array('eq',4);
        unset($userid);
        $users_browse_historylist = $users_browse_history
            ->join(C('DB_PREFIX').'goods on pid = '.C('DB_PREFIX').'goods.goods_id')
            ->join(C('DB_PREFIX').'category on '.C('DB_PREFIX').'category.cat_id = '.C('DB_PREFIX').'goods.cat_id')
            ->where($users_browse_history_data)
            ->order('ptime desc')
            ->field('goods_id,goods_name,'.C('DB_PREFIX').'category.cat_id,cat_name')
            ->limit(10)
            ->select();
        unset($users_browse_history,$users_browse_history_data);
        return $users_browse_historylist;
    }

    /*
     * 用户推荐软件
     */
    public function getusercode($uid=0){
        if($uid == 0) exit;
        $users_browse_history = M('users_browse_history');
        $users_browse_history_data['userid'] = array('eq',$uid);
        $users_browse_history_data['ptype'] = array('eq',3);
        unset($userid);
        $users_browse_historylist = $users_browse_history
            ->join(C('DB_PREFIX').'goods on pid = '.C('DB_PREFIX').'goods.goods_id')
            ->join(C('DB_PREFIX').'category on '.C('DB_PREFIX').'category.cat_id = '.C('DB_PREFIX').'goods.cat_id')
            ->where($users_browse_history_data)
            ->order('ptime desc')
            ->field('goods_id,goods_name,'.C('DB_PREFIX').'category.cat_id,cat_name')
            ->limit(10)
            ->select();
        unset($users_browse_history,$users_browse_history_data);
        return $users_browse_historylist;
    }



}
