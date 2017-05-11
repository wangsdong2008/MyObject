<?php
namespace Home\Model;
use Think\Model;

class ThreadsModel extends Model{

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
            ->field('`ThreadId`,`Topic`,`PostName`,`PostUserid`,`PostTime`,`LastName`,`LastTime`,`LastUserid`,`postnum`,`hits`')
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
