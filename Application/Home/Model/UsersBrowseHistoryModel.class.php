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
        if($userid == 0 || $userid == null || $userid =="") return;
        if($pid == 0) return;
        if($ptype ==0 ) return;

        //查询是否存在
        $UsersBrowseHistory = M('users_browse_history');
        $UsersBrowseHistory_data['pid'] = array('eq',$pid);
        $UsersBrowseHistory_data['ptype'] = array('eq',$ptype);
        $UsersBrowseHistory_data['userid'] = array('eq',$userid);
        $UsersBrowseHistorylist = $UsersBrowseHistory
            ->where($UsersBrowseHistory_data)
            ->field('`id`')
            ->limit(1)
            ->find();
        unset($UsersBrowseHistory,$UsersBrowseHistory_data);
        if($UsersBrowseHistorylist) return ; //存在就不处理

        $users_browse_history = M('users_browse_history');
        $ptime = time();
        $users_browse_history_data['pid'] = $pid;
        $users_browse_history_data['ptype'] = $ptype;
        $users_browse_history_data['userid'] = $userid;
        $users_browse_history_data['ptime'] = $ptime;
        $users_browse_history->add($users_browse_history_data);
        unset($pid,$ptype,$userid,$ptime,$users_browse_history,$users_browse_history_data);
    }

    /*
     * 获取某人某个分类中的浏览记录
     * $ptype 1教程 3源码 4软件
     */
    public function showUserBrowseHistory($userid=0,$ptype=0,$num=10){
        $UsersBrowseHistory = M('users_browse_history');
        switch($ptype){
            case 1:{ //新闻
                $UsersBrowseHistory_data['think_news.isdel'] = array('eq','0');
                $UsersBrowseHistory_data['think_news.is_show'] = array('eq','1');
                $userid = session('userid');
                $UsersBrowseHistory_data['think_users_browse_history.userid'] = array('eq',$userid);
                $UsersBrowseHistorylist = $UsersBrowseHistory
                    ->join('inner join think_news on think_news.news_id = think_users_browse_history.pid')
                    ->join('inner join think_category on think_news.cat_id = think_category.cat_id')
                    ->where($UsersBrowseHistory_data)
                    ->order('`think_users_browse_history`.`ptime` desc')
                    ->field('`think_category`.`cat_name`,`think_news`.`cat_id`,`think_news`.`news_id`,`think_news`.`news_title`')
                    ->limit($num)
                    ->select();
                //echo $UsersBrowseHistory->getLastSql();exit;
                unset($userid,$UsersBrowseHistory,$UsersBrowseHistory_data);
                break;
            }
            case 3:{ //源码

                break;
            }
            case 4:{ //软件

                break;
            }
        }
        return $UsersBrowseHistorylist;
    }



}
