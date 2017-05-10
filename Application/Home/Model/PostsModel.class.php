<?php
namespace Home\Model;
use Think\Model;

class PostsModel extends Model{

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
    public function pagepostslist($pages = 1,$threadid=0,$pagesize = 10){
        $posts = M('posts');
        $posts_data['PostID'] = array('gt',0);
        $posts_data['ThreadID'] = array('eq',$threadid);
        $count = $posts->where($posts_data)->count();
        $postslist['count'] = $count;
        $Page = new \Think\Page($count,$pagesize);
        $postslist['list'] = $posts->where($posts_data)->order('PostID asc')->page($pages.','.$Page->listRows)->select();
        $objPage = array('id'=>$threadid);
        $postslist['pagefooter'] = showpage($pages,$count,$objPage);
        unset($posts,$posts_data,$count,$Page,$objPage);
        return $postslist;
    }

}
