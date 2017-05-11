<?php
namespace Home\Model;
use Think\Model;

class PostsModel extends Model{
    /* 自动验证规则 */
    protected $_validate = array(
        array('PostContent', 'require', '回复不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('ThreadID', 'require', '帖子ID不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
    );

    /* 自动完成规则 */
    protected $_auto = array(
        array('PostName','getuserName',1,'callback'),
        array('PostUserid','getuserid',1,'callback'),
        array('PostTime', NOW_TIME, self::MODEL_INSERT),
        array('PostIP', 'get_client_ip', self::MODEL_INSERT),
        array('IsShow', 2, self::MODEL_INSERT),
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
     * 参数：$posts_id为ID
     * @return 单条记录
    */
    public function showposts($PostID = 0){
        $posts = M('posts');
        $posts_data['PostID'] = array('eq',$PostID);
        $postslist = $posts->where($posts_data)->limit(1)->find();
        unset($posts,$posts_data);
        return $postslist;
    }

    /*
     * 分页显示所有记录
     * $pages为当前页数，$pagesize每页数量
     * @return 分页记录
    */
    public function pagepostslist($ThreadID=0,$PageSize = 10){
        $Model = M();
        $sql = "select `think_posts`.`PostContent`,`think_posts`.`PostTime`,`PostName`,`think_users`.`username`,`think_users`.`face` from `think_posts` inner join `think_users` on `think_users`.`id` = `think_posts`.`PostUserid` where `think_posts`.`ThreadID` = '$ThreadID' and `think_posts`.`is_show` = '2' ";
        $list = explode("from",$sql);
        $sql2 = "select count(*) as num from ".$list[1];
        unset($list);
        $numlist = $Model->query($sql2);
        $count = $numlist[0]['num'];
        $postslist['count'] = $count;
        $sql .= " order by `think_posts`.`PostID` asc";
        $nowPage = I('page')?I('page'):1;
        $sql .= " limit ".($nowPage-1)*$PageSize. "," . $PageSize;
        $postslist['list'] = $Model->query($sql);
        $objPage = array('id'=>$ThreadID);
        $postslist['pagefooter'] = showpage($nowPage,$count,$objPage);
        unset($count,$sql,$numlist,$objPage,$PageSize);
        unset($sql,$Model);
        return $postslist;
    }

    //获取此分类总帖子数量
    //$day=1表示今天的帖子数量
    public function getPostsNum($cat_id,$day=0){
        $posts = M('posts');
        $posts_data[C('DB_PREFIX').'posts.is_show'] = array('eq',2);
        $posts_data[C('DB_PREFIX').'threads.Cat_id'] = array('eq',$cat_id);
        if($day == 1){
            $posts_data[C('DB_PREFIX').'posts.posttime'] = array('gt',strtotime(date("Y-m-d 00:00:00")));
        }
        $postslist = $posts
            ->join('inner join think_threads on think_threads.ThreadId = think_posts.ThreadID')
            ->where($posts_data)
            ->field('count(*) as num')
            ->limit(1)
            ->find();
        unset($posts,$posts_data);
        return $postslist['num'];
    }


}
