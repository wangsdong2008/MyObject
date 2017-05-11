<?php
namespace Home\Model;
use Think\Model;

class ThreadsModel extends Model{

    /* 自动验证规则 */
    protected $_validate = array(
        array('Topic', 'require', '主题不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('Topic','','此主题已经存在！',0,'unique',1),
        array('Description', 'require', '内容不能为空', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
        array('Cat_id', 'require', '分类不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );

    /* 自动完成规则 */
    protected $_auto = array(
        array('Channel_id',1, self::MODEL_INSERT),
        array('PostName','getuserName',1,'callback'),
        array('PostUserid','getuserid',1,'callback'),
        array('PostTime', NOW_TIME, self::MODEL_INSERT),
        array('PostIP', 'get_client_ip',1, 'function'),

        array('LastName','getuserName',1,'callback'),
        array('LastUserid','getuserid',1,'callback'),
        array('LastTime', NOW_TIME, self::MODEL_INSERT),
        array('LastIP', 'get_client_ip', 1,'function'),

        array('IsGood', 0, self::MODEL_INSERT),
        array('IsTop', 0, self::MODEL_INSERT),
        array('IsShow', 2, self::MODEL_INSERT),
        array('deleted', 0, self::MODEL_INSERT),
        array('data_value', 0, self::MODEL_INSERT),
        array('postnum', 0, self::MODEL_INSERT),
        array('hits', 0, self::MODEL_INSERT),
    );

    //这个函数是取用户账号中的值
    protected function getuserName(){
        $users = D('Home/users')->showUsers(session("userid"));
        return $users['username'];
    }

    //这个函数获取session里的name值
    protected function getuserid(){
        return session("userid");
    }

    //下面是你要定义的函数

    /*
    * 函数输出单条记录
    * 参数：$threads_id为ID
    * @return 单条记录
    */
    public function showthreads($ThreadId = 0){
        $threads = M('threads');
        $threads_data[C('DB_PREFIX').'threads.ThreadId'] = array('eq',$ThreadId);
        $threads_data[C('DB_PREFIX').'threads.IsShow'] = array('eq',2);
        $threads_data[C('DB_PREFIX').'threads.deleted'] = array('eq',0);
        $threadslist = $threads
            ->join('inner join think_category on think_category.cat_id = think_threads.Cat_id')
            ->where($threads_data)
            ->field('`think_threads`.`Cat_id`,`think_threads`.`Topic`,`think_threads`.`Description`,`think_category`.`cat_id`,`think_category`.`cat_name`')
            ->limit(1)
            ->find();
        unset($threads,$threads_data);
        return $threadslist;
    }

    /*
    * 分页显示所有记录
    * @return 分页记录
    */
    public function pagethreadslist($page = 1){

    }

    //获取最新的帖子
    public function getCatTop($Cat_id){
        $threads = M('threads');
        $threads_data['Cat_id'] = array('eq',$Cat_id);
        $threads_data['deleted'] = array('eq',0);
        unset($Cat_id);
        $threadslist = $threads
            ->where($threads_data)
            ->order('LastTime desc')
            ->field('ThreadId,Topic,PostName,PostUserid,PostTime')
            ->limit(1)
            ->find();
        unset($threads,$threads_data);
        return $threadslist;
    }

    //获取此分类帖子的数量
    public function getCatNum($Cat_id){
        $threads = M('threads');
        $threads_data['Cat_id'] = array('eq',$Cat_id);
        $threads_data['deleted'] = array('eq',0);
        unset($Cat_id);
        $threadslist = $threads
            ->where($threads_data)
            ->field('count(*) as num')
            ->limit(1)
            ->find();
        unset($threads,$threads_data);
        return $threadslist['num'];
    }

    //分页显示
    public function getPageThreads($cat_id=0,$pagesize=10){
        $threads = M('threads');
        $threads_data['IsShow'] = array('eq',2);
        $threads_data['deleted'] = array('eq',0);
        $threads_data['Cat_id'] = array('eq',$cat_id);
        $nowPage = I('page')?I('page'):1;
        $count = $threads->where($threads_data)->count();
        $threadslist['count'] = $count;
        $Page = new \Think\Page($count,$pagesize);
        $threadslist['list'] = $threads
            ->where($threads_data)
            ->order('IsTop desc,PostTime desc')
            ->field('`ThreadId`,`Topic`,`PostName`,`PostUserid`,`PostTime`,`LastName`,`LastTime`,`LastUserid`,`postnum`,`hits`,`IsGood`,`isTop`')
            ->page($nowPage.','.$Page->listRows)->select();
        $objPage = array('id'=>$cat_id);
        $threadslist['pagefooter'] = showpage($nowPage,$count,$objPage);
        unset($threads,$threads_data);
        return $threadslist;
    }

    //热门帖子
    public function getHotThreads($cat_id=0,$num=10){
        $threads = M('threads');
        $threads_data['IsShow'] = array('eq',2);
        $threads_data['deleted'] = array('eq',0);
        $threads_data['Cat_id'] = array('eq',$cat_id);
        $threadslist = $threads
            ->where($threads_data)
            ->order('`hits` desc')
            ->field('`ThreadId`,`Topic`,`PostName`,`PostUserid`,`PostTime`,`LastName`,`LastTime`,`LastUserid`,`postnum`,`hits`')
            ->select();
        unset($threads,$threads_data);
        return $threadslist;
    }

}
